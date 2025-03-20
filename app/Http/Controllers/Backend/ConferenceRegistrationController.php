<?php

namespace App\Http\Controllers\Backend;

use App\Exports\ConferenceRegisrationIndian;
use App\Exports\ConferenceRegistrationExport;
use App\Http\Controllers\Controller;
use App\Jobs\SendReceiptJob;
use App\Mail\Conference\{RegistrantAcceptMail, RegistrantRejectMail, RegistrationMail, RegistrantCorrectionMail, RegistrationByUserMail, RegistrationInExceptionalCaseMail};
use App\Models\{ConferenceRegistration, MemberTypePrice, UserDetail, Conference, User, Submission, Signature, AccompanyPerson, Attendance, Meal, MemberType};
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Swap\Laravel\Facades\Swap;
use Exception, Str, Storage, Mail, DB, Hash, Excel;
use Illuminate\Support\Facades\Http;
use DomPDF;

class ConferenceRegistrationController extends Controller
{
    // =========================================== Registrant's Section Start ===========================================
    public function index()
    {
        $latestConference = Conference::latestConference();
        $registrations = ConferenceRegistration::where(['user_id' => auth()->user()->id, 'status' => 1])->get();
        $conference_registration = ConferenceRegistration::where(['user_id' => auth()->user()->id, 'conference_id' => $latestConference->id, 'status' => 1])->first();
        return view('backend.conferences.registrations.show', compact('registrations', 'conference_registration'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function exportIndian()
    {
        return Excel::download(new ConferenceRegisrationIndian(), 'conference_registration_indian.xlsx');
    }
    public function create()
    {
        $checkPayment = null;
        $userDetail = UserDetail::where('user_id', auth()->user()->id)->first();
        if (empty($userDetail->member_type_id)) {
            return redirect()->route('home.editProfile')->with('delete', 'Please update your profile at first to register into conference.');
        } else {
            $latestConference = Conference::latestConference();
            $memberTypePrice = MemberTypePrice::where(['conference_id' => @$latestConference->id, 'member_type_id' => $userDetail->member_type_id])->first();
            if ($userDetail->country->country_name == 'India') {
                return view('backend.conferences.registrations.create-india', compact('memberTypePrice', 'latestConference', 'checkPayment'));
            } else {
                return view('backend.conferences.registrations.create', compact('memberTypePrice', 'latestConference', 'checkPayment'));
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $latestConference = Conference::latestConference();

            if ($latestConference->regular_registration_deadline < date('Y-m-d')) {
                return redirect()->back()->with('delete', 'Registration deadline has been ended.');
            } else {
                $checkDuplicateRegistration = ConferenceRegistration::where(['user_id' => auth()->user()->id, 'conference_id' => $latestConference->id, 'status' => 1])->first();
                if (empty($checkDuplicateRegistration)) {
                    $rules = [
                        'total_attendee' => 'nullable|numeric',
                        'registrant_type' => 'required',
                        'meal_type' => 'required',
                        'payment_voucher' => 'required|mimes:jpg,png,pdf|max:250',
                        'transaction_id' => 'required|unique:conference_registrations,transaction_id'
                    ];

                    if ($request->registrant_type == 2) {
                        $rules['description'] = 'required';
                    }

                    if ($request->total_attendee >= 1) {
                        $rules['person_name.*'] = 'required';
                    }

                    $message = [
                        'transaction_id.unique' => 'Transaction/Reference Id already exist.',
                        'person_name.*.required' => 'Each person name is required.',
                    ];
                    $validated = $request->validate($rules, $message);

                    $authUser = auth()->user();
                    $validated['user_id'] = $authUser->id;
                    $validated['conference_id'] = $latestConference->id;
                    $validated['total_attendee'] = empty($request->total_attendee) ? 1 : $request->total_attendee + 1;
                    $validated['token'] = Str::random(60);

                    $voucherName = time() . '.' . $validated['payment_voucher']->getClientOriginalExtension();
                    Storage::putFileAs("public/conference/registration/payment-voucher", $validated['payment_voucher'], $voucherName);
                    $validated['payment_voucher'] = $voucherName;

                    $mailData = [
                        'conference_theme' => $latestConference->conference_theme,
                        'namePrefix' => $authUser->namePrefix->prefix,
                        'name' => $authUser->fullName($authUser),
                        'email' => $authUser->email,
                    ];

                    Mail::to($authUser->email)->send(new RegistrationByUserMail($mailData));

                    DB::beginTransaction();
                    $registration = ConferenceRegistration::create($validated);

                    if ($request->total_attendee >= 1) {
                        $insertArray = [];
                        foreach ($validated['person_name'] as $key => $value) {
                            $array['conference_registration_id'] = $registration->id;
                            $array['person_name'] = $value;
                            $array['created_at'] = now();
                            $array['updated_at'] = now();
                            $insertArray[] = $array;
                        }
                        AccompanyPerson::insert($insertArray);
                    }
                    DB::commit();
                    return redirect()->route('conference-registration.index')->with('status', 'Successfully registered to conference.');
                } else {
                    return redirect()->back()->with('delete', 'Registration already done for current conference.');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Request $request)
    {
        $registrant = ConferenceRegistration::whereId($request->id)->first();
        return view('backend.conferences.registrations.view-data-modal', compact('registrant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConferenceRegistration $conference_registration)
    {
        $checkPayment = null;
        if (auth()->user()->id != $conference_registration->user_id) {
            return redirect()->back()->with('delete', 'Access Denied');
        } else {
            $userDetail = UserDetail::where('user_id', auth()->user()->id)->first();
            $latestConference = Conference::latestConference();
            $memberTypePrice = MemberTypePrice::where(['conference_id' => @$latestConference->id, 'member_type_id' => $userDetail->member_type_id])->first();
            return view('backend.conferences.registrations.create', compact('conference_registration', 'latestConference', 'memberTypePrice', 'checkPayment'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConferenceRegistration $conference_registration)
    {
        try {
            $rules = [
                'total_attendee' => 'nullable|numeric',
                'registrant_type' => 'required',
                'meal_type' => 'required',
                'payment_voucher' => 'nullable|mimes:jpg,png,pdf|max:250',
                'transaction_id' => 'required|unique:conference_registrations,transaction_id,' . $conference_registration->id
            ];

            if ($request->registrant_type == 2) {
                $rules['description'] = 'required';
            }

            if ($request->total_attendee >= 1) {
                $rules['person_name.*'] = 'required';
            }

            $message = [
                'transaction_id.unique' => 'Transaction/Reference Id already exist.',
                'person_name.*.required' => 'Each person name is required.',
            ];
            $validated = $request->validate($rules, $message);

            $validated['total_attendee'] = empty($request->total_attendee) ? 1 : $request->total_attendee + 1;
            $validated['token'] = Str::random(60);
            $validated['verified_status'] = 0;

            if (!empty($validated['payment_voucher'])) {
                Storage::delete('public/conference/registration/payment-voucher/' . $conference_registration->payment_voucher);
                $voucherName = time() . '.' . $validated['payment_voucher']->getClientOriginalExtension();
                Storage::putFileAs("public/conference/registration/payment-voucher", $validated['payment_voucher'], $voucherName);
                $validated['payment_voucher'] = $voucherName;
            }

            DB::beginTransaction();
            $conference_registration->update($validated);

            if ($request->total_attendee >= 1) {
                if (!empty($conference_registration->accompanyPersons->where('status', 1))) {
                    $idArray = $conference_registration->accompanyPersons->where('status', 1)->pluck('id')->toArray();
                    AccompanyPerson::whereIn('id', $idArray)->delete();
                }
                $insertArray = [];
                foreach ($validated['person_name'] as $key => $value) {
                    $array['conference_registration_id'] = $conference_registration->id;
                    $array['person_name'] = $value;
                    $array['created_at'] = now();
                    $array['updated_at'] = now();
                    $insertArray[] = $array;
                }
                AccompanyPerson::insert($insertArray);
            }
            DB::commit();

            return redirect()->route('conference-registration.index')->with('status', 'Registration updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConferenceRegistration $conference_registration)
    {
        $conference_registration->update(['status' => 0]);

        return redirect()->back()->with('delete', 'Conference Registration Deleted Successfully');
    }

    public function chooseRegistrantType(Request $request)
    {
        $latestConference = Conference::latestConference();

        $checkSubmission = Submission::where(['user_id' => auth()->user()->id, 'conference_id' => $latestConference->id, 'status' => 1])->first();

        if (empty($checkSubmission)) { 
            $checkSubmissionValue = 'not-submitted';
        } else {
            $checkSubmissionValue = 'submitted';
        }
        return response()->json(['checkSubmission' => $checkSubmissionValue]);
    }

    public function onlinePayment(Request $request)
    {

        $latestConference = Conference::latestConference();

        $deadline = Carbon::parse($latestConference->regular_registration_deadline);
        if ($deadline->isPast()) {
            return redirect()->back()->with('delete', 'Conference Regisration date has ended.');
        }
        
        session(['onlinePayment' => $request->all()]);

        // $form = '<form id="paymentForm" action="https://merchant.omwaytechnologies.com/payment_request.php" method="GET">
        $form = '<form id="paymentForm" action="https://merchant.conference.san.org.np/payment_request.php" method="GET">
                    <input type="hidden" name="formID" value="92921030145569">
                    <input type="hidden" name="api_key" value="2a034872345a4601a706b52e4e00277e">
                    <input type="hidden" name="merchant_id" value="9104331525">
                    <input type="hidden" name="input_currency" value="USD">
                    <input type="hidden" name="input_amount" value="' . $request->amount . '">
                    <input type="hidden" name="input_3d" value="Y">
                    <input type="hidden" name="success_url" value="https://conference.san.org.np/dash/conference-registration/international-payment-result/success-process">
                    <input type="hidden" name="fail_url" value="https://conference.san.org.np/dash/conference-registration/international-payment-result/fail">
                    <input type="hidden" name="cancel_url" value="https://conference.san.org.np/dash/conference-registration/international-payment-result/cancel">
                    <input type="hidden" name="backend_url" value="https://conference.san.org.np/dash/conference-registration/international-payment-result/backend">
                    <input type="hidden" name="simple_spc" value="92921030145569">
                </form>
                <script type="text/javascript">document.getElementById("paymentForm").submit();</script>';
        return $form;
    }

    public function internationalPaymentResultSuccessProcess(Request $request)
    {
        $orderNo  = $request->orderNo;
        $inquiry = 'https://merchant.conference.san.org.np/inquiry_request.php?orderno=' . $orderNo;
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
        return view('backend.conferences.registrations.international-payment-success', compact('transactionId'));
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

    public function onlinePaymentSubmit(Request $request)
    {
        // $pdf = DomPDF::loadView('emails.conference.payment-voucher', ['data' => ['paymentType' => 'FonePay']])
        //     ->setPaper('legal', 'potrait');
        // return $pdf->stream('payment-voucher.pdf');
        try {
            $latestConference = Conference::latestConference();

            if ($latestConference->regular_registration_deadline < date('Y-m-d')) {
                return redirect()->back()->with('delete', 'Registration deadline has been ended.');
            } else {
                $checkDuplicateRegistration = ConferenceRegistration::where(['user_id' => auth()->user()->id, 'conference_id' => $latestConference->id, 'status' => 1])->first();
                if (empty($checkDuplicateRegistration)) {
                    $rules = [
                        'accompany_person' => 'nullable|numeric',
                        'registrant_type' => 'required',
                        // 'meal_type' => 'required',
                        'amount' => 'required',
                        'transaction_id' => 'required|unique:conference_registrations,transaction_id'
                    ];

                    // if ($request->registrant_type == 2) {
                    //     $rules['description'] = 'required';
                    // }

                    // if ($request->accompany_person >= 1) {
                    //     $rules['person_name.*'] = 'required';
                    // }

                    $message = [
                        'transaction_id.unique' => 'Transaction/Reference Id already exist.',
                        // 'person_name.*.required' => 'Each person name is required.',
                    ];
                    $validated = $request->validate($rules, $message);

                    $paymentType = null;

                    if (session()->get('fonePay')) {
                        $paymentType = 'FonePay';
                    } else {
                        $paymentType = 'Card Payment';
                    }

                    $authUser = auth()->user();
                    $validated['user_id'] = $authUser->id;
                    $validated['conference_id'] = $latestConference->id;
                    $validated['total_attendee'] = empty($request->accompany_person) ? 1 : $request->accompany_person + 1;
                    $validated['token'] = Str::random(60);
                    $validated['payment_voucher'] = $paymentType;
                    $amountInWord = $this->numberToWord($validated['amount']);
                    $date = \Carbon\Carbon::now()->format('F j, Y');
                    $mailData = [
                        'conference_theme' => $latestConference->conference_theme,
                        'name' => $authUser->fullName($authUser),
                        'namePrefix' => $authUser->namePrefix->prefix,
                        'email' => $authUser->email,
                        'paymentType' => $paymentType,
                        'transactionId' => $validated['transaction_id'],
                        'amount' => $validated['amount'],
                        'amountInWord' => $amountInWord,
                        'date' => $date
                    ];

                    Mail::to($authUser->email)->send(new RegistrationByUserMail($mailData));

                    DB::beginTransaction();
                    $registration = ConferenceRegistration::create($validated);

                    // if ($request->accompany_person >= 1) {
                    //     $insertArray = [];
                    //     foreach ($validated['person_name'] as $key => $value) {
                    //         $array['conference_registration_id'] = $registration->id;
                    //         $array['person_name'] = $value;
                    //         $array['created_at'] = now();
                    //         $array['updated_at'] = now();
                    //         $insertArray[] = $array;
                    //     }
                    //     AccompanyPerson::insert($insertArray);
                    // }

                    DB::commit();
                    request()->session()->forget('onlinePayment');
                    return redirect()->route('conference-registration.index')->with('status', 'Successfully registered to conference.');
                } else {
                    return redirect()->back()->with('delete', 'Registration already done for current conference.');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function sendRecipt()
    {
        // $latestConference = Conference::latestConference();

        $participants = ConferenceRegistration::where('status', 1)->whereIn('id', [83, 80, 79, 78, 2, 3, 4])->where('is_invited', 0)->where('created_at', '<', '2025-02-19 02:00:00')->get();
        // $amountInWord = $participant->amount;
        // dd($participants);
        foreach ($participants as $participant) {
            SendReceiptJob::dispatch($participant);
        }
    }

    public function updateRegistration(Request $request)
    {
        try {
            DB::beginTransaction();
            //code...
            $latestConference = Conference::latestConference();
            $registration = ConferenceRegistration::where(['user_id' => auth()->user()->id, 'conference_id' => $latestConference->id, 'status' => 1])->first();
            $rules = [
                'meal_type' => 'required',
            ];

            if ($registration->total_attendee > 1) {
                $rules['person_name.*'] = 'required';
            }

            if ($registration->registrant_type == 2) {
                $rules['description'] = 'required';
            }
            $message = [
                'person_name.*.required' => 'Each person name is required.',
            ];

            $validated = $request->validate($rules, $message);
            $registration->update($validated);

            if ($registration->total_attendee > 1) {
                $insertArray = [];
                foreach ($validated['person_name'] as $key => $value) {
                    $array['conference_registration_id'] = $registration->id;
                    $array['person_name'] = $value;
                    $array['created_at'] = now();
                    $array['updated_at'] = now();
                    $insertArray[] = $array;
                }
                AccompanyPerson::insert($insertArray);
            }
            DB::commit();
            return redirect()->back()->with('status', 'Successfully registered conference updated.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            // throw $e;
            return redirect()->back()->with('delete', 'Filed are required.');
        }
    }


    public function internationalPaymentResultFail(Request $request)
    {
        $checkPayment = 'failed';
        $userDetail = UserDetail::where('user_id', auth()->user()->id)->first();
        $latestConference = Conference::latestConference();
        $memberTypePrice = MemberTypePrice::where(['conference_id' => @$latestConference->id, 'member_type_id' => $userDetail->member_type_id])->first();
        return view('backend.conferences.registrations.create', compact('memberTypePrice', 'latestConference', 'checkPayment'));
        // $transactionId = $request->orderNo;
        // return view('backend.conferences.registrations.international-payment-success', compact('transactionId'));
    }

    public function internationalPaymentResultCancel(Request $request)
    {
        $checkPayment = 'cancelled';
        $userDetail = UserDetail::where('user_id', auth()->user()->id)->first();
        $latestConference = Conference::latestConference();
        $memberTypePrice = MemberTypePrice::where(['conference_id' => @$latestConference->id, 'member_type_id' => $userDetail->member_type_id])->first();
        return view('backend.conferences.registrations.create', compact('memberTypePrice', 'latestConference', 'checkPayment'));
    }

    public function internationalPaymentResultBackend()
    {
        $checkPayment = 'terminated';
        $userDetail = UserDetail::where('user_id', auth()->user()->id)->first();
        $latestConference = Conference::latestConference();
        $memberTypePrice = MemberTypePrice::where(['conference_id' => @$latestConference->id, 'member_type_id' => $userDetail->member_type_id])->first();
        return view('backend.conferences.registrations.create', compact('memberTypePrice', 'latestConference', 'checkPayment'));
    }

    public function fonePay(Request $request)
    {
        $latestConference = Conference::latestConference();

        $deadline = Carbon::parse($latestConference->regular_registration_deadline);
        if ($deadline->isPast()) {
            return redirect()->back()->with('delete', 'Conference Regisration date has ended.');
        }

        session(['fonePay' => $request->all()]);

        $PID = '2107140644';
        $MD = 'P';
        $AMT = $request->amount;
        $CRN = 'NPR';
        $DT = date('m/d/Y');
        $PRN = uniqid();
        $R1 = 'test';
        $R2 = 'test';
        $RU = 'https://conference.san.org.np/dash/conference-registration/fone-pay/success';
        $RU = route('conference-registration.fonePaySuccess');
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
            return redirect()->route('conference-registration.create')->with('delete', 'Payment process has been failed or cancelled, please try again.');
        } else {
            $transactionId = $request->UID;
            $amount = $request->P_AMT;
            return view('backend.conferences.registrations.national-payment-success', compact('transactionId', 'amount'));
        }
    }

    public function convertUsdToInr(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Converted Successfully';

            // $rate = Swap::latest('USD/INR')->getValue();
            // using nepal rastriya bank api
            // $rate = 85.884499;
            $data = [
                'page' => 1,
                'per_page' => 10,
                'from' => date('Y-m-d'),
                'to' => date('Y-m-d')
            ];
            $currencyExchange = Http::get('https://www.nrb.org.np/api/forex/v1/rates/', $data);
            if ($currencyExchange->successful()) {
                $USDRateSell = $currencyExchange->json()['data']['payload'][0]['rates'][1]['sell'];
                // $USDRateBuy = $currencyExchange->json()['data']['payload'][0]['rates'][1]['buy'];
                // dd(floatval($USDRateSell) / 1.6, floatval($USDRateBuy) / 1.6, $rate);
                $rate = floatval($USDRateSell) / 1.6;
                $convertedAmount = $rate * intval($request->usd);
                if ($request->paymentMode == "sbiBank") {
                    $amount = ceil($convertedAmount);
                } else {
                    $amount = ceil(0.0165 * $convertedAmount + $convertedAmount);
                }
            } else {
                throw new Exception("Error Processing Request", 1);
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = 'Error in QR Scan.';
            $amount = null;
        }
        return response()->json(['type' => $type, 'message' => $message, 'amount' => $amount]);
    }
    // =========================================== Registrant's Section End ===========================================

    // =========================================== Admin's Section Start ===========================================
    public function participants($type)
    {
        $latestConference = Conference::latestConference();
        if ($type == 'attendees') {
            $registrants = ConferenceRegistration::where(['conference_id' => @$latestConference->id, 'registrant_type' => 1, 'is_invited' => 0, 'status' => 1])->latest()->get();
        } elseif ($type == 'speakers') {
            $registrants = ConferenceRegistration::where(['conference_id' => @$latestConference->id, 'registrant_type' => 2, 'is_invited' => 0, 'status' => 1])->latest()->get();
        } elseif ($type == 'invited-attendees') {
            $registrants = ConferenceRegistration::where(['conference_id' => @$latestConference->id, 'registrant_type' => 1, 'is_invited' => 1, 'status' => 1])->latest()->get();
        } elseif ($type == 'invited-speakers') {
            $registrants = ConferenceRegistration::where(['conference_id' => @$latestConference->id, 'registrant_type' => 2, 'is_invited' => 1, 'status' => 1])->latest()->get();
        }
        $memberTypes = MemberType::where('status', 1)->get();
        return view('backend.conferences.registrations.participants', compact('registrants', 'type', 'memberTypes'));
    }

    public function getDelegateType(Request $request)
    {
        $type = $request->selected;

        $memberType = MemberType::where([
            'delegate' => $type == 1 ? 'National' : 'International',
            'status' => 1
        ])->get();

        return response()->json(['memberTypes' => $memberType]);
    }


    public function verifyForm(Request $request)
    {
        $registration = ConferenceRegistration::whereId($request->id)->first();
        return view('backend.conferences.registrations.verify', compact('registration'));
    }

    public function verifyRegistrant(Request $request, ConferenceRegistration $conference_registration)
    {
        try {
            $rules = [
                'verified_status' => 'required',
            ];

            if ($request->verified_status == 2) {
                $rules['remarks'] = 'required';
            }
            $validated = $request->validate($rules);

            $conference_registration = ConferenceRegistration::whereId($request->id)->first();
            $data = [
                'name' => $conference_registration->user->fullName($conference_registration, 'user'),
                'namePrefix' => $conference_registration->user->namePrefix->prefix,
                'conference_theme' => $conference_registration->conference->conference_theme,
                'registrant_type' => $conference_registration->registrant_type,
            ];

            if ($request->verified_status == 1) {
                Mail::to($conference_registration->user->email)->send(new RegistrantAcceptMail($data));

                $conference_registration->update($validated);
            } else {
                $data['remarks'] = $validated['remarks'];
                Mail::to($conference_registration->user->email)->send(new RegistrantRejectMail($data));

                $conference_registration->update($validated);
            }

            $type = 'success';
            if ($conference_registration->registrant_type == '1') {
                $message = "Attendee Updated Successfully";
            } else {
                $message = "Presenter Updated Successfully";
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function registrationByAdmin()
    {
        $latestConference = Conference::latestConference();
        $countries = DB::table('countries')->get();
        return view('backend.conferences.registrations.registration', compact('countries', 'latestConference'));
    }

    public function registrationByAdminSubmit(Request $request)
    {
        try {
            $checkUser = User::whereEmail($request->email)->first();
            $rules = [
                'name_prefix_id' => 'required',
                'gender' => 'required',
                'f_name' => 'required',
                'm_name' => 'nullable',
                'l_name' => 'required',
                'phone' => 'required',
                'affiliation' => 'nullable',
                'department' => 'nullable',
                'institute_name' => 'nullable',
                'address' => 'nullable',
                'delegate' => 'required',
                'member_type_id' => 'required',
                'registrant_type' => 'required',
                'additional_guests' => 'nullable|numeric',
                'country_id' => 'required',
                'meal_type' => 'required',
                'payment_voucher' => 'nullable|mimes:jpg,png,pdf|max:250',
            ];
            if (empty($checkUser)) {
                $rules['email'] = 'required|email|unique:users,email';
            } else {
                $rules['email'] = 'required|email';
            }

            if ($request->has('invited_guest')) {
                $rules['council_number'] = 'nullable';
                $rules['transaction_id'] = 'nullable|unique:conference_registrations,transaction_id';
                $rules['amount'] = 'nullable';
            } else {
                $rules['council_number'] = 'required';
                $rules['transaction_id'] = 'required|unique:conference_registrations,transaction_id';
                $rules['amount'] = 'required|numeric';
            }

            if ($request->registrant_type == 2) {
                $rules['description'] = 'required';
            }

            if ($request->additional_guests >= 1) {
                $rules['person_name.*'] = 'required';
            }

            $message = [
                'transaction_id.unique' => 'Transaction/Reference Id already exist.',
                'person_name.*.required' => 'Each person name is required.',
            ];

            $validated = $request->validate($rules, $message);

            // for values start
            $latestConference = Conference::latestConference();
            $password = Str::random(8);
            $validated['password'] = Hash::make($password);

            if (empty($validated['additional_guests'])) {
                $validated['total_attendee'] = 1;
            } else {
                $validated['total_attendee'] = $validated['additional_guests'] + 1;
            }
            $validated['conference_id'] = $latestConference->id;
            $validated['token'] = Str::random(60);
            $validated['verified_status'] = 1;
            $validated['verified_status'] = 1;
            $validated['role'] = 2;

            if (!empty($validated['payment_voucher'])) {
                $voucherName = time() . '.' . $validated['payment_voucher']->getClientOriginalExtension();
                Storage::putFileAs("public/conference/registration/payment-voucher", $validated['payment_voucher'], $voucherName);
                $validated['payment_voucher'] = $voucherName;
            }
            // for values end

            $middleName = !empty($validated['m_name']) ? $validated['m_name'] . ' ' : '';
            $namePrefix = DB::table('name_prefixes')->whereId($validated['name_prefix_id'])->first()->prefix;
            $data = [
                'namePrefix' => $namePrefix,
                'name' => $validated['f_name'] . ' ' . $middleName . $validated['l_name'],
                'email' => $validated['email'],
                'conference_theme' => $latestConference->conference_theme,
                'password' => $password,
                'invitationType' => 1
            ];
            Mail::to($validated['email'])->send(new RegistrationMail($data));

            if ($request->has('invited_guest')) {
                $validated['is_invited'] = 1;
            }

            unset($validated['delegate']);
            DB::beginTransaction();
            if (empty($checkUser)) {
                // insert table-1
                $storeUser = User::create($validated);

                $validated['user_id'] = $storeUser->id;

                // insert table-2
                UserDetail::create($validated);
            } else {
                $validated['user_id'] = $checkUser->id;
            }

            // insert table-3
            $registration = ConferenceRegistration::create($validated);

            // insert table-4
            if ($request->additional_guests >= 1) {
                $insertArray = [];
                foreach ($validated['person_name'] as $key => $value) {
                    $array['conference_registration_id'] = $registration->id;
                    $array['person_name'] = $value;
                    $array['created_at'] = now();
                    $array['updated_at'] = now();
                    $insertArray[] = $array;
                }
                AccompanyPerson::insert($insertArray);
            }
            DB::commit();

            return redirect()->back()->with('status', 'Successfully registered.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function changeFeatured(ConferenceRegistration $conference_registration)
    {
        if ($conference_registration->is_featured == 1) {
            $isFeatured = 0;
        } else {
            $isFeatured = 1;
        }

        $conference_registration->update(['is_featured' => $isFeatured]);

        return redirect()->back()->with('status', 'Featured status changed successfully.');
    }

    public function registerExceptionalCase()
    {
        $latestConference = Conference::latestConference();
        $users = User::whereNot('role', 1)->doesntHave('conferenceRegistration')->get();
        return view('backend.conferences.registrations.exceptional-registration', compact('users'));
    }

    public function registerExceptionalCaseSubmit(Request $request)
    {
        try {
            $rules = [
                'user_id' => 'required',
                'registrant_type' => 'required',
                'transaction_id' => 'required|unique:conference_registrations,transaction_id',
                'amount' => 'required',
                'meal_type' => 'required',
                'additional_guests' => 'nullable|numeric',
                'payment_voucher' => 'nullable|mimes:jpg,png,pdf|max:250'
            ];

            if ($request->registrant_type == 2) {
                $rules['description'] = 'required';
            }

            if ($request->additional_guests >= 1) {
                $rules['person_name.*'] = 'required';
            }

            $message = [
                'user_id.required' => 'The user field is required.',
                'transaction_id.unique' => 'Transaction/Reference Id already exist.',
                'person_name.*.required' => 'Each person name is required.',
            ];

            $validated = $request->validate($rules, $message);

            // for values start
            $latestConference = Conference::latestConference();

            if (empty($validated['additional_guests'])) {
                $validated['total_attendee'] = 1;
            } else {
                $validated['total_attendee'] = $validated['additional_guests'] + 1;
            }
            $validated['conference_id'] = $latestConference->id;
            $validated['token'] = Str::random(60);
            $validated['verified_status'] = 1;

            if (!empty($validated['payment_voucher'])) {
                $voucherName = time() . '.' . $validated['payment_voucher']->getClientOriginalExtension();
                Storage::putFileAs("public/conference/registration/payment-voucher", $validated['payment_voucher'], $voucherName);
                $validated['payment_voucher'] = $voucherName;
            }
            // $paymentType = null;

            // if (session()->get('fonePay')) {
            //     $paymentType = 'FonePay';
            // } else {
            //     $paymentType = 'Card Payment';
            // }

            // for values end
            $amountInWord = $this->numberToWord($validated['amount']);
            $date = \Carbon\Carbon::now()->format('F j, Y');
            $user = User::whereId($validated['user_id'])->first();
            $mailData = [
                'namePrefix'  => $user->namePrefix->prefix,
                'conference_theme' => $latestConference->conference_theme,
                'name' => $user->fullName($user),
                'email' => $user->email,
                'paymentType' => 'Online Payment',
                'transactionId' => $validated['transaction_id'],
                'amount' => $validated['amount'],
                'amountInWord' => $amountInWord,
                'date' => $date,
                'country' => $user->userDetail->country_id
            ];

            Mail::to($user->email)->send(new RegistrationInExceptionalCaseMail($mailData));

            DB::beginTransaction();
            // insert table-1
            $registration = ConferenceRegistration::create($validated);

            // insert table-2
            if ($request->additional_guests >= 1) {
                $insertArray = [];
                foreach ($validated['person_name'] as $key => $value) {
                    $array['conference_registration_id'] = $registration->id;
                    $array['person_name'] = $value;
                    $array['created_at'] = now();
                    $array['updated_at'] = now();
                    $insertArray[] = $array;
                }
                AccompanyPerson::insert($insertArray);
            }
            DB::commit();

            return redirect()->back()->with('status', 'Successfully registered.');
        } catch (Exception $e) {
            throw $e;
        }
    }
    // =========================================== Admin's Section End ===========================================

    public function register()
    {
        $latestConference = Conference::latestConference();
        return view('backend.conferences.registrations.register', compact('latestConference'));
    }

    public function exportExcel(Request $request, $type)
    {
        if ($type == 'attendees') {
            $fileName = 'ConferenceAttendees.xlsx';
        } elseif ($type == 'presenters') {
            $fileName = 'ConferencePresenters.xlsx';
        } elseif ($type == 'guest-attendees') {
            $fileName = 'ConferenceGuestAttendees.xlsx';
        } elseif ($type == 'guest-presenters') {
            $fileName = 'ConferenceGuestPresenters.xlsx';
        } elseif ($type == 'all') {
            $fileName = 'AllParticipants.xlsx';
        } elseif ($type == 'national') {
            $fileName = 'NationalParticipants.xlsx';
        } elseif ($type == 'international') {
            $fileName = 'InternationalParticipants.xlsx';
        }
        $memberTypeId = $request->input('member_type');
        $voucherAttached = $request->voucher_attached;
        return Excel::download(new ConferenceRegistrationExport($type, $memberTypeId, $voucherAttached), $fileName);
    }

    public function submitData(Request $request)
    {
        try {
            $latestConference = Conference::latestConference();
            $rules = [
                'total_attendee' => 'required|numeric',
                'registrant_type' => 'required',
                'transaction_id' => 'required|unique:conference_registrations,transaction_id',
                'amount' => 'required'
            ];
            if ($request->registrant_type == 2) {
                $rules['image'] = 'required|mimes:jpg,png|max:500';
                $rules['description'] = 'required';
            }
            $validated = $request->validate($rules);

            $validated['user_id'] = auth()->user()->id;
            $validated['conference_id'] = $latestConference->id;
            $validated['remaining_dinner'] = $validated['total_attendee'];
            $validated['remaining_dinner_2'] = $validated['total_attendee'];
            $validated['remaining_dinner_3'] = $validated['total_attendee'];
            $validated['remaining_dinner_4'] = $validated['total_attendee'];
            $validated['payment_voucher'] = 'Fone-Pay';
            $validated['token'] = Str::random(60);

            DB::beginTransaction();
            ConferenceRegistration::create($validated);

            if (!empty($validated['image'])) {
                $imageName = time() . '.' . $validated['image']->getClientOriginalExtension();
                Storage::putFileAs("public/users", $validated['image'], $imageName);
                $validated['image'] = $imageName;
                $userDetail = UserDetail::whereUserId(auth()->user()->id)->first();
                $userDetail->update($validated);
            }
            DB::commit();

            return redirect()->route('conference-registration.index')->with('status', 'Successfully registered to conference.');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function convertToSpeaker()
    {
        return view('backend.dashboard.speaker-convert');
    }

    public function convertToSpeakerSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|mimes:png,jpg|max:500',
                'description' => 'required'
            ]);
            $validated['registrant_type'] = 2;
            $registration = ConferenceRegistration::whereUserId(auth()->user()->id)->first();
            $userDetal = UserDetail::whereUserId(auth()->user()->id)->first();

            // upload image
            $imageName = time() . '.' . $validated['image']->getClientOriginalExtension();
            Storage::putFileAs("public/users", $validated['image'], $imageName);
            $validated['image'] = $imageName;

            DB::beginTransaction();
            $registration->update($validated);

            $userDetal->update($validated);
            DB::commit();

            return redirect()->route('home')->with('status', 'Successfully converted to speaker.');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function sendCorrectionMailForm(Request $request)
    {
        $registration = ConferenceRegistration::whereId($request->id)->first();
        return view('backend.conferences.registrations.correction', compact('registration'));
    }

    public function sendCorrectionMailSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'remarks' => 'required',
            ]);

            $conference_registration = ConferenceRegistration::whereId($request->id)->first();
            $data = [
                'name' => $conference_registration->user->name,
                'conference_theme' => $conference_registration->conference->conference_theme,
                'remarks' => $validated['remarks']
            ];

            Mail::to($conference_registration->user->email)->send(new RegistrantCorrectionMail($data));
            $conference_registration->update($validated);

            $type = 'success';
            $message = "Mail Sent Successfully.";
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function fetchUserData(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        $userDetail = null;
        $delegate = null;
        $typeId = null;
        $countryId = null;
        if (!empty($user)) {
            $userDetail = UserDetail::whereUserId($user->id)->first();
            $delegate = $userDetail->memberType->delegate;
            $typeId = $userDetail->memberType->id;
            if ($delegate == 'International') {
                $countryId = $userDetail->country_id;
            }
        }

        return response()->json(['user' => $user, 'userDetail' => $userDetail, 'delegate' => $delegate, 'type' => $typeId, 'country' => $countryId]);
    }

    public function editAttendeesNumber(Request $request)
    {
        $registration = ConferenceRegistration::whereId($request->id)->first();
        return view('backend.conferences.registrations.edit-attendees-number', compact('registration'));
    }

    public function editAttendeesNumberSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'total_attendee' => 'required|numeric',
            ]);

            $conference_registration = ConferenceRegistration::whereId($request->id)->first();
            $validated['remaining_dinner'] = $validated['total_attendee'];
            $validated['remaining_dinner_2'] = $validated['total_attendee'];
            $validated['remaining_dinner_3'] = $validated['total_attendee'];
            $validated['remaining_dinner_4'] = $validated['total_attendee'];

            $conference_registration->update($validated);

            $type = 'success';
            $message = "Total attendee edited successfully.";
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function generateIndividualPass(ConferenceRegistration $conferenceRegistration)
    {
        // dd($conferenceRegistration);
        $participant = $conferenceRegistration;
        // return view('backend.conferences.registrations.individual-pass', compact('participant'));

        $customPaper = array(0, 0, 1400, 1600);
        $pdf = PDF::loadView('backend.conferences.registrations.individual-pass', compact('participant'))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function generatePass($type)
    {
        if ($type == 'attendees') {
            $participants = ConferenceRegistration::where(['registrant_type' => 1, 'is_invited' => 0, 'verified_status' => 1, 'conference_registrations.status' => 1])
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.f_name', 'asc')
                ->get();
        } elseif ($type == 'presenters') {
            $participants = ConferenceRegistration::where(['registrant_type' => 2, 'is_invited' => 0, 'verified_status' => 1, 'conference_registrations.status' => 1])
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.f_name', 'asc')
                ->get();
        } elseif ($type == 'guest-attendees') {
            $participants = ConferenceRegistration::where(['registrant_type' => 1, 'is_invited' => 1, 'verified_status' => 1, 'conference_registrations.status' => 1])
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.f_name', 'asc')
                ->get();
        } elseif ($type == 'guest-presenters') {
            $participants = ConferenceRegistration::where(['registrant_type' => 2, 'is_invited' => 1, 'verified_status' => 1, 'conference_registrations.status' => 1])
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.f_name', 'asc')
                ->get();
        }
        return view('backend.conferences.registrations.pass', compact('participants'));
        $customPaper = array(0, 0, 1400, 1600);
        $pdf = PDF::loadView('backend.conferences.registrations.pass', compact('participants'))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function participantProfile($token)
    {
        $participant = ConferenceRegistration::where('token', $token)->first();
        $conference = Conference::latestConference();
        return view('backend.conferences.registrations.attendance-profile', compact('participant', 'conference'));
    }

    public function takeAttendance(Request $request)
    {
        try {
            $data['conference_registration_id'] = $request->id;
            Attendance::create($data);
            return redirect()->back()->with('status', 'Attendance done successfully.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function takeMeal(Request $request)
    {
        try {
            $checkMealDataExist = Meal::where('conference_registration_id', $request->id)->whereDate('created_at', date('Y-m-d'))->first();
            if (empty($checkMealDataExist)) {
                $data['conference_registration_id'] = $request->id;
                if (date('H:i') < '16:00') {
                    $data['lunch_taken'] = 1;
                } else {
                    $data['dinner_taken'] = 1;
                }

                Meal::create($data);
            } else {
                if (date('H:i') < '16:00') {
                    $data['lunch_taken'] = $checkMealDataExist->lunch_taken + 1;
                } else {
                    $data['dinner_taken'] = $checkMealDataExist->dinner_taken + 1;
                }
                $checkMealDataExist->update($data);
            }

            return redirect()->back()->with('status', 'Meal taken successfully.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function generateCertificate($id)
    {
        $filename = 'test.pdf';
        $participant = ConferenceRegistration::where('id', $id)->first();
        $latestConference = Conference::latestConference();
        // $html = view()->make('backend.conferences.registrations.certificate-test', compact('participant'))->render();
        // $pdf = new TCPDF;

        // $pdf::SetTitle('Conference Certificate');
        // $pdf::AddPage('L', array(150, 100));
        // $pdf::writeHTML($html, true, false, true, false, "");
        // $pdf::Output(public_path($filename),"F");

        // $response = response()->download(public_path($filename));

        // $response->deleteFileAfterSend(true);

        // return $response;
        $customPaper = array(0, 0, 2600, 1200);
        $signatures = Signature::where(['conference_id' => $latestConference->id, 'status' => 1])->get();
        $pdf = PDF::loadView('backend.conferences.registrations.certificate', compact('participant', 'signatures'))->setPaper($customPaper);
        return $pdf->stream();
    }

    // public function generateCertificate($id)
    // {
    //     $participant = ConferenceRegistration::where('id', $id)->first();
    //     $customPaper = array(0,0,2600,1200);
    //     $pdf = PDF::loadView('backend.conferences.registrations.certificate', compact('participant'))->setPaper($customPaper);
    //     return $pdf->stream();
    // }

    // public function generateCertificate($type)
    // {
    //     if ($type == 'attendees') {
    //         $participants = ConferenceRegistration::where(['registrant_type' => 1, 'is_invited' => 0, 'conference_registrations.status' => 1])
    //                         ->join('users', 'conference_registrations.user_id', '=', 'users.id')
    //                         ->orderBy('users.name', 'asc')
    //                         ->get();
    //     } elseif ($type == 'presenters') {
    //         $participants = ConferenceRegistration::where(['registrant_type' => 2, 'is_invited' => 0, 'conference_registrations.status' => 1])
    //                                 ->join('users', 'conference_registrations.user_id', '=', 'users.id')
    //                                 ->orderBy('users.name', 'asc')
    //                                 ->get();
    //     } elseif ($type == 'guest-attendees') {
    //         $participants = ConferenceRegistration::where(['registrant_type' => 1, 'is_invited' => 1, 'conference_registrations.status' => 1])
    //                                 ->join('users', 'conference_registrations.user_id', '=', 'users.id')
    //                                 ->orderBy('users.name', 'asc')
    //                                 ->get();
    //     } elseif ($type == 'guest-presenters') {
    //         $participants = ConferenceRegistration::where(['registrant_type' => 2, 'is_invited' => 1, 'conference_registrations.status' => 1])
    //                                 ->join('users', 'conference_registrations.user_id', '=', 'users.id')
    //                                 ->orderBy('users.name', 'asc')
    //                                 ->get();
    //     }
    //     $signatures = Signature::where('status', 1)->limit(3)->get();
    //     $customPaper = array(0,0,1400,1600);
    //     $pdf = PDF::loadView('backend.conferences.registrations.certificate', compact('participants', 'signatures'))->setPaper($customPaper);
    //     return $pdf->stream();
    // }

    public function addRole(Request $request)
    {
        $registration = ConferenceRegistration::whereId($request->id)->first();
        return view('backend.conferences.registrations.add-role', compact('registration'));
    }

    public function addRoleSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_role' => 'required'
            ]);

            $conference_registration = ConferenceRegistration::whereId($request->id)->first();
            $userDetail = UserDetail::whereUserId($conference_registration->user_id)->first();

            $userDetail->update($validated);

            $type = 'success';
            $message = "User role added successfully.";
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function convertToSpeakerbyAdmin(Request $request)
    {
        try {
            $registrant =  ConferenceRegistration::whereId($request->id)->first();
            if ($registrant->registrant_type == 1) {
                $newRegistrantTypeValue = 2;
                $message = "Attendee Converted To Speaker Successfully.";
            } else {
                $newRegistrantTypeValue = 1;
                $message = "Speaker Converted To Attendee Successfully.";
            }

            $registrant->update(['registrant_type' => $newRegistrantTypeValue]);

            $type = 'success';
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function addPaymentVoucher(Request $request)
    {
        $registration = ConferenceRegistration::whereId($request->id)->first();
        return view('backend.conferences.registrations.add-payment-voucher', compact('registration'));
    }

    public function addPaymentVoucherSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'payment_voucher' => 'required|mimes:jpg,png,pdf|max:250',
            ]);

            $conference_registration = ConferenceRegistration::whereId($request->id)->first();
            $voucherName = time() . '.' . $validated['payment_voucher']->getClientOriginalExtension();
            Storage::putFileAs("public/conference/registration/payment-voucher", $validated['payment_voucher'], $voucherName);
            $validated['payment_voucher'] = $voucherName;

            $conference_registration->update($validated);

            $type = 'success';
            $message = "Total attendee edited successfully.";
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }
}
