<?php

namespace App\Http\Controllers\Backend;

use App\Exports\WorkshopRegistrationExport;
use App\Http\Controllers\Controller;
use App\Jobs\SendWorkshopReceiptJob;
use App\Mail\Workshop\Registration\{RegistrationMail, AcceptMail, RejectMail, UserRegistrationMail, RegistrationByAdminMail};
use App\Models\{WorkshopRegistration, Workshop, UserDetail, User, WorkshopAttendance};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DB, Exception, Storage, Mail, Str, Excel, Hash;

class WorkshopRegistrationController extends Controller
{
    // =========================================== regirtant's registration section start ===========================================
    public function index()
    {
        $userDetail = UserDetail::where('user_id', auth()->user()->id)->first();
        if (empty($userDetail->member_type_id)) {
            return redirect()->route('home.editProfile')->with('delete', 'Please update your profile at first to register into workshop.');
        } else {
            $checkPayment = null;
            $workshops = Workshop::where(['approved_status' => 1, 'status' => 1])->whereNot('user_id', auth()->user()->id)->get();
            $registrations = WorkshopRegistration::where(['user_id' => auth()->user()->id, 'status' => 1])->get();
            return view('backend.workshops.registrations.show', compact('registrations', 'workshops', 'checkPayment', 'userDetail'));
        }
    }

    public function create($slug)
    {
        $workshop = Workshop::whereSlug($slug)->first();
        return view('backend.workshops.registrations.create', compact('workshop'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'workshop_id' => 'required',
                'meal_type' => 'required',
                'payment_voucher' => 'required|max:250|mimes:jpg,png,pdf',
                'transaction_id' => 'required|unique:workshop_registrations,transaction_id',
            ];

            $message = [
                'transaction_id.unique' => 'Transaction/Reference Id already exist.'
            ];
            $validated = $request->validate($rules, $message);

            $voucherName = time() . '.' . $validated['payment_voucher']->getClientOriginalExtension();
            Storage::putFileAs("public/workshop/registration/payment-voucher", $validated['payment_voucher'], $voucherName);
            $validated['payment_voucher'] = $voucherName;
            $validated['user_id'] = auth()->user()->id;
            $validated['token'] = Str::random(60);

            $workshop = Workshop::whereId($validated['workshop_id'])->first();
            $mailData = [
                'receiverName' => $workshop->organizer->fullName($workshop, 'organizer'),
                'workshopTitle' => $workshop->title,
                'senderName' => auth()->user()->fullName(auth()->user()),
            ];

            Mail::to($workshop->contact_person_email)->send(new RegistrationMail($mailData));

            WorkshopRegistration::create($validated);

            return redirect()->route('workshop-registration.index')->with('status', 'Successfully registered for workshop.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit(WorkshopRegistration $workshop_registration)
    {
        $workshop = Workshop::whereId($workshop_registration->workshop_id)->first();
        return view('backend.workshops.registrations.create', compact('workshop_registration', 'workshop'));
    }

    public function update(Request $request, WorkshopRegistration $workshop_registration)
    {
        try {
            $rules = [
                'workshop_id' => 'required',
                'meal_type' => 'required',
                'payment_voucher' => 'nullable|max:250|mimes:jpg,png,pdf',
                'transaction_id' => 'required|unique:workshop_registrations,transaction_id,' . $workshop_registration->id,
            ];

            $message = [
                'transaction_id.unique' => 'Transaction/Reference Id already exist.'
            ];
            $validated = $request->validate($rules, $message);

            if (!empty($validated['payment_voucher'])) {
                Storage::delete('public/workshop/registration/payment-voucher/' . $workshop_registration->payment_voucher);
                $voucherName = time() . '.' . $validated['payment_voucher']->getClientOriginalExtension();
                Storage::putFileAs("public/workshop/registration/payment-voucher", $validated['payment_voucher'], $voucherName);
                $validated['payment_voucher'] = $voucherName;
            }

            if ($workshop_registration->verified_status == 2) {
                $workshop = Workshop::whereId($validated['workshop_id'])->first();
                $mailData = [
                    'receiverName' => $workshop->organizer->fullName($workshop, 'organizer'),
                    'workshopTitle' => $workshop->title,
                    'senderName' => auth()->user()->fullName(auth()->user()),
                ];

                Mail::to($workshop->contact_person_email)->send(new RegistrationMail($mailData));
                $validated['verified_status'] = 0;
            }

            $workshop_registration->update($validated);

            return redirect()->route('workshop-registration.index')->with('status', 'Workshop registration updated successfully.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy(WorkshopRegistration $workshop_registration)
    {
        $workshop_registration->update(['status' => 0]);

        return redirect()->back()->with('delete', 'Workshop Registration deleted successfully.');
    }

    public function sendRecipt()
    {
        // $latestConference = Conference::latestConference();

        $participants = WorkshopRegistration::where('status', 1)->get();
        // $amountInWord = $participant->amount;
        // dd($participants);
        foreach ($participants as $participant) {
            SendWorkshopReceiptJob::dispatch($participant);
        }
    }

    public function createInternational($id, $price)
    {
        $workshop = Workshop::whereId($id)->first();

        $deadline = Carbon::parse($workshop->registration_deadline);
        if ($deadline->isPast()) {
            return redirect()->back()->with('delete', 'Workshop Regisration date has ended.');
        }
        $data = [
            'workshop_id' => $id,
            'amount' => $price
        ];
        session(['workshopOnlinePayment' => $data]);

        $form = '<form id="paymentForm" action="https://merchant.conference.san.org.np/payment_request.php" method="GET">
                    <input type="hidden" name="formID" value="92921030145569">
                    <input type="hidden" name="api_key" value="2a034872345a4601a706b52e4e00277e">
                    <input type="hidden" name="merchant_id" value="9104331525">
                    <input type="hidden" name="input_currency" value="USD">
                    <input type="hidden" name="input_amount" value="' . $price . '">
                    <input type="hidden" name="input_3d" value="Y">
                    <input type="hidden" name="success_url" value="https://conference.san.org.np/dash/workshop-registration/international-payment-result/success-process">
                    <input type="hidden" name="fail_url" value="https://conference.san.org.np/dash/workshop-registration/international-payment-result/fail">
                    <input type="hidden" name="cancel_url" value="https://conference.san.org.np/dash/workshop-registration/international-payment-result/cancel">
                    <input type="hidden" name="backend_url" value="https://conference.san.org.np/dash/workshop-registration/international-payment-result/backend">
                    <input type="hidden" name="simple_spc" value="92921030145569">
                </form>
                <script type="text/javascript">document.getElementById("paymentForm").submit();</script>';

        return $form;
    }

    public function internationalPaymentResultSuccessProcess(Request $request)
    {
        $orderNo  = $request->orderNo;
        $inquiry = 'https://merchant.conference.san.org.np/inquiry_request_workshop.php?orderno=' . $orderNo;
        return redirect($inquiry);
    }

    public function internationalPaymentResultSuccess(Request $request)
    {
        $data = $request->query('data');

        // Decode the URL-encoded string
        $decodedData = urldecode($data);

        // Convert the JSON string back to a PHP array or object
        $responseObject = json_decode($decodedData);
        $transactionId = $responseObject->response->Data[0]->PspReferenceNo;
        return view('backend.workshops.registrations.international-payment-success', compact('transactionId'));
    }

    public function onlinePaymentSubmit(Request $request)
    {
        try {
            $rules = [
                'workshop_id' => 'required',
                'meal_type' => 'required',
                'amount' => 'required',
                'transaction_id' => 'required|unique:workshop_registrations,transaction_id',
            ];

            $message = [
                'transaction_id.unique' => 'Transaction/Reference Id already exist.'
            ];
            $validated = $request->validate($rules, $message);
            $authUser = auth()->user();

            $validated['user_id'] = auth()->user()->id;
            $validated['token'] = Str::random(60);
            $amountInWord = $this->numberToWord($validated['amount']);
            $date = \Carbon\Carbon::now()->format('F j, Y');
            $workshop = Workshop::whereId($validated['workshop_id'])->first();
            $userMailData = [
                'name' => $authUser->namePrefix->prefix . ' ' . $authUser->fullName($authUser),
                'workshopTitle' => $workshop->title,
                'email' => $authUser->email,
                'paymentType' => 'Card Payment',
                'transactionId' => $validated['transaction_id'],
                'amount' => $validated['amount'],
                'amountInWord' => $amountInWord,
                'date' => $date
            ];

            Mail::to($authUser->email)->send(new UserRegistrationMail($userMailData));
            // $mailData = [
            //     'receiverName' => $workshop->organizer->fullName($workshop, 'organizer'),
            //     'workshopTitle' => $workshop->title,
            //     'senderName' => auth()->user()->fullName(auth()->user()),
            // ];

            // Mail::to($workshop->contact_person_email)->send(new RegistrationMail($mailData));

            WorkshopRegistration::create($validated);

            request()->session()->forget('workshopOnlinePayment');

            return redirect()->route('workshop-registration.index')->with('status', 'Successfully registered for workshop.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function internationalPaymentResultFail(Request $request)
    {
        $checkPayment = 'failed';
        $workshops = Workshop::where(['approved_status' => 1, 'status' => 1])->whereNot('user_id', auth()->user()->id)->get();
        $registrations = WorkshopRegistration::where(['user_id' => auth()->user()->id, 'status' => 1])->get();
        return view('backend.workshops.registrations.show', compact('registrations', 'workshops', 'checkPayment'));
        // $transactionId = $request->orderNo;
        // return view('backend.workshops.registrations.international-payment-success', compact('transactionId'));
    }

    public function internationalPaymentResultCancel(Request $request)
    {
        $checkPayment = 'cancelled';
        $workshops = Workshop::where(['approved_status' => 1, 'status' => 1])->whereNot('user_id', auth()->user()->id)->get();
        $registrations = WorkshopRegistration::where(['user_id' => auth()->user()->id, 'status' => 1])->get();
        return view('backend.workshops.registrations.show', compact('registrations', 'workshops', 'checkPayment'));
    }

    public function internationalPaymentResultBackend()
    {
        $checkPayment = 'terminated';
        $workshops = Workshop::where(['approved_status' => 1, 'status' => 1])->whereNot('user_id', auth()->user()->id)->get();
        $registrations = WorkshopRegistration::where(['user_id' => auth()->user()->id, 'status' => 1])->get();
        return view('backend.workshops.registrations.show', compact('registrations', 'workshops', 'checkPayment'));
    }

    // =========================================== regirtant's registration section end ===========================================

    // =========================================== regirtant's verification section start ===========================================
    public function registrants($slug)
    {
        $workshop = Workshop::whereSlug($slug)->first();
        $registrations = WorkshopRegistration::where(['workshop_id' => $workshop->id, 'status' => 1])->get();
        return view('backend.workshops.registrations.registrants', compact('registrations', 'workshop'));
    }

    public function verifyForm(Request $request)
    {
        $registration = WorkshopRegistration::where('id', $request->id)->first();
        return view('backend.workshops.registrations.verify-registrant', compact('registration'));
    }

    public function verify(Request $request)
    {
        try {
            $rules = [
                'verified_status' => 'required',
            ];

            if ($request->verified_status == 2) {
                $rules['remarks'] = 'required';
            }

            $validated = $request->validate($rules);

            $type = 'success';
            $workshopRegistration = WorkshopRegistration::whereId($request->id)->first();

            $mailData = [
                'name' => $workshopRegistration->user->namePrefix->prefix . ' ' . $workshopRegistration->user->fullName($workshopRegistration, 'user'),
                'workshopTitle' => $workshopRegistration->workshop->title,
            ];

            if ($request->verified_status == 1) {
                Mail::to($workshopRegistration->user->email)->send(new AcceptMail($mailData));
                $message = 'Registrant Accepted Successfully.';
            } else {
                $mailData['remarks'] = $validated['remarks'];
                Mail::to($workshopRegistration->user->email)->send(new RejectMail($mailData));
                $message = 'Registrant Rejected Successfully.';
            }
            $workshopRegistration->update($validated);
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }
    // =========================================== regirtant's verification section end ===========================================

    public function excelExport($id)
    {
        // dd($id);
        $workshop = Workshop::whereId($id)->first();
        $fileName = $workshop->title . '-Registrants.xlsx';
        return Excel::download(new WorkshopRegistrationExport($workshop), $fileName);
    }

    public function fonePay($id, $price)
    {
        $workshop = Workshop::whereId($id)->first();

        $deadline = Carbon::parse($workshop->registration_deadline);
        if ($deadline->isPast()) {
            return redirect()->back()->with('delete', 'Workshop Regisration date has ended.');
        }

        $data = [
            'id' => $id,
            'price' => $price
        ];
        session(['workshopFonePay' => $data]);

        $PID = '2107140644';
        $MD = 'P';
        $AMT = $price;
        $CRN = 'NPR';
        $DT = date('m/d/Y');
        $PRN = uniqid();
        $R1 = 'test';
        $R2 = 'test';
        $RU = 'https://conference.san.org.np/dash/workshop-registration/fone-pay/success';
        $RU = route('workshop-registration.fonePaySuccess');
        $sharedSecretKey = '24df2c69e4f44f2bb6dd704a942b5050';
        $DV = hash_hmac('sha512', $PID . ',' . $MD . ',' . $PRN . ',' . $AMT . ',' . $CRN . ',' . $DT . ',' . $R1 . ',' . $R2 . ',' . $RU, $sharedSecretKey);

        $form = '<form id="paymentForm" action="https://clientapi.fonepay.com/api/merchantRequest" method="GET">
                    <input type="hidden" name="PID" value="' . $PID . '">
                    <input type="hidden" name="MD" value="' . $MD . '">
                    <input type="hidden" name="AMT" value="' . $AMT . '">
                    <input type="hidden" name="CRN" value="' . $CRN . '">
                    <input type="hidden" name="DT" value="' . $DT . '">
                    <input type="hidden" name="R1" value="' . $R1 . '">
                    <input type="hidden" name="R2" value="' . $R2 . '">
                    <input type="hidden" name="DV" value="' . $DV . '">
                    <input type="hidden" name="RU" value="' . $RU . '">
                    <input type="hidden" name="PRN" value="' . $PRN . '">
                </form>
                <script type="text/javascript">document.getElementById("paymentForm").submit();</script>';

        return $form;
    }

    public function fonePaySuccess(Request $request)
    {
        if ($request->RC == 'failed' || $request->RC == 'cancel') {
            return redirect()->route('workshop-registration.index')->with('delete', 'Payment process has been failed or cancelled, please try again.');
        } else {
            $transactionId = $request->UID;
            $amount = $request->P_AMT;
            $sessionData = session()->get('workshopFonePay');
            $workshop = Workshop::whereId($sessionData['id'])->first();
            return view('backend.workshops.registrations.fone-pay-register', compact('transactionId', 'amount', 'workshop'));
        }
    }

    function numberToWord($num = '')
    {
        $num    = (string) ((int) $num);

        if ((int) ($num) && ctype_digit($num)) {
            $words  = array();

            $num    = str_replace(array(',', ' '), '', trim($num));

            $list1  = array(
                '',
                'one',
                'two',
                'three',
                'four',
                'five',
                'six',
                'seven',
                'eight',
                'nine',
                'ten',
                'eleven',
                'twelve',
                'thirteen',
                'fourteen',
                'fifteen',
                'sixteen',
                'seventeen',
                'eighteen',
                'nineteen'
            );

            $list2  = array(
                '',
                'ten',
                'twenty',
                'thirty',
                'forty',
                'fifty',
                'sixty',
                'seventy',
                'eighty',
                'ninety',
                'hundred'
            );

            $list3  = array(
                '',
                'thousand',
                'million',
                'billion',
                'trillion',
                'quadrillion',
                'quintillion',
                'sextillion',
                'septillion',
                'octillion',
                'nonillion',
                'decillion',
                'undecillion',
                'duodecillion',
                'tredecillion',
                'quattuordecillion',
                'quindecillion',
                'sexdecillion',
                'septendecillion',
                'octodecillion',
                'novemdecillion',
                'vigintillion'
            );

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num    = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds   = (int) ($num_part / 100);
                $hundreds   = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $tens       = (int) ($num_part % 100);
                $singles    = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int) ($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words  = implode(', ', $words);

            $words  = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words  = str_replace(',', ' and', $words);
            }

            return $words;
        } else if (!((int) $num)) {
            return 'Zero';
        }
        return '';
    }

    public function submitData(Request $request)
    {
        // dd($request);

        try {
            $rules = [
                'workshop_id' => 'required',
                'transaction_id' => 'required|unique:workshop_registrations,transaction_id',
                'amount' => 'required',
                'meal_type' => 'required'
            ];

            $validated = $request->validate($rules);

            $authUser = auth()->user();

            $validated['payment_voucher'] = 'Fone-Pay';
            $validated['user_id'] = $authUser->id;
            $validated['token'] = Str::random(60);
            $amountInWord = $this->numberToWord($validated['amount']);
            $date = \Carbon\Carbon::now()->format('F j, Y');

            $workshop = Workshop::whereId($validated['workshop_id'])->first();
            $userMailData = [
                'name' => $authUser->namePrefix->prefix . ' ' . $authUser->fullName($authUser),
                'workshopTitle' => $workshop->title,
                'email' => $authUser->email,
                'paymentType' => 'FonePay',
                'transactionId' => $validated['transaction_id'],
                'amount' => $validated['amount'],
                'amountInWord' => $amountInWord,
                'date' => $date
            ];

            Mail::to($authUser->email)->send(new UserRegistrationMail($userMailData));

            // $mailData = [
            //     'receiverName' => $workshop->organizer->namePrefix->prefix . ' ' . $workshop->organizer->fullName($workshop, 'organizer'),
            //     'workshopTitle' => $workshop->title,
            //     'senderName' => $authUser->namePrefix->prefix . ' ' . $authUser->fullName($authUser),
            // ];
            // Mail::to($workshop->contact_person_email)->send(new RegistrationMail($mailData));

            WorkshopRegistration::create($validated);
            session()->forget('workshopFonePay');

            return redirect()->route('workshop-registration.index')->with('status', 'Successfully registered for workshop.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function registrationByAdmin()
    {
        $workshops = Workshop::where(['approved_status' => 1, 'status' => 1])->get();
        $countries = DB::table('countries')->get();
        return view('backend.workshops.registrations.registration', compact('workshops', 'countries'));
    }

    public function registrationByAdminSubmit(Request $request)
    {
        try {
            $checkUser = User::whereEmail($request->email)->first();
            $rules = [
                'workshop_id' => 'required',
                'name_prefix_id' => 'required',
                'f_name' => 'required',
                'm_name' => 'nullable',
                'l_name' => 'required',
                'phone' => 'required',
                'institute_name' => 'required',
                'address' => 'required',
                'affiliation' => 'required',
                'delegate' => 'required',
                'member_type_id' => 'required',
                'payment_voucher' => 'nullable|mimes:jpg,png,pdf|max:250',
                'council_number' => 'required',
                'transaction_id' => 'required|unique:workshop_registrations,transaction_id',
            ];
            if (empty($checkUser)) {
                $rules['email'] = 'required|email|unique:users,email';
            } else {
                $rules['email'] = 'required|email';
            }

            if ($request->delegate == "International") {
                $rules['country_id'] = 'required';
            }

            $validated = $request->validate($rules);

            // for values start
            $password = Str::random(8);
            $validated['password'] = Hash::make($password);

            $validated['token'] = Str::random(60);
            $validated['verified_status'] = 1;
            $validated['role'] = 2;

            if (!empty($validated['payment_voucher'])) {
                $voucherName = time() . '.' . $validated['payment_voucher']->getClientOriginalExtension();
                Storage::putFileAs("public/workshop/registration/payment-voucher", $validated['payment_voucher'], $voucherName);
                $validated['payment_voucher'] = $voucherName;
            }
            // for values end

            unset($validated['delegate']);

            $workshop = Workshop::whereId($request->workshop_id)->first();
            $mailData = [
                'name' => $request->f_name . ' ' . $request->m_name . ' ' . $request->l_name,
                'workshopTitle' => $workshop->title,
                'password' => $password,
                'email' => $request->email,
                'type' => 1,
            ];

            Mail::to($request->email)->send(new RegistrationByAdminMail($mailData));

            DB::beginTransaction();
            if (empty($checkUser)) {
                // insert table-1
                $storeUser = User::create($validated);

                $validated['user_id'] = $storeUser->id;

                // insert table-2
                if (!empty($validated['image'])) {
                    $imageName = time() . '.' . $validated['image']->getClientOriginalExtension();
                    Storage::putFileAs("public/users", $validated['image'], $imageName);
                    $validated['image'] = $imageName;
                }
                UserDetail::create($validated);
            } else {
                $validated['user_id'] = $checkUser->id;
            }

            // insert table-3
            WorkshopRegistration::create($validated);
            DB::commit();

            return redirect()->back()->with('status', 'Successfully registered.');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function generateCertificate($id)
    {
        $participant = WorkshopRegistration::where('id', $id)->first();

        if ($participant->workshop_id == 2) {
            return view('backend.workshops.registrations.certificates.urogynaecology', compact('participant'));
        } else {
            if ($participant->workshop_id == 3) {
                return view('backend.workshops.registrations.certificates.others', compact('participant'));
            } else {
                return redirect()->back()->with('delete', 'Certificate will be available soon.');
            }
        }
    }

    public function generateIndividualPass(WorkshopRegistration $workshopRegistration)
    {
        $participant = $workshopRegistration;

        return view('backend.workshops.registrations.individual-pass', compact('participant'));
        $customPaper = array(0, 0, 1400, 1600);
        $pdf = PDF::loadView('backend.workshops.registrations.individual-pass', compact('participant'))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function generatePass($id)
    {
        $participants = WorkshopRegistration::where(['workshop_id' => $id, 'verified_status' => 1, 'workshop_registrations.status' => 1])
            ->join('users', 'workshop_registrations.user_id', '=', 'users.id')
            ->orderBy('users.f_name', 'asc')
            ->get();

        return view('backend.workshops.registrations.pass', compact('participants'));
        $customPaper = array(0, 0, 1400, 1600);
        $pdf = PDF::loadView('backend.workshops.registrations.pass', compact('participants'))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function participantProfile($token)
    {
        $participant = WorkshopRegistration::where('token', $token)->first();
        return view('backend.workshops.registrations.attendance-profile', compact('participant'));
    }

    public function takeAttendance(Request $request)
    {
        try {
            if ($request->type == 'in') {
                $data['workshop_registration_id'] = $request->id;
                $data['in'] = now();
                WorkshopAttendance::create($data);
            } else {
                $workshopAttendance = WorkshopAttendance::whereDate('created_at', date('Y-m-d'))->first();
                $data['out'] = now();
                $workshopAttendance->update($data);
            }

            return redirect()->back()->with('status', 'Attendance done successfully.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function registrationForSignedUpUsers()
    {
        $workshops = Workshop::where(['approved_status' => 1, 'status' => 1])->get();
        $users = User::where(['role' => 2, 'status' => 1])->orderBy('f_name', 'ASC')->get();
        return view('backend.workshops.registrations.registration-for-signed-up-users', compact('workshops', 'users'));
    }

    public function registrationForSignedUpUsersSubmit(Request $request)
    {
        try {
            $rules = [
                'workshop_id' => 'required',
                'user_id' => 'required',
                'transaction_id' => 'required',
                'amount' => 'required',
                'payment_voucher' => 'nullable|mimes:jpg,png,pdf|max:250'
            ];

            $validated = $request->validate($rules);

            $checkUserRegistrationInWorkshop = WorkshopRegistration::where(['workshop_id' => $request->workshop_id, 'user_id' => $request->user_id, 'status' => 1])->first();

            if (empty($checkUserRegistrationInWorkshop)) {
                $validated['token'] = Str::random(60);
                $validated['verified_status'] = 1;

                if (!empty($validated['payment_voucher'])) {
                    $voucherName = time() . '.' . $validated['payment_voucher']->getClientOriginalExtension();
                    Storage::putFileAs("public/workshop/registration/payment-voucher", $validated['payment_voucher'], $voucherName);
                    $validated['payment_voucher'] = $voucherName;
                }
                // dd('dad');

                DB::beginTransaction();

                $user = User::whereId($request->user_id)->first();
                $workshop = Workshop::whereId($request->workshop_id)->first();
                $amountInWord = $this->numberToWord($validated['amount']);
                $date = \Carbon\Carbon::now()->format('F j, Y');
                $mailData = [
                    'name' => $user->fullName($user),
                    'workshopTitle' => $workshop->title,
                    'email' => $user->email,
                    'type' => 2,
                    'paymentType' => 'Online Payment',
                    'transactionId' => $validated['transaction_id'],
                    'amount' => $validated['amount'],
                    'amountInWord' => $amountInWord,
                    'date' => $date,
                    'country' => $user->userDetail->country_id

                ];
                // dd($mailData);

                Mail::to($user->email)->send(new RegistrationByAdminMail($mailData));

                WorkshopRegistration::create($validated);

                DB::commit();

                return redirect()->back()->with('status', 'Successfully registered.');
            } else {
                return redirect()->back()->withInput()->with('delete', 'User already registered for this workshop.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
