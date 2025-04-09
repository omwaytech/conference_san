<?php

namespace App\Http\Controllers;

use App\Models\NamePrefix;
use Illuminate\Http\Request;
use App\Models\{Attendance, User, ConferenceRegistration, Workshop, Submission, WorkshopRegistration, Conference, ConferenceRegistrationKit, Meal, UserDetail, Sponsor, SponsorAttendance, SponsorMeal};
use Exception, DB, Storage, Http;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($slug = null)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $data = [
            'user' => $user
        ];
        // if (auth()->user()->role == 1) {
        if ($slug != null) {
            $conference = Conference::whereSlug($slug)->first();
        } else {
            $conference = Conference::latestConference();
        }
        session(['conferenceDetail' => $conference]);


        $registrants = ConferenceRegistration::where(['status' => 1, 'conference_id' => @$conference->id])->latest()->get();
        $totalNationalRegistrants = ConferenceRegistration::totalRegistrants(1, $conference);
        $totalInternationalRegistrants = ConferenceRegistration::totalRegistrants(2, $conference);
        $workshops = Workshop::where(['approved_status' => 1, 'status' => 1])->get();
        $submissions = Submission::where(['status' => 1])->get();
        $registrantsDetail = ConferenceRegistration::where(['verified_status' => 1, 'conference_registrations.status' => 1])->get();
        $sponsors = Sponsor::where('status', 1)->get();

        $checkRegistrationCommittee = null;
        if ($user->role == 2) {
            $registrationCommittee = DB::table('committees')->where('committee_name', 'Registration Committee')->first();
            $checkRegistrationCommittee = DB::table('committee_members')->where(['conference_id' => $conference->id, 'committee_id' => $registrationCommittee->id, 'user_id' => $user->id, 'status' => 1])->first();
        }

        $day1Attendance = Attendance::whereDate('attendances.created_at', '2025-4-04')->get();
        $day2Attendance = Attendance::whereDate('attendances.created_at', '2025-4-05')->get();

        $day1Launch = Meal::whereDate('meals.created_at', '2025-4-04')->get();
        $day2Launch = Meal::whereDate('meals.created_at', '2025-4-05')->get();

        $day1Dinner = Meal::whereDate('meals.created_at', '2025-4-04')->get();
        $day2Dinner = Meal::whereDate('meals.created_at', '2025-4-05')->get();

        $day1AttendanceSponsor = SponsorAttendance::whereDate('sponsor_attendances.created_at', '2025-4-04')->get();
        $day2AttendanceSponsor = SponsorAttendance::whereDate('sponsor_attendances.created_at', '2025-4-05')->get();

        $day1LaunchSponsor = SponsorMeal::whereDate('sponsor_meals.created_at', '2025-4-04')->get();
        $day2LauncSponsor = SponsorMeal::whereDate('sponsor_meals.created_at', '2025-4-05')->get();

        $day1DinnerSponsor = SponsorMeal::whereDate('sponsor_meals.created_at', '2025-4-04')->get();
        $day2DinnerSponsor = SponsorMeal::whereDate('sponsor_meals.created_at', '2025-4-05')->get();

        $day1ConferenceKit = ConferenceRegistrationKit::whereDate('created_at', '2025-4-04')->get();
        $day2ConferenceKit = ConferenceRegistrationKit::whereDate('created_at', '2025-4-05')->get();

        $data = [
            'user' => $user,
            'registrants' => $registrants,
            'totalNationalRegistrants' => $totalNationalRegistrants,
            'totalInternationalRegistrants' => $totalInternationalRegistrants,
            'workshops' => $workshops,
            'submissions' => $submissions,
            'registrantsDetail' => $registrantsDetail,
            'sponsors' => $sponsors,
            'conference' => $conference,
            'checkRegistrationCommittee' => $checkRegistrationCommittee,
            'day1Attendance' => $day1Attendance,
            'day2Launch' => $day2Launch,
            'day1Launch' => $day1Launch,
            'day1Dinner' => $day1Dinner,
            'day2Dinner' => $day2Dinner,
            'day2Attendance' => $day2Attendance,
            'day1LaunchSponsor' => $day1LaunchSponsor,
            'day2LaunchSponsor' => $day2LauncSponsor,
            'day1DinnerSponsor' => $day1DinnerSponsor,
            'day2DinnerSponsor' => $day2DinnerSponsor,
            'day1AttendanceSponsor' => $day1AttendanceSponsor,
            'day2AttendanceSponsor' => $day2AttendanceSponsor,
            'day1ConferenceKit' => $day1ConferenceKit,
            'day2ConferenceKit' => $day2ConferenceKit
        ];
        // }

        return view('backend.dashboard.show', $data);
    }

    public function viewMemberTypesDailyAttendance($day, $memberType)
    {
        if ($day == 'day1') {
            $date = '2025-04-04';
        } elseif ($day == 'day2') {
            $date = '2025-04-05';
        }
        $attendenceTaken = [];
        $attendences = Attendance::whereDate('created_at', $date)->where('status', 1)->get();
        foreach ($attendences as $attendence) {
            if ($attendence->conferenceRegistration && $attendence->conferenceRegistration->committeMember->isNotEmpty() && $attendence->conferenceRegistration->user->userDetail->country_id == 125 && $memberType == 'organizer') {
                $attendenceTaken[] = $attendence->conferenceRegistration;
            } elseif ($attendence->conferenceRegistration && $attendence->conferenceRegistration->user->userDetail->country_id != 125 && $memberType == 'international') {
                $attendenceTaken[] = $attendence->conferenceRegistration;
            } elseif ($attendence->conferenceRegistration && $attendence->conferenceRegistration->registrant_type == 2 && $memberType == 'speaker') {
                $attendenceTaken[] = $attendence->conferenceRegistration;
            } elseif ($memberType == 'delegate') {
                $attendenceTaken[] = $attendence->conferenceRegistration;
            }
        } 

        return view('backend.dashboard.attendance-list', compact('attendenceTaken', 'memberType', 'day'));
    }
    public function viewMemberTypesConferenceKit($day, $memberType)
    {
        if ($day == 'day1') {
            $date = '2025-04-04';
        } elseif ($day == 'day2') {
            $date = '2025-04-05';
        }
        $attendenceTaken = [];
        $attendences = ConferenceRegistrationKit::whereDate('created_at', $date)->where('status', 1)->get();
        foreach ($attendences as $attendence) {
            if ($attendence->conferenceRegistration && $attendence->conferenceRegistration->committeMember->isNotEmpty() && $attendence->conferenceRegistration->user->userDetail->country_id == 125 && $memberType == 'organizer') {
                $attendenceTaken[] = $attendence->conferenceRegistration;
            } elseif ($attendence->conferenceRegistration && $attendence->conferenceRegistration->user->userDetail->country_id != 125 && $memberType == 'international') {
                $attendenceTaken[] = $attendence->conferenceRegistration;
            } elseif ($attendence->conferenceRegistration && $attendence->conferenceRegistration->registrant_type == 2 && $memberType == 'speaker') {
                $attendenceTaken[] = $attendence->conferenceRegistration;
            } elseif ($memberType == 'delegate') {
                $attendenceTaken[] = $attendence->conferenceRegistration;
            }
        }

        return view('backend.dashboard.conference-kit-list', compact('attendenceTaken', 'memberType', 'day'));
    }

    public function viewSponsorAttendance($day)
    {
        if ($day == 'day1') {
            $date = '2025-04-04';
        } elseif ($day == 'day2') {
            $date = '2025-04-05';
        }
        $attendences = SponsorAttendance::whereDate('created_at', $date)->where('status', 1)->get();
        return view('backend.dashboard.sponsor-attendence-list', compact('day', 'attendences'));
    }

    public function viewMemberTypesDailyMeal($day, $memberType, $mealType)
    {
        if ($day == 'day1') {
            $date = '2025-04-04';
        } elseif ($day == 'day2') {
            $date = '2025-04-05';
        }
        $mealTaken = [];
        if ($mealType == 'lunch') {
            $meals = Meal::whereDate('created_at', $date)->whereNotNull('lunch_taken')->get();
            foreach ($meals as $meal) {
                if ($meal->conferenceRegistration && $meal->conferenceRegistration->committeMember->isNotEmpty() && $meal->conferenceRegistration->user->userDetail->country_id == 125 && $memberType == 'organizer') {
                    $mealTaken[] = $meal->conferenceRegistration;
                } elseif ($meal->conferenceRegistration && $meal->conferenceRegistration->user->userDetail->country_id != 125 && $memberType == 'international') {
                    $mealTaken[] = $meal->conferenceRegistration;
                } elseif ($meal->conferenceRegistration && $meal->conferenceRegistration->registrant_type == 2 && $memberType == 'speaker') {
                    $mealTaken[] = $meal->conferenceRegistration;
                } elseif ($memberType == 'delegate') { 
                    $mealTaken[] = $meal->conferenceRegistration;
                }
            }
        }
        if ($mealType == 'dinner') {
            $meals = Meal::whereDate('created_at', $date)->whereNotNull('dinner_taken')->get();
            foreach ($meals as $meal) {
                if ($meal->conferenceRegistration && $meal->conferenceRegistration->committeMember->isNotEmpty() && $meal->conferenceRegistration->user->userDetail->country_id == 125 && $memberType == 'organizer') {
                    $mealTaken[] = $meal->conferenceRegistration;
                } elseif ($meal->conferenceRegistration && $meal->conferenceRegistration->user->userDetail->country_id != 125 && $memberType == 'international') {
                    $mealTaken[] = $meal->conferenceRegistration;
                } elseif ($meal->conferenceRegistration && $meal->conferenceRegistration->registrant_type == 2 && $memberType == 'speaker') {
                    $mealTaken[] = $meal->conferenceRegistration;
                } elseif ($memberType == 'delegate') {
                    $mealTaken[] = $meal->conferenceRegistration;
                }
            }
        }
        return view('backend.dashboard.lunch-dinner-list', compact('mealTaken', 'memberType', 'date', 'mealType', 'day'));
    }


    public function viewSponsorDailyMeal($day, $mealType)
    {
        if ($day == 'day1') {
            $date = '2025-04-04';
        } elseif ($day == 'day2') {
            $date = '2025-04-05';
        }
        if ($mealType == 'lunch') {
            $meals = SponsorMeal::whereDate('created_at', $date)->whereNotNull('lunch_taken')->get();
        }
        if ($mealType == 'dinner') {
            $meals = SponsorMeal::whereDate('created_at', $date)->whereNotNull('dinner_taken')->get();
        }
        // dd($mealTaken);
        return view('backend.dashboard.sponsor-lunch-dinner-list', compact('meals', 'day', 'mealType', 'date'));
    }

    public function viewParticipants($status)
    {
        $conference = session()->get('conferenceDetail');
        if ($status == 'unverified') {
            $registrants = ConferenceRegistration::where(['verified_status' => 0, 'status' => 1, 'conference_id' => $conference->id])->latest()->get();
        } elseif ($status == 'accepted' || $status == 'total-registrants') {
            $registrants = ConferenceRegistration::where(['verified_status' => 1, 'status' => 1, 'conference_id' => $conference->id])->latest()->get();
        } elseif ($status == 'national') {
            $registrants = ConferenceRegistration::where(['verified_status' => 1, 'status' => 1, 'conference_id' => $conference->id])
                ->whereHas('userDetail', function ($query) {
                    $query->whereHas('memberType', function ($subquery) {
                        $subquery->where('delegate', 'National');
                    });
                })->latest()->get();
        } elseif ($status == 'international') {
            $registrants = ConferenceRegistration::where(['verified_status' => 1, 'status' => 1, 'conference_id' => $conference->id])
                ->whereHas('userDetail', function ($query) {
                    $query->whereHas('memberType', function ($subquery) {
                        $subquery->where('delegate', 'International');
                    });
                })->latest()->get();
        } elseif ($status == 'accompany-persons') {
            $registrants = ConferenceRegistration::where(['verified_status' => 1, 'status' => 1, 'conference_id' => $conference->id])->where('total_attendee', '>', 1)->latest()->get();
        }
        return view('backend.dashboard.participants', compact('registrants', 'status', 'conference'));
    }

    public function workshopRegistrations($slug)
    {
        $workshop = Workshop::whereSlug($slug)->first();
        $registrations = WorkshopRegistration::where(['workshop_id' => $workshop->id, 'status' => 1])->get();
        return view('backend.dashboard.workshop-registrants', compact('registrations', 'workshop'));
    }

    public function submission($type)
    {
        $latestConference = Conference::latestConference();

        $authUser = auth()->user();

        $sql = "SELECT
                S.id,
                S.expert_id,
                S.topic,
                S.presentation_type,
                S.request_status,
                S.forward_expert,
                U.f_name,
                U.m_name,
                U.l_name
                FROM submissions AS S
                JOIN users AS U ON S.user_id = U.id
                JOIN user_details AS UD ON S.user_id = UD.user_id
                WHERE S.presentation_type = $type AND S.status = 1
                ORDER BY S.id DESC";

        $submissions = DB::select($sql);

        $experts = User::whereJsonContains('role', "[3]")->get();
        return view('backend.submission.show', compact('submissions', 'experts', 'authUser'));
    }

    public function editProfile()
    {
        $user = User::whereId(auth()->user()->id)->first();
        $countries = DB::table('countries')->get();
        $prefixes = NamePrefix::where('status', 1)->get();
        return view('backend.admins.edit-profile', compact('user', 'countries', 'prefixes'));
    }

    public function editProfileByAdmin($id)
    {
        $user = User::whereId($id)->first();
        $countries = DB::table('countries')->get();
        $prefixes = NamePrefix::where('status', 1)->get();
        return view('backend.admins.edit-profile-by-admin', compact('user', 'countries', 'prefixes'));
    }

    public function editProfileUpdate(Request $request)
    {
        try {
            if ($request->has('user_id')) {
                $userData = User::whereId($request->user_id)->first();
            } else {
                $userData = auth()->user();
            }

            $rules = [
                'gender' => 'required',
                'name_prefix_id' => 'required',
                'f_name' => 'required',
                'm_name' => 'nullable',
                'l_name' => 'required',
                'affiliation' => 'nullable',
                'department' => 'nullable',
                'phone' => 'required',
                'email' => 'required|email|unique:users,email,' . $userData->email . ',email',
                'image' => 'nullable|mimes:jpg,png|max:500',
                'institute_name' => 'nullable',
                'address' => 'nullable',
                'council_number' => 'required',
                'delegate' => 'required',
                'member_type_id' => 'required',
            ];
            if ($request->member_type_id == 1 || $request->member_type_id == 2) {
                $rules['san_number'] = 'required';
            } else {
                $rules['san_number'] = 'nullable';
            }

            if ($request->delegate == "International") {
                $rules['country_id'] = 'required';
            }

            $message = [
                'san_number.required' => 'Membership Number is required.',
                'image.dimensions' => 'The image must be square (1:1 aspect ratio).'
            ];

            $validated = $request->validate($rules, $message);

            if ($request->member_type_id == 2) {
                $apiResponse = Http::get('http://membership.san.org.np/api/inactive/members');
                $data = $apiResponse->json();
                $collect =  collect($data);
                $member = $collect->where('councilNum', $request->council_number)->first();
                if (!empty($member)) {
                    return redirect()->back()->withInput()->with('delete', 'Your membership is inactive. So kindly update your membership, otherwise you can register as Non Life Member.');
                }
            }

            if (!empty($validated['image'])) {
                Storage::delete("public/users/" . $userData->userDetail->image);
                $imageName = time() . rand(0, 99) . '.' . $validated['image']->getClientOriginalExtension();
                Storage::putFileAs("public/users", $validated['image'], $imageName);
                $validated['image'] = $imageName;
            }

            unset($validated['delegate']);
            DB::beginTransaction();
            $userData->update($validated);

            $userDetail = UserDetail::whereUserId($userData->id)->first();
            if (!empty($userDetail)) {
                $userDetail->update($validated);
            } else {
                $validated['user_id'] = $userData->id;
                UserDetail::create($validated);
            }
            DB::commit();

            if ($request->has('user_id')) {
                return redirect()->route('admin.signedUpUsersList')->with('status', 'Profile Details Updated Successfully.');
            } else {
                return redirect()->route('home')->with('status', 'Profile Details Updated Successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function conferenceDuplicateRegistration()
    {
        $sql = "SELECT council_number, COUNT(*) AS totalNumbers
                FROM user_details
                GROUP BY council_number
                HAVING COUNT(*) > 1";

        $councilNumbers = DB::select($sql);
        return view('backend.dashboard.duplicated-conference-data.council-number', compact('councilNumbers'));
    }

    public function conferenceDuplicateDatas($council_number)
    {
        $userDatas = UserDetail::where(['council_number' => $council_number, 'status' => 1])->get();
        return view('backend.dashboard.duplicated-conference-data.data', compact('userDatas'));
    }

    public function viewAttendanceStatus()
    {
        $conference = session()->get('conferenceDetail');
        $registrants = DB::table('conference_registrations as CR')
            ->select('CR.id', 'CR.status', 'CR.conference_id','CR.total_attendee', 'verified_status', 'CR.registration_id', 'U.f_name', 'U.m_name', 'U.l_name', 'MT.delegate', 'MT.type')
            ->where(['verified_status' => 1, 'CR.status' => 1, 'CR.conference_id' => $conference->id])
            ->join('users as U', 'CR.user_id', '=', 'U.id')
            ->join('user_details as UD', 'U.id', '=', 'UD.user_id')
            ->join('member_types as MT', 'UD.member_type_id', '=', 'MT.id')
            ->orderBy('U.f_name', 'asc')
            ->get();
        return view('backend.dashboard.attendance-status', compact('registrants', 'conference'));
    }

    public function viewSponsorAttendanceStatus()
    {
        $conference = session()->get('conferenceDetail');
        $registrants = Sponsor::where('status', 1)->orderBy('name', 'asc')->get();
        return view('backend.dashboard.sponsor-attendance-status', compact('registrants', 'conference'));
    }

    public function viewAttendanceLunchDetail($day, $type, $status)
    {
        if ($day == 'day1') {
            if ($type == 'attendance') {
                if ($status == 'taken') {
                    $registrants = ConferenceRegistration::where(['verified_status' => 1, 'conference_registrations.status' => 1, 'attendance_status' => 1])
                        ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                        ->orderBy('users.name', 'asc')
                        ->get();
                } elseif ($status == 'remaining') {
                    $registrants = ConferenceRegistration::where(['verified_status' => 1, 'conference_registrations.status' => 1, 'attendance_status' => 0])
                        ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                        ->orderBy('users.name', 'asc')
                        ->get();
                }
            } elseif ($type == 'lunch') {
                if ($status == 'taken') {
                    $registrants = ConferenceRegistration::where(['verified_status' => 1, 'conference_registrations.status' => 1, 'remaining_dinner' => 0])
                        ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                        ->orderBy('users.name', 'asc')
                        ->get();
                } elseif ($status == 'remaining') {
                    $registrants = ConferenceRegistration::where(['verified_status' => 1, 'conference_registrations.status' => 1])->where('remaining_dinner', '!=', 0)
                        ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                        ->orderBy('users.name', 'asc')
                        ->get();
                }
            }
        } elseif ($day == 'day2') {
            if ($type == 'attendance') {
                if ($status == 'taken') {
                    $registrants = ConferenceRegistration::where(['verified_status' => 1, 'conference_registrations.status' => 1, 'attendance_status_2' => 1])
                        ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                        ->orderBy('users.name', 'asc')
                        ->get();
                } elseif ($status == 'remaining') {
                    $registrants = ConferenceRegistration::where(['verified_status' => 1, 'conference_registrations.status' => 1, 'attendance_status_2' => 0])
                        ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                        ->orderBy('users.name', 'asc')
                        ->get();
                }
            } elseif ($type == 'lunch') {
                if ($status == 'taken') {
                    $registrants = ConferenceRegistration::where(['verified_status' => 1, 'conference_registrations.status' => 1, 'remaining_dinner_2' => 0])
                        ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                        ->orderBy('users.name', 'asc')
                        ->get();
                } elseif ($status == 'remaining') {
                    $registrants = ConferenceRegistration::where(['verified_status' => 1, 'conference_registrations.status' => 1])->where('remaining_dinner_2', '!=', 0)
                        ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                        ->orderBy('users.name', 'asc')
                        ->get();
                }
            }
        }
        return view('backend.dashboard.detailed-attendance-lunch-status', compact('registrants', 'day', 'type', 'status'));
    }

    public function viewLaterParticipants($times)
    {
        if ($times == 'first') {
            $registrants = ConferenceRegistration::where(['verified_status' => 1, 'status' => 1])->where('created_at', '>=', '2024-04-04 12:00:00')->where('created_at', '<=', '2024-04-04 20:00:00')->latest()->get();
        } elseif ($times == 'second') {
            $registrants = ConferenceRegistration::where(['verified_status' => 1, 'status' => 1])->where('created_at', '>=', '2024-04-04 20:00:00')->latest()->get();
        }
        return view('backend.dashboard.later-participants', compact('registrants', 'times'));
    }

    public function generateLaterRegistrantPass($times)
    {
        if ($times == 'first') {
            $participants = ConferenceRegistration::where(['conference_registrations.status' => 1, 'verified_status' => 1])->where('conference_registrations.created_at', '>=', '2024-04-04 12:00:00')->where('created_at', '<=', '2024-04-04 20:00:00')
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.name', 'asc')
                ->get();
        } elseif ($times == 'second') {
            $participants = ConferenceRegistration::where(['conference_registrations.status' => 1, 'verified_status' => 1])->where('conference_registrations.created_at', '>=', '2024-04-04 20:00:00')
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.name', 'asc')
                ->get();
        }
        return view('backend.conferences.registrations.pass', compact('participants'));
    }
}
