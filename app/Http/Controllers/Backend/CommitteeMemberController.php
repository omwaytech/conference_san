<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Committee, CommitteeMember, User, Conference, Designation};
use Illuminate\Http\Request;
use Exception, Str;

class CommitteeMemberController extends Controller
{
    public function index($slug)
    {
        $latestConference = Conference::latestConference();
        $committee = Committee::whereSlug($slug)->first();
        return view('backend.committee.members.show', compact('committee', 'latestConference'));
    }

    public function create($slug)
    {
        $committee = Committee::whereSlug($slug)->first();
        $designations = Designation::where('status', 1)->get();
        $users = User::where(['role' => 2, 'status' => 1])->orderBy('f_name', 'ASC')->get();
        return view('backend.committee.members.create', compact('committee', 'designations', 'users'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'committee_id' => 'required',
                'user_id' => 'required|array',
                'designation_id' => 'required',
                'message' => 'nullable'
            ], [
                'user_id.required' => 'Atleast one user is required.',
                'designation_id.required' => 'Designation is required'
            ]);

            $designation = Designation::whereId($request->designation_id)->first();

            if ($designation->designation != 'Member' && count($validated['user_id']) > 1) {
                return redirect()->back()->withInput()->with('delete', 'Multiple members cannot be added beside Member designation.');
            }

            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;
            $validated['slug'] = Str::slug($designation->designation) . '-' . time();
            $committee = Committee::whereId($validated['committee_id'])->first();

            foreach ($validated['user_id'] as $value) {
                $checkDataExist = CommitteeMember::where(['conference_id' => $latestConference->id, 'committee_id' => $validated['committee_id'], 'user_id' => $value, 'status' => 1])->first();
                if (!empty($checkDataExist)) {
                    throw new Exception("User is already added as committee member.", 1);
                }
            }

            foreach ($validated['user_id'] as $value) {
                $data['conference_id'] = $latestConference->id;
                $data['committee_id'] = $validated['committee_id'];
                $data['user_id'] = $value;
                $data['designation_id'] = $validated['designation_id'];
                $data['message'] = $validated['message'];
                $data['slug'] = Str::slug($designation->designation) . '-' . time();
                $data['created_at'] = now();
                $data['updated_at'] = now();
                $insertArray[] = $data;
            }

            CommitteeMember::insert($insertArray);

            return redirect()->route('committeeMember.index', $committee->slug)->with('status', 'Committee Member Added Successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('delete', $e->getMessage());
        }
    }

    public function edit(CommitteeMember $committee_member)
    {
        $committee = Committee::whereId($committee_member->committee_id)->first();
        $designations = Designation::where('status', 1)->get();
        $users = User::where(['role' => 2, 'status' => 1])->orderBy('f_name', 'ASC')->get();
        return view('backend.committee.members.create', compact('committee', 'designations', 'users', 'committee_member'));
    }

    public function update(Request $request, CommitteeMember $committee_member)
    {
        try {
            $validated = $request->validate([
                'committee_id' => 'required',
                'user_id' => 'required',
                'designation_id' => 'required',
                'message' => 'nullable'
            ]);

            $designation = Designation::whereId($request->designation_id)->first();
            $validated['slug'] = Str::slug($designation->designation) . '-' . time();
            $committee = Committee::whereId($validated['committee_id'])->first();
            $validated['user_id'] = $request->user_id[0];

            $committee_member->update($validated);

            return redirect()->route('committeeMember.index', $committee->slug)->with('status', 'Committee Member Updated Successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('delete', $e->getMessage());
        }
    }

    public function destroy(CommitteeMember $committee_member)
    {
        $committee_member->update(['status' => 0]);
        $committee = Committee::whereId($committee_member->committee_id)->first();

        return redirect()->route('committeeMember.index', $committee->slug)->with('delete', 'Committee Member Deleted Successfully');
    }

    public function changeFeatured(CommitteeMember $committee_member)
    {
        if ($committee_member->is_featured == 1) {
            $isFeatured = 0;
        } else {
            $isFeatured = 1;
        }

        $committee_member->update(['is_featured' => $isFeatured]);

        return redirect()->back()->with('status', 'Committee Member featured status changed successfully.');
    }

    // public function submitData(Request $request)
    // {
    //     try {
    //         $type = 'success';
    //         $insertArray = [];
    //         $updateArray = [];

    //         if (empty($request->user_id)) {
    //             throw new Exception("Select atleast 1 user.", 1);
    //         }

    //         $latestConference = Conference::latestConference();
    //         foreach ($request->user_id as $value) {
    //             $checkDataExist = CommitteeMember::where(['conference_id' => $latestConference->id, 'committee_id' => $request->committee_id, 'user_id' => $value])->first();
    //             if (empty($checkDataExist)) {
    //                 $array['conference_id'] = $latestConference->id;
    //                 $array['committee_id'] = $request->committee_id;
    //                 $array['user_id'] = $value;
    //                 $array['created_at'] = now();
    //                 $array['updated_at'] = now();
    //                 $insertArray[] = $array;
    //             } else {
    //                 $updatedDataArray['id'] = $checkDataExist->id;
    //                 $updatedDataArray['status'] = 1;
    //                 $updatedDataArray['updated_at'] = now();
    //                 $updateArray[] = $updatedDataArray;
    //             }
    //         }

    //         $members = CommitteeMember::where(['conference_id' => $latestConference->id, 'committee_id' => $request->committee_id, 'status' => 1])->whereNotIn('user_id', $request->user_id)->get()->toArray();
    //         if (!empty($members)) {
    //             foreach ($members as $v) {
    //                 $updatedDataArray2['id'] = $v['id'];
    //                 $updatedDataArray2['status'] = 0;
    //                 $updatedDataArray2['updated_at'] = now();
    //                 $updateArray[] = $updatedDataArray2;
    //             }
    //         }

    //         if (!empty($insertArray)) {
    //             CommitteeMember::insert($insertArray);
    //         }

    //         if (!empty($updateArray)) {
    //             Batch::update(new CommitteeMember, $updateArray, 'id');
    //         }

    //         $message = "Committee members added successfully";

    //     } catch (Exception $e) {
    //         $type = 'error';
    //         $message = $e->getMessage();
    //     }
    //     return response()->json(['type' => $type, 'message' => $message]);
    // }
}
