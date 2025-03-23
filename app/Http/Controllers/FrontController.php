<?php

namespace App\Http\Controllers;

use App\Models\{Conference, User, UserDetail, MemberType, CommitteeMember, ConferenceRegistration, Committee, Hall, ScientificSession, Sponsor, SponsorCategory};
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB, Exception, Http, Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class FrontController extends Controller
{
    // =============================================================== front start ===============================================================
    public function index()
    {
        session(['isIndex' => true]);

        $latestConference = Conference::latestConference();
        $latestConference = Conference::latestConference();
        $speakers = [];
        if (!empty($latestConference)) {
            $speakers = ConferenceRegistration::where(['conference_id' => $latestConference->id, 'registrant_type' => 2, 'verified_status' => 1, 'status' => 1])->latest()->get();
        }
        $countries = DB::table('countries')->get();
        $featuedMembers = [];
        $notices = [];
        if (!empty($latestConference)) {
            $featuedMembers = CommitteeMember::where(['conference_id' => $latestConference->id, 'is_featured' => 1, 'status' => 1])->orderBy('updated_at', 'ASC')->get();
            $notices = DB::table('notices')->where(['conference_id' => $latestConference->id, 'status' => 1])->latest()->take(3)->get();
        }
        $faqs = DB::table('f_a_q_s')->where('status', 1)->orderBy('id', 'ASC')->get();

        $sponsorCategories = SponsorCategory::where(['status' => 1, 'conference_id' => $latestConference->id])->orderBy('id', 'ASC')->with('sponsors')->get();
        // dd($sponsorCategories);
        // $sponsors = Sponsor::where(['visible_status' => 1, 'status' => 1])->orderBy('sponsor_category_id', 'ASC')->get();
        // dd($sponsors);
        $data = [
            'speakers' => $speakers,
            'countries' => $countries,
            'featuedMembers' => $featuedMembers,
            'notices' => $notices,
            'faqs' => $faqs,
            // 'sponsors' => $sponsors,
            'sponsorCategories' => $sponsorCategories,
        ];



        return view('frontend.index', $data);
    }

    public function speakers()
    {
        session(['isIndex' => false]);

        $latestConference = Conference::latestConference();
        $speakers = [];
        if (!empty($latestConference)) {
            $speakers = ConferenceRegistration::where(['conference_id' => $latestConference->id, 'registrant_type' => 2, 'verified_status' => 1, 'status' => 1])->latest()->get();
        }

        return view('frontend.speakers', compact('speakers'));
    }

    public function notice()
    {
        session(key: ['isIndex' => false]);

        $latestConference = Conference::latestConference();
        $notices = [];
        if (!empty($latestConference)) {
            $notices = DB::table('notices')->where(['conference_id' => $latestConference->id, 'status' => 1])->latest()->paginate(6);
        }

        return view('frontend.notices', compact('notices'));
    }

    public function noticeDetail($slug)
    {
        session(['isIndex' => false]);
        $notice = DB::table('notices')->whereSlug($slug)->first();
        $latestConference = Conference::latestConference();
        $notices = DB::table('notices')->where(['conference_id' => $latestConference->id, 'status' => 1])->whereNot('id', $notice->id)->latest()->take(3)->get();
        return view('frontend.notice-detail', compact('notice', 'notices'));
    }

    public function committee($slug)
    {
        session(['isIndex' => false]);

        $committee = Committee::whereSlug($slug)->first();
        $latestConference = Conference::latestConference();
        $committeeMembers = DB::table('committee_members AS CM')
            ->select('UD.member_type_id', 'f_name', 'm_name', 'l_name', 'designation', 'image', 'prefix')
            ->join('users AS U', 'U.id', '=', 'CM.user_id')
            ->join('user_details AS UD', 'U.id', '=', 'UD.user_id')
            ->join('name_prefixes AS NP', 'NP.id', '=', 'U.name_prefix_id')
            ->join('designations AS D', 'D.id', '=', 'CM.designation_id')
            ->where(['CM.conference_id' => $latestConference->id, 'CM.committee_id' => $committee->id, 'CM.status' => 1])
            ->orderBy('order_no', 'ASC')
            ->get()->toArray();
        return view('frontend.committee', compact('committee', 'latestConference', 'committeeMembers'));
    }

    public function abstractGuidelines()
    {
        session(['isIndex' => false]);

        $latestConference = Conference::latestConference();
        $submissionSetting = DB::table('submission_settings')->where('conference_id', $latestConference->id)->first();
        return view('frontend.abstract-guidelines', compact('submissionSetting'));
    }

    public function accommodation()
    {
        session(key: ['isIndex' => false]);
        $latestConference = Conference::latestConference();
        $hotels = DB::table('hotels')->where(['conference_id' => $latestConference->id, 'visible_status' => 1, 'status' => 1])->get();
        return view('frontend.accommodation', compact('hotels'));
    }

    public function accommodationInner($slug)
    {
        session(key: ['isIndex' => false]);
        $hotel = DB::table('hotels')->whereSlug($slug)->first();
        $latestConference = Conference::latestConference();
        $accommodations = DB::table('hotels')->where(['conference_id' => $latestConference->id, 'status' => 1])->whereNot('slug', $slug)->latest()->take(3)->get();
        return view('frontend.accommodation-detail', compact('hotel', 'accommodations'));
    }

    public function workshopDetail($slug)
    {
        $workshop = DB::table('workshops')->whereSlug($slug)->first();
        $workshops = DB::table('workshops')->whereNot('slug', $slug)->whereStatus(1)->inRandomOrder()->take(3)->get();
        return view('frontend.workshop-detail', compact('workshop', 'workshops'));
    }

    public function scientificSession()
    {
        // $scientificSessions = DB::table('scientific_sessions')
        //     ->where('status', 1)
        //     ->orderBy('day', 'asc')
        //     ->get()
        //     ->groupBy('day'); // Groups the sessions by the 'day' column

        // // Transform the grouped data into the desired structure
        // $sessionDays = $scientificSessions->map(function ($sessions, $day) {
        //     return [
        //         'day' => $day,
        //         'session_count' => $sessions->count(), // Count sessions for the day
        //         'sessions' => $sessions->map(function ($session) {
        //             return [
        //                 'hall' => $session->hall_id,
        //                 'time' => $session->time,
        //                 'duration' => $session->duration,
        //                 'topic' => $session->topic,
        //             ];
        //         }),
        //     ];
        // })->values();
        // dd($sessionDays);

        $sessions = ScientificSession::where('status', 1)->orderBy('day', 'ASC')->orderByRaw("STR_TO_DATE(time, '%h:%i%p') ASC")->get();

        $halls = Hall::orderBy('created_at')->whereStatus(1)->get();
        $latestConference = Conference::latestConference();
        $startDate = Carbon::parse($latestConference->start_date);
        $endDate = Carbon::parse($latestConference->end_date);

        $dates = [];

        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
        return view('frontend.scientific-session', compact('halls', 'dates', 'sessions'));
    }

    public function scientificSessionTest()
    {
        $sessions = ScientificSession::where('status', 1)->orderBy('day', 'ASC')->orderByRaw("STR_TO_DATE(time, '%h:%i%p') ASC")->get();

        $halls = Hall::whereStatus(1)->get();
        $latestConference = Conference::latestConference();
        $startDate = Carbon::parse($latestConference->start_date);
        $endDate = Carbon::parse($latestConference->end_date);

        $dates = [];

        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
        return view('frontend.scientific-session-static', compact('halls', 'dates', 'sessions'));
    }
    public function exportPdf($hall_id, $date)
    {
        $hall = Hall::with(['scientificSession.category'])
            ->findOrFail($hall_id);

        $sessions = $hall->scientificSession
            ->where('day', $date)
            ->where('status', 1)
            ->sortBy(fn($session) => \Carbon\Carbon::createFromFormat('h:ia', $session->time))
            ->groupBy('category_id');

        $pdf = Pdf::loadView('frontend.scientificSessionPdf', compact('hall', 'sessions', 'date'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Scientific_Sessions_Hall_{$hall->id}_{$date}.pdf");
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        $sessions = ScientificSession::with('hall', 'category')
            ->where('topic', 'LIKE', "%{$query}%")
            ->where('status', 1)
            ->orWhere('participants', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($sessions);
    }

    public function message()
    {
        return view('frontend.message');
    }
    // =============================================================== front end ===============================================================

    // =============================================================== old start ===============================================================
    public function front($request)
    {
        if ($request == null) {
            $latestConference = Conference::latestConference();
        } else {
            if ($request->input('conference') != null) {
                $latestConference = Conference::where('slug', $request->input('conference'))->first();
            } else {
                $latestConference = Conference::where('id', $request->cookie('conference_id'))->first();
            }
            if ($latestConference == null) {
                $latestConference = Conference::latestConference();
            }
        }

        $committees = DB::table('committees')->where(['status' => 1, 'conference_id' => $latestConference->id])->get();
        $workshopsAll = DB::table('workshops')->where(['approved_status' => 1, 'conference_id' => $latestConference->id])->select('slug', 'title')->get();
        $data = [
            'latestConference' => $latestConference,
            'committees' => $committees,
            'workshopsAll' => $workshopsAll,
        ];
        return $data;
    }

    public function register(Request $request)
    {
        $data = [];
        if ($request->method() == "POST") {
            $request->session()->forget(['name', 'email', 'phone', 'council_number', 'institute_name', 'affiliation', 'nesog_number', 'nationality']);
        }
        if ($request->council_number) {
            $apiResponse = Http::get('https://membership.nesog.org.np/api/updated-members');
            $data = $apiResponse->json();
            $collect =  collect($data);
            $checkMember = $collect->where('councilNum', $request->council_number)->first();
            if (empty($checkMember)) {
                return redirect()->route('front.register')->with('delete', 'Data could not fetch as you have not updated in NESOG membership system.');
            }
            $name = $checkMember['fname'];
            if (!empty($checkMember['mname'])) {
                $name .= ' ' . $checkMember['mname'];
            }
            if (!empty($checkMember['lname'])) {
                $name .= ' ' . $checkMember['lname'];
            }
            $data = [
                'name' => $name,
                'email' => $checkMember['email'],
                'phone' => $checkMember['number'],
                'council_number' => $checkMember['councilNum'],
                'institute_name' => last($checkMember['work'])['workplaceName'],
                'affiliation' => last($checkMember['work'])['designation'],
                'nesog_number' => $checkMember['regNo'],
                'nationality' => $checkMember['nationality'],
            ];

            session($data);
        }
        $countries = DB::table('countries')->get();
        return view('frontend.register', compact('countries'));
    }

    public function getMemberTypes(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Value received successfully';

            if ($request->selectedDelegate == "National") {
                $types = MemberType::where('delegate', 'National')->get();
            } elseif ($request->selectedDelegate == "International") {
                $types = MemberType::where('delegate', 'International')->get();
            }

            $data = [
                'types' => $types
            ];
        } catch (Exception $e) {
            $type = 'error';
            $message = 'Required Values Not Added.';
            $data = [];
        }

        return response()->json(['type' => $type, 'message' => $message, 'data' => $data]);
    }

    public function registerSubmit(Request $request)
    {
        try {
            $rules = [
                'name_prefix_id' => 'required',
                'f_name' => 'required',
                'l_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required',
                'country_id' => 'required',
                'password' => 'required|confirmed|min:8'
            ];

            $message = [
                'password.confirmed' => 'Passwords does not match.'
            ];

            $validated = $request->validate($rules, $message);

            $validated['password'] = Hash::make($validated['password']);

            DB::beginTransaction();
            $storeUser = User::create($validated);

            $validated['user_id'] = $storeUser->id;
            UserDetail::create($validated);
            DB::commit();

            return redirect()->route('login')->with('status', 'Successfully registered. Login to proceed further');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function paymentSuccess()
    {
        return view('frontend.payment-success');
    }


    // =============================================================== old end ===============================================================
}
