<?php

namespace App\Http\Controllers\Backend;

use App\Exports\SignedUpUsersExport;
use App\Http\Controllers\Controller;
use App\Mail\{ResetPasswordMail, AdminCreatedMail};
use App\Mail\Conference\RegistrationMail;
use App\Models\ScientificCommittee;
use Illuminate\Http\Request;
use App\Models\{User, Conference, UserDetail, ConferenceRegistration, Expert};
use Exception, Hash, Str, Mail, DB, Excel;

class AdminController extends Controller
{
    public function index()
    {
        $latestConference = Conference::latestConference();
        $userRole = User::userRole();
        if ($userRole[0] == 1) {
            $admins = User::where(['conference_id' => $latestConference->id, 'status' => 1])->whereJsonContains('role', "[2]")->orWhereJsonContains('role', "[3]")->orWhereJsonContains('role', "[5]")->orWhereJsonContains('role', "[4,3]")->orderBy('id', 'DESC')->get();
        } elseif ($userRole[0] == 2) {
            $admins = User::where(['conference_id' => $latestConference->id, 'status' => 1])->whereJsonContains('role', "[3]")->orWhereJsonContains('role', "[4,3]")->orderBy('id', 'DESC')->get();
        }
        return view('backend.admins.show', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'role' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email'
            ]);

            $latestConference = Conference::latestConference();
            $validated['role'] = json_encode([intval($validated['role'])]);
            $generatedPassword = Str::random(8);
            $validated['password'] = Hash::make($generatedPassword);
            $validated['conference_id'] = $latestConference->id;

            $data = [
                'name' => $validated['name'],
                'role' => $request->role,
                'email' => $validated['email'],
                'password' => $generatedPassword
            ];

            Mail::to($validated['email'])->send(new AdminCreatedMail($data));

            User::create($validated);

            return redirect()->route('admin.index')->with('status', 'Admin Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        return view('backend.admins.create', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $admin->id,
            ]);

            $admin->update($validated);

            return redirect()->route('admin.index')->with('status', 'Admin Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Password has been reset successfully.';
            $admin = User::whereId($request->userId)->first();

            $generatedPassword = Str::random(8);
            $hashedPassword = Hash::make($generatedPassword);

            $data = [
                'receiverName' => $admin->name,
                'loginEmail' => $admin->email,
                'generatedPassword' => $generatedPassword,
            ];

            Mail::to($admin->email)->send(new ResetPasswordMail($data));

            $admin->update(['password' => $hashedPassword]);
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }

        return response(['type' => $type, 'message' => $message]);
    }

    public function signedUpUsersList()
    {
        $latestConference = Conference::latestConference();
        $users = User::where(['role' => 2, 'status' => 1])->orderBy('id', 'DESC')->get();
        return view('backend.admins.signed-up-users', compact('users', 'latestConference'));
    }

    public function makeExpert(Request $request)
    {
        try {
            $type = 'success';
            $latestConference = Conference::latestConference();
            $isExpert = Expert::where(['user_id' => $request->userId, 'conference_id' => $latestConference->id])->first();

            if (empty($isExpert)) {
                $data['user_id'] = $request->userId;
                $data['conference_id'] = $latestConference->id;
                $data['status'] = 1;
                Expert::create($data);
                $message = 'User Assigned as Expert Successfully for ' . $latestConference->conference_theme;
            } else {
                if ($isExpert->status == 1) {
                    $isExpert->update(['status' => 0]);
                    $message = 'User Removed as Expert Successfully for ' . $latestConference->conference_theme;
                } else {
                    $isExpert->update(['status' => 1]);
                    $message = 'User Assigned as Expert Successfully for ' . $latestConference->conference_theme;
                }
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function changeFacultyStatus($id)
    {
        $userDetail = UserDetail::whereUserId($id)->first();
        if ($userDetail->is_faculty == 1) {
            $isFaculty = 0;
        } else {
            $isFaculty = 1;
        }

        $userDetail->update(['is_faculty' => $isFaculty]);

        return redirect()->back()->with('status', 'Faculty status changed successfully.');
    }

    public function excelExport()
    {
        return Excel::download(new SignedUpUsersExport(), 'signed-up-users.xlsx');
    }

    public function passDesgination(Request $request)
    {
        $user = UserDetail::whereUserId($request->id)->first();
        return view('backend.admins.pass-designation', compact('user'));
    }
    public function passDesginationSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'pass_designation' => 'required'
            ]);
            $user = UserDetail::whereUserId($request->user_id)->first();
            $user->update(['pass_designation' => $request->pass_designation]);
            $message = 'Designation Passed Successfully Added';
            $type = 'success';
        } catch (\Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function inviteUserForConference(Request $request)
    {
        $user = User::whereId($request->id)->first();
        return view('backend.admins.invite-user-for-conference', compact('user'));
    }

    public function inviteUserForConferenceSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'registrant_type' => 'required'
            ]);

            $latestConference = Conference::latestConference();

            $validated['user_id'] = $request->user_id;
            $validated['conference_id'] = $latestConference->id;
            $validated['token'] = Str::random(60);
            $validated['verified_status'] = 1;
            $validated['role'] = 2;
            $validated['is_invited'] = 1;
            $validated['attend_type'] = 1;
            $validated['total_attendee'] = 1;
            $validated['meal_type'] = 2;

            $user = User::whereId($validated['user_id'])->first();
            $middleName = !empty($user->m_name) ? $user->m_name . ' ' : '';
            $data = [
                'namePrefix' => $user->namePrefix->prefix,
                'name' => $user->f_name . ' ' . $middleName . $user->l_name,
                'conference_theme' => $latestConference->conference_theme,
                'invitationType' => 2
            ];
            Mail::to($user->email)->send(new RegistrationMail($data));

            ConferenceRegistration::create($validated);

            $type = 'success';
            $message = "User invited successfully for conference.";
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }
}
