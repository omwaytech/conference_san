<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\Workshop\Request\{AcceptMail, RejectMail, CorrectionMail};
use App\Models\{Conference, Workshop, WorkshopRegistrationPrice, User, WorkshopDiscussion};
use Illuminate\Http\Request;
use Exception, Str, DB, Storage, Mail, Hash, Excel, Batch;

class WorkshopController extends Controller
{
    // =================================================== Workshop CRUD operation start ===================================================
    public function index()
    {
        $authUser = auth()->user();
        $latestConference = Conference::latestConference();
        $conference = session()->get('conferenceDetail');

        if ($authUser->role == 1) {
            $workshops = Workshop::where(['conference_id' => $conference->id, 'status' => 1])->latest()->get();
        } elseif ($authUser->role == 2) {
            $workshops = Workshop::where(['user_id' => $authUser->id, 'conference_id' => $latestConference->id, 'status' => 1])->latest()->get();
        }

        return view('backend.workshops.show', compact('workshops', 'authUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authUser = auth()->user();
        return view('backend.workshops.create', compact('authUser'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required',
                'venue' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'no_of_days' => 'required|integer',
                'time' => 'required',
                'chair_person_name' => 'required',
                'chair_person_affiliation' => 'required',
                'chair_person_image' => 'required|mimes:jpg,png|max:500',
                'chair_person_cv' => 'required|mimes:pdf|max:250',
                'contact_person_name' => 'required',
                'contact_person_email' => 'required',
                'contact_person_phone' => 'required',
                'cpd_point' => 'nullable',
                'no_of_participants' => 'required|integer',
                'registration_deadline' => 'required|date',
                'estimated_budget' => 'nullable',
                'description' => 'nullable',
            ]);

            $cvName = time() . rand(0, 99) . '.' . $validated['chair_person_cv']->getClientOriginalExtension();
            Storage::putFileAs("public/workshop/chairperson/cv", $validated['chair_person_cv'], $cvName);
            $validated['chair_person_cv'] = $cvName;

            $imageName = time() . rand(0, 99) . '.' . $validated['chair_person_image']->getClientOriginalExtension();
            Storage::putFileAs("public/workshop/chairperson/image", $validated['chair_person_image'], $imageName);
            $validated['chair_person_image'] = $imageName;

            $validated['slug'] = Str::slug($validated['title']) . '-' . time();
            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;
            $validated['user_id'] = auth()->user()->id;

            // for applied workshops start
            if (auth()->user()->role == 2) {
                $validated['is_applied'] = 1;
                $validated['approved_status'] = 0;
            }
            // for applied workshops end

            Workshop::create($validated);

            return redirect()->route('workshop.index')->with('status', 'Workshop Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show(Request $request)
    {
        $workshop = Workshop::whereId($request->id)->first();
        return view('backend.workshops.view-data', compact('workshop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workshop $workshop)
    {
        // if ($workshop->user_id != auth()->user()->id) {
        //     return redirect()->route('workshop.index')->with('delete', 'Permission Denied');
        // }
        $authUser = auth()->user();
        return view('backend.workshops.create', compact('workshop', 'authUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workshop $workshop)
    {
        try {
            $validated = $request->validate([
                'title' => 'required',
                'venue' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'no_of_days' => 'required|integer',
                'time' => 'required',
                'chair_person_name' => 'required',
                'chair_person_affiliation' => 'required',
                'chair_person_image' => 'nullable|mimes:jpg,png|max:500',
                'chair_person_cv' => 'nullable|mimes:pdf|max:250',
                'contact_person_name' => 'required',
                'contact_person_email' => 'required',
                'contact_person_phone' => 'required',
                'cpd_point' => 'nullable',
                'no_of_participants' => 'required|integer',
                'registration_deadline' => 'required|date',
                'estimated_budget' => 'nullable',
                'description' => 'nullable',
            ]);

            if (!empty($validated['chair_person_cv'])) {
                Storage::delete("public/workshop/chairperson/cv/" . $workshop->chair_person_cv);
                $cvName = time() . rand(0, 99) . '.' . $validated['chair_person_cv']->getClientOriginalExtension();
                Storage::putFileAs("public/workshop/chairperson/cv", $validated['chair_person_cv'], $cvName);
                $validated['chair_person_cv'] = $cvName;
            }

            if (!empty($validated['chair_person_image'])) {
                Storage::delete("public/workshop/chairperson/image/" . $workshop->chair_person_image);
                $imageName = time() . rand(0, 99) . '.' . $validated['chair_person_image']->getClientOriginalExtension();
                Storage::putFileAs("public/workshop/chairperson/image", $validated['chair_person_image'], $imageName);
                $validated['chair_person_image'] = $imageName;
            }
            if ($workshop->is_applied == 1) {
                $validated['approved_status'] = 0;
            }

            $workshop->update($validated);

            return redirect()->route('workshop.index')->with('status', 'Workshop Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workshop $workshop)
    {
        $workshop->update(['status' => 0]);

        return redirect()->back()->with('delete', 'Workshop Deleted Successfully');
    }

    public function coordinatorPass()
    {
        $workshops = Workshop::where('status', 1)->get();
        return view('backend.workshops.coordinator_pass', compact('workshops'));
    }

    // =================================================== Workshop CRUD operation end ===================================================

    // =================================================== Price allocation section start ===================================================

    public function allocatePriceForm(Request $request)
    {
        $workshop = Workshop::whereId($request->id)->first();
        $sql = "SELECT
                    MT.id,
                    MT.type,
                    MT.delegate,
                    WRP.price_id,
                    WRP.workshop_id,
                    WRP.member_type_id,
                    WRP.price
                FROM member_types AS MT
                LEFT JOIN
                    (SELECT
                        id AS price_id,
                        workshop_id,
                        member_type_id,
                        price
                    FROM
                        workshop_registration_prices
                        WHERE workshop_id = $workshop->id
                    ) AS WRP ON MT.id = WRP.member_type_id WHERE MT.status = 1";

        $memberTypes = DB::select($sql);
        return view('backend.workshops.allocate-price', compact('workshop', 'memberTypes'));
    }

    public function allocatePriceSubmit(Request $request)
    {
        try {
            $type = 'success';
            $insertArray = [];
            $updateArray = [];
            foreach ($request->member_type_id as $key => $value) {
                if (empty($request->price_id[$key])) {
                    $array['workshop_id'] = $request->workshop_id;
                    $array['member_type_id'] = $value;
                    $array['price'] = $request->price[$key];
                    $array['created_at'] = now();
                    $array['updated_at'] = now();
                    $insertArray[] = $array;
                } else {
                    $updatedDataArray['id'] = $request->price_id[$key];
                    $updatedDataArray['workshop_id'] = $request->workshop_id;
                    $updatedDataArray['member_type_id'] = $value;
                    $updatedDataArray['price'] = $request->price[$key];
                    $updatedDataArray['updated_at'] = now();
                    $updateArray[] = $updatedDataArray;
                }
            }

            if (!empty($insertArray)) {
                WorkshopRegistrationPrice::insert($insertArray);
            }

            if (!empty($updateArray)) {
                Batch::update(new WorkshopRegistrationPrice, $updateArray, 'id');
            }

            if (empty($updateArray)) {
                $message = "Price Submitted successfully";
            } else {
                $message = "Price Updated successfully";
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    // =================================================== Price allocation section end ===================================================

    // =================================================== Applied workshop section start ===================================================
    public function requested()
    {
        $latestConference = Conference::latestConference();
        $workshops = Workshop::where(['conference_id' => $latestConference->id, 'status' => 1])->whereNot('approved_status', 1)->get();
        return view('backend.workshops.request.requested', compact('workshops'));
    }

    public function makeDecisionForm(Request $request)
    {
        $workshop = Workshop::whereId($request->id)->first();
        return view('backend.workshops.request.make-decision-modal', compact('workshop'));
    }

    public function decideRequest(Request $request)
    {
        try {
            $rules = [
                'approved_status' => 'required'
            ];
            if ($request->approved_status == '1') {
                $rules['cpd_point'] = 'nullable|numeric';
            }
            if ($request->approved_status == '3') {
                $rules['remarks'] = 'required';
            }
            if ($request->approved_status == '2') {
                $rules['remarks'] = 'required';
                $rules['attachment'] = 'nullable|mimes:pdf|max:1024';
            }
            $validated = $request->validate($rules);

            if ($validated) {
                $workshop = Workshop::whereId($request->id)->first();
                DB::beginTransaction();
                $mailData = [
                    'name' => $workshop->organizer->name,
                    'workshopTitle' => $workshop->title,
                ];

                if ($validated['approved_status'] == 1 || $validated['approved_status'] == 3) {
                    if ($request->approved_status == '1') {
                        Mail::to($workshop->organizer->email)->send(new AcceptMail($mailData));
                    } elseif ($request->approved_status == '3') {
                        $mailData['remarks'] = $validated['remarks'];
                        Mail::to($workshop->organizer->email)->send(new RejectMail($mailData));
                    }

                    // update table-1
                    $workshop->update($validated);
                }

                if ($validated['approved_status'] == 2) {
                    $mailData['remarks'] = $validated['remarks'];
                    if (!empty($validated['attachment'])) {
                        $fileName = time() . '.' . $validated['attachment']->getClientOriginalExtension();
                        Storage::putFileAs("public/workshop/discussion/attachment", $validated['attachment'], $fileName);
                        $validated['attachment'] = $fileName;
                    }
                    $validated['workshop_id'] = $workshop->id;
                    $validated['user_id'] = auth()->user()->id;

                    Mail::to($workshop->organizer->email)->send(new CorrectionMail($mailData));

                    // update table-1
                    $workshop->update(['approved_status' => 2]);

                    // insert table-2
                    WorkshopDiscussion::create($validated);
                }
                DB::commit();
                return response()->json(['message' => 'Request decided successfully.']);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function discussions($slug)
    {
        $workshop = Workshop::whereSlug($slug)->first();
        return view('backend.workshops.request.discussions', compact('workshop'));
    }
    // =================================================== Applied workshop section end ===================================================
}
