<?php

namespace App\Http\Controllers\Backend;

use App\Exports\SubmissionExport;
use App\Http\Controllers\Controller;
use App\Mail\Submission\{SubmissionAcceptMail, SubmissionCorrectionMail, SubmissionRejectMail, SubmissionSubmittedMail, ExpertForwardMail, SubmissionSubmittedToUserMail};
use App\Models\{ConferenceRegistration, User, SubmissionDiscussion, SubmissionSetting, Submission, Conference, Author, UserDetail, Expert, Committee, CommitteeMember, Hall, ScientificSessionCategory, ScientificSession};
use App\Models\Designation;
use Illuminate\Http\Request;
use Exception, Storage, DB, Mail, Excel;
use Carbon\Carbon;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $latestConference = Conference::latestConference();
        $authUser = auth()->user();

        $checkScientificCommitee = null;
        if ($authUser->role == 2) {
            $scientificCommittee = Committee::where('committee_name', 'Scientific Committee')->first();
            $checkScientificCommitee = CommitteeMember::where(['conference_id' => $latestConference->id, 'committee_id' => $scientificCommittee->id, 'user_id' => $authUser->id, 'status' => 1])->first();
            // dd($checkScientificCommitee->designation->designation == "Scientific Committee Chairperson");
            if (!empty($checkScientificCommitee) && $checkScientificCommitee->designation->designation == "Scientific Committee Chairperson") {
                $presentationType = $request->input('presentation_type');
                $requestStatus = $request->input('request_status');

                $submissions = Submission::getData($presentationType, $requestStatus);
            } else {
                $presentationType = $request->input('presentation_type');
                $requestStatus = $request->input('request_status');


                $submissions = Submission::where(['conference_id' => $latestConference->id, 'status' => 1])->where('user_id', $authUser->id)->orWhere('expert_id', $authUser->id)->when($presentationType, function ($query, $presentationType) {
                    return $query->where('presentation_type', $presentationType);
                })
                    ->when(isset($requestStatus), function ($query) use ($requestStatus) {
                        return $query->where('request_status', $requestStatus);
                    })

                    ->with('user')
                    ->orderByDesc('id')
                    ->get();
            }
        } elseif ($authUser->role == 1) {
            $presentationType = $request->input('presentation_type');
            $requestStatus = $request->input('request_status');
            $submissions = Submission::getData($presentationType, $requestStatus);
        }
        return view('backend.submission.show', compact('submissions', 'authUser', 'checkScientificCommitee'));
    }
 
    public function create()
    {
        // $userDetail = UserDetail::where('user_id', auth()->user()->id)->first();
        // if (empty($userDetail)) {
        //     return redirect()->route('home.editProfile')->with('delete', 'Please update your profile at first to request submission.');
        // } else {
        //     $latestConference = Conference::latestConference();
        //     $setting = SubmissionSetting::where('conference_id', $latestConference->id)->select('abstract_word_limit', 'keyword_word_limit')->first();
        //     return view('backend.submission.create', compact('setting'));
        // }
        $userDetail = UserDetail::where('user_id', auth()->id())->first();

        if (!$userDetail) {
            return redirect()->route('home.editProfile')->with('delete', 'Please update your profile first before requesting a submission.');
        }

        $latestConference = Conference::latestConference();

        $setting = SubmissionSetting::where('conference_id', $latestConference->id)
            ->select('abstract_word_limit', 'keyword_word_limit', 'deadline')
            ->first();

        if (!$setting) {
            return redirect()->back()->with('delete', 'Submission settings not found.');
        }

        $deadline = Carbon::parse($setting->deadline);
        if ($deadline->isPast()) {
            return redirect()->back()->with('delete', 'Submission date has ended.');
        }

        return view('backend.submission.create', compact('setting'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'topic' => 'required',
                'presentation_type' => 'required',
                // 'cover_letter' => 'required',
                'has_presented_before' => 'required',
                'abstract_content' => 'required',
                'keywords' => 'nullable',
            ];

            // if ($request->presentation_type == 1) {
            //     $rules['presentation_file'] = 'required|mimes:pdf,ppt,pptx,pptm|max:1024';
            // } elseif ($request->presentation_type == 2) {
            //     $rules['abstract_content'] = 'required';
            //     $rules['keywords'] = 'nullable';
            // } elseif ($request->presentation_type == 3) {
            //     $rules['presentation_file'] = 'required|mimes:doc,docx|max:5120';
            //     $rules['abstract_content'] = 'required';
            //     $rules['keywords'] = 'nullable';
            // }

            if ($request->has('has_presented_before') && $request->has_presented_before == 1) {
                $rules['presentation_place'] = 'required';
            }

            $validated = $request->validate($rules);

            $latestConference = Conference::latestConference();
            // check words count in keyword and abstract cover letter start
            if ($request->presentation_type == 2 || $request->presentation_type == 3) {
                $setting = SubmissionSetting::where('conference_id', $latestConference->id)->select('abstract_word_limit', 'keyword_word_limit')->first();

                if (!empty($validated['keywords']) && !empty($setting->keyword_word_limit)) {
                    $keywordsCount = count(explode(',', $request->keywords));
                    if ($keywordsCount > $setting->keyword_word_limit) {
                        return redirect()->back()->withInput()->with('delete', 'Keywords word limit exceeded.');
                    }

                    $keyWordsArray = explode(', ', $validated['keywords']);
                    sort($keyWordsArray);
                    $validated['keywords'] = implode(', ', $keyWordsArray);
                }

                $abstractWordCount = str_word_count(strip_tags($request->abstract_content));
                if (!empty($setting->abstract_word_limit) && $abstractWordCount > $setting->abstract_word_limit) {
                    return redirect()->back()->withInput()->with('delete', 'Abstract word limit exceeded.');
                }
            }
            // check words count in keyword and abstract cover letter end

            if (!empty($validated['presentation_file'])) {
                $fileName = time() . '.' . $validated['presentation_file']->getClientOriginalExtension();
                Storage::putFileAs("public/submission/presentation-file", $validated['presentation_file'], $fileName);
                $validated['presentation_file'] = $fileName;
            }
            $authUser = User::whereId(auth()->user()->id)->first();
            $latestConference = Conference::latestConference();
            $validated['user_id'] = $authUser->id;
            $validated['conference_id'] = $latestConference->id;
            $conferenceRegistration = ConferenceRegistration::where('user_id', $authUser->id)->first();
            if (!empty($conferenceRegistration)) {
                $validated['conference_registration_id'] = $conferenceRegistration->id;
            } else {
                $validated['has_registered_conference'] = 0;
            }
            $validated['submitted_date'] = now();

            // $scientificCommittee = Committee::where('committee_name', 'Scientific Committee')->first()->committeeMembers->where('conference_id', $latestConference->id)->where('status', 1);
            // if ($scientificCommittee->isNotEmpty()) {
            //     foreach ($scientificCommittee as $value) {
            //         if ($value->designation->designation == 'Scientific Committee Chairperson') {
            //             $mailData = [
            //                 'receiverName' => $value->user->fullName($value, 'user'),
            //                 'namePrefix' => $value->user->namePrefix->prefix,
            //                 'topic' => $validated['topic'],
            //             ];
            //             Mail::to($value->user->email)->send(new SubmissionSubmittedMail($mailData));
            //         }
            //     }
            // }
            $userMailData = [
                'name' => $authUser->fullName($authUser),
                'namePrefix' => $authUser->namePrefix->prefix,
                'topic' => $validated['topic']
            ];
            Mail::to($authUser->email)->send(new SubmissionSubmittedToUserMail($userMailData));

            DB::beginTransaction();
            $submitSubmission = Submission::create($validated);

            $validated['submission_id'] = $submitSubmission->id;
            $validated['name'] = $authUser->fullName($authUser);
            $validated['email'] = $authUser->email;
            $validated['phone'] = $authUser->userDetail->phone;
            $validated['designation'] = $authUser->userDetail->affiliation;
            $validated['institution'] = $authUser->userDetail->institute_name;
            $validated['institution_address'] = $authUser->userDetail->address;

            Author::create($validated);
            DB::commit();
            return redirect()->route('submission.index')->with('status', 'Submission Added Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $latestConference = Conference::latestConference();
        $submission = Submission::where('id', $id)->first();
        if ($submission == null) {
            return redirect()->route('submission.index')->with('delete', 'Permission Denied.');
        } else {
            if (auth()->user()->id != $submission->user_id) {
                return redirect()->route('submission.index')->with('delete', 'Permission Denied.');
            } else {
                $setting = SubmissionSetting::where('conference_id', $latestConference->id)->select('abstract_word_limit', 'keyword_word_limit')->first();
                return view('backend.submission.create', compact('submission', 'setting'));
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission)
    {
        try {
            $rules = [
                'topic' => 'required',
                'presentation_type' => 'required',
                // 'cover_letter' => 'required',
                'has_presented_before' => 'required',
                'abstract_content' => 'required',
                'keywords' => 'nullable',
            ];

            // if ($request->presentation_type == 1) {
            //     $rules['presentation_file'] = 'nullable|mimes:pdf,ppt,pptx,pptm|max:1024';
            //     $rules['abstract_content'] = 'nullable';
            //     $rules['keywords'] = 'nullable';
            // } elseif ($request->presentation_type == 2) {
            //     $rules['presentation_file'] = 'nullable';
            //     $rules['abstract_content'] = 'required';
            //     $rules['keywords'] = 'nullable';
            // } elseif ($request->presentation_type == 3) {
            //     $rules['presentation_file'] = 'nullable|mimes:doc,docx|max:5120';
            //     $rules['abstract_content'] = 'required';
            //     $rules['keywords'] = 'nullable';
            // }

            if ($request->has('has_presented_before') && $request->has_presented_before == 1) {
                $rules['presentation_place'] = 'required';
            }

            $validated = $request->validate($rules);

            if ($request->has_presented_before == 0) {
                $validated['presentation_place'] = null;
            }

            $latestConference = Conference::latestConference();
            // check words count in keyword and abstract cover letter start
            if ($request->presentation_type == 2 || $request->presentation_type == 3) {
                $setting = SubmissionSetting::select('abstract_word_limit', 'keyword_word_limit')->first();

                if (!empty($setting->keyword_word_limit) && !empty($validated['keywords'])) {
                    $keywordsCount = count(explode(',', $request->keywords));
                    if ($keywordsCount > $setting->keyword_word_limit) {
                        return redirect()->back()->withInput()->with('delete', 'Keywords word limit exceeded.');
                    }

                    $keyWordsArray = explode(', ', $validated['keywords']);
                    sort($keyWordsArray);
                    $validated['keywords'] = implode(', ', $keyWordsArray);
                }

                $abstractWordCount = str_word_count(strip_tags($request->abstract_content));
                if (!empty($setting->abstract_word_limit) && $abstractWordCount > $setting->abstract_word_limit) {
                    return redirect()->back()->withInput()->with('delete', 'Abstract word limit exceeded.');
                }
            }
            // check words count in keyword and abstract cover letter end

            if (!empty($validated['presentation_file'])) {
                Storage::delete("public/submission/presentation-file/{$submission->image}");
                $fileName = time() . '.' . $validated['presentation_file']->getClientOriginalExtension();
                Storage::putFileAs("public/submission/presentation-file", $validated['presentation_file'], $fileName);
                $validated['presentation_file'] = $fileName;
            }

            if ($submission->request_status == 2 || $submission->request_status == 0) {
                $validated['request_status'] = 0;

                $committeeArray = [];
                if (!empty($submission->expert_id)) {
                    $expert = Expert::where(['user_id' => $submission->expert_id, 'conference_id' => $latestConference->id, 'status' => 1])->first();
                    $expertData = ['name' => $expert->expert->fullName($expert, 'expert'), 'email' => $expert->expert->email];
                    // $scientificCommittee = Committee::where('committee_name', 'Scientific Committee')->first()->committeeMembers->where('conference_id', $latestConference->id)->where('status', 1);

                    // foreach ($scientificCommittee as $value) {
                    //     if ($value->designation->designation == 'Scientific Committee Chairperson') {
                    //         $mailData = [
                    //             'name' => $value->user->fullName($value, 'user'),
                    //             'namePrefix' => $value->user->namePrefix->prefix,
                    //             'email' => $value->user->email
                    //         ];
                    //         $committeeArray[] = $mailData;
                    //     }
                    // }
                    array_push($committeeArray, $expertData);
                } else {
                    // $scientificCommittee = Committee::where('committee_name', 'Scientific Committee')->first()->committeeMembers->where('conference_id', $latestConference->id)->where('status', 1);
                    // foreach ($scientificCommittee as $value) {
                    //     if ($value->designation->designation == 'Scientific Committee Chairperson') {
                    //         $mailData = [
                    //             'name' => $value->user->fullName($value, 'user'),
                    //             'namePrefix' => $value->user->namePrefix->prefix,
                    //             'email' => $value->user->email
                    //         ];
                    //         $committeeArray[] = $mailData;
                    //     }
                    // }
                }

                if (!empty($committeeArray)) {
                    foreach ($committeeArray as $value) {
                        $mailData = [
                            'receiverName' => $value['name'],
                            'namePrefix' => $value['namePrefix'],
                            'topic' => $validated['topic'],
                        ];
                        Mail::to($value['email'])->send(new SubmissionSubmittedMail($mailData));
                    }
                }
            }

            $submission->update($validated);

            return redirect()->route('submission.index')->with('status', 'Submission Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        $submission->update(['status' => 0]);

        return redirect()->route('submission.index')->with('delete', 'Submission Deleted Successfully');
    }

    public function exportExcel()
    {
        $fileName = 'Submission.xlsx';

        return Excel::download(new SubmissionExport(), $fileName);
    }

    public function expertForwardForm(Request $request)
    {
        $submission = Submission::whereId($request->id)->first();
        $experts = Expert::where(['conference_id' => $submission->conference_id, 'status' => 1])->whereNot('user_id', $submission->user_id)->get();
        return view('backend.submission.expert-forward-modal', compact('submission', 'experts'));
    }

    // forward presentation request to expert
    public function expertForward(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Forwarded to expert successfully.';
            $validated = $request->validate([
                'expert_id' => 'required'
            ]);
            if ($validated) {
                $submission = Submission::whereId($request->id)->first();
                if ($validated['expert_id'] == $submission->user_id) {
                    throw new Exception("Presenter and Expert should not be same.", 1);
                }
                $validated['forward_expert'] = 1;

                $expert = User::whereId($validated['expert_id'])->first();
                $mailData = [
                    'name' => $expert->fullName($expert),
                    'namePrefix' => $expert->namePrefix->prefix,
                    'topic' => $submission->topic
                ];
                Mail::to($expert->email)->send(new ExpertForwardMail($mailData));

                $submission->update($validated);
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function decideRequestForm(Request $request)
    {
        $submission = Submission::whereId($request->id)->first();
        $latestConference = Conference::latestConference();
        $setting = SubmissionSetting::where('conference_id', $latestConference->id)->select('abstract_word_limit', 'keyword_word_limit')->first();

        // for scheduling submission
        $halls = Hall::where('status', 1)->get();
        $users = User::where(['role' => 2, 'status' => 1])->get();
        $categories = ScientificSessionCategory::where('status', 1)->get();
        $latestConference = Conference::latestConference();
        $startDate = Carbon::parse($latestConference->start_date);
        $endDate = Carbon::parse($latestConference->end_date);

        $dates = [];

        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
        return view('backend.submission.make-decision-modal', compact('submission', 'setting', 'halls', 'users', 'dates', 'categories'));
    }

    public function decideRequest(Request $request)
    {
        try {
            $submission = Submission::whereId($request->id)->first();
            $presenterId =  [strval($submission->presenter->id)];
            $rules = [
                'request_status' => 'required'
            ];
            if ($request->request_status == 1) {
                $rules['day'] = 'required';
                $rules['time'] = 'required';
                $rules['duration'] = 'required';
                $rules['category_id'] = 'required';
                $rules['type'] = 'required';
                $rules['hall_id'] = 'required';
                $rules['chairperson'] = 'nullable';
                $rules['co_chairperson'] = 'nullable';
            } elseif ($request->request_status == 2) {
                $rules['remarks'] = 'required';
                $rules['attachment'] = 'nullable|mimes:pdf';
                if ($submission->presentation_type == 2 || $submission->presentation_type == 3) {
                    $rules['abstract_content'] = 'required';
                }
            } elseif ($request->request_status == 3) {
                $rules['remarks'] = 'required';
            }
            $validated = $request->validate($rules);
            $validated['presenter_name'] = $submission->presenter->fullName($submission, 'presenter');
            $validated['namePrefix'] = $submission->presenter->namePrefix->prefix;
            $validated['topic'] = $submission->topic;

            if ($request->request_status == 2) {
                Mail::to($submission->presenter->email)->send(new SubmissionCorrectionMail($validated));
                DB::beginTransaction();
                // update table 1
                if ($submission->presentation_type == 1) {
                    $submission->update(['request_status' => 2]);
                } else {
                    $submission->update(['request_status' => 2, 'abstract_content' => $validated['abstract_content']]);
                }

                // insert into table 2
                $validated['submission_id'] = $request->id;
                $validated['sender_id'] = auth()->user()->id;
                if (!empty($validated['attachment'])) {
                    $fileName = time() . '.' . $validated['attachment']->getClientOriginalExtension();
                    Storage::putFileAs("public/submission/discussion", $validated['attachment'], $fileName);
                    $validated['attachment'] = $fileName;
                }

                SubmissionDiscussion::create($validated);
                DB::commit();
                return response()->json(['message' => 'Request updated for correction.']);
            } else {
                DB::beginTransaction();
                if ($request->request_status == 1) {
                    $message = 'Request accepted successfully.';
                    $validated['accepted_date'] = now();
                    Mail::to($submission->presenter->email)->send(new SubmissionAcceptMail($validated));
                } else {
                    $message = 'Request rejected successfully.';
                    Mail::to($submission->presenter->email)->send(new SubmissionRejectMail($validated));
                }

                $submission->update($validated);

                if ($request->request_status == 1) {
                    $checkAvailabilityOfTime = ScientificSession::where(['day' => $request->day, 'time' => $request->time, 'hall_id' => $request->hall_id, 'status' => 1])->first();
                    if (empty($checkAvailabilityOfTime)) {
                        if (!empty($request->chairperson)) {
                            $validated['chairperson'] = json_encode($request->chairperson);
                        } else {
                            $validated['chairperson'] = null;
                        }
                        if (!empty($request->co_chairperson)) {
                            $validated['co_chairperson'] = json_encode($request->co_chairperson);
                        } else {
                            $validated['co_chairperson'] = null;
                        }
                        $validated['participants'] = json_encode($presenterId);

                        $latestConference = Conference::latestConference();
                        $validated['conference_id'] = $latestConference->id;
                        unset($validated['topic']);
                        ScientificSession::create($validated);
                    } else {
                        throw new Exception("Time Slot Already Consumed For This Hall.", 1);
                    }
                }
                DB::commit();
                return response()->json(['message' => $message]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function viewDiscussion($id)
    {
        $submission = Submission::where('id', $id)->first();
        $authUser = auth()->user();
        $latestConference = Conference::latestConference();

        $checkScientificCommitee = null;
        if ($authUser->role == 2) {
            $scientificCommittee = Committee::where('committee_name', 'Scientific Committee')->first();
            $checkScientificCommitee = CommitteeMember::where(['conference_id' => $latestConference->id, 'committee_id' => $scientificCommittee->id, 'user_id' => $authUser->id, 'status' => 1])->first();
        }
        $discussions = SubmissionDiscussion::where('submission_id', $submission->id)->get();
        return view('backend.submission.discussion', compact('submission', 'discussions', 'authUser', 'checkScientificCommitee', 'latestConference'));
    }

    public function committeeCommentForm(Request $request)
    {
        $discussion = SubmissionDiscussion::where('id', $request->id)->first();
        return view('backend.submission.committee-comment-modal', compact('discussion'));
    }

    public function submitComment(Request $request)
    {
        try {
            $rules = [
                'committee_remarks' => 'required'
            ];

            $validated = $request->validate($rules);

            if ($request->has('expert_visible')) {
                $validated['expert_visible'] = 1;
            } else {
                $validated['expert_visible'] = 0;
            }

            DB::beginTransaction();

            $validated['committee_member_id'] = auth()->user()->id;
            $discussion = SubmissionDiscussion::where('id', $request->id)->first();
            if ($request->has('presenter_visible')) {
                $validated['presenter_visible'] = 1;
                $submission = Submission::where('id', $discussion->submission_id)->first();
                $mailData['presenter_name'] = $submission->presenter->fullName($submission, 'presenter');
                $mailData['remarks'] = $discussion->remarks;
                $mailData['topic'] = $submission->topic;
                Mail::to($submission->presenter->email)->send(new SubmissionCorrectionMail($mailData));
            }
            $discussion->update($validated);

            DB::commit();
            return response()->json(["message" => "Successfully commented on expert's review."]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function viewData(Request $request)
    {
        $submission = Submission::whereId($request->id)->first();
        $latestConference = Conference::latestConference();
        $authUser = auth()->user();
        $checkScientificCommitee = null;
        if ($authUser->role == 2) {
            $scientificCommittee = Committee::where('committee_name', 'Scientific Committee')->first();
            $checkScientificCommitee = CommitteeMember::where(['conference_id' => $latestConference->id, 'committee_id' => $scientificCommittee->id, 'user_id' => $authUser->id, 'status' => 1])->first();
        }
        return view('backend.submission.view-data-modal', compact('submission', 'authUser', 'checkScientificCommitee'));
    }

    public function bulkWordExport(Request $request)
    {
        if ($request->selected_presentation_type == null || $request->selected_request_status == null) {
            return redirect()->back()->with('delete', 'Please select presentation type, request status and submission track');
        } else {
            $authUser = auth()->user();
            $latestConference = Conference::latestConference();
            $scientificCommittee = DB::table('committees')
                ->where('committee_name', 'Scientific Committee')
                ->first();
            $checkScientificCommitee = DB::table('committee_members')
                ->where([
                    'conference_id' => $latestConference->id,
                    'committee_id' => $scientificCommittee->id,
                    'user_id' => $authUser->id,
                    'status' => 1,
                ])
                ->first();
            if (!empty($authUser->expert) || !empty($checkScientificCommitee)) {

                if (!empty($checkScientificCommitee)) {
                    $submissions = Submission::where(['presentation_type' => $request->selected_presentation_type, 'request_status' => $request->selected_request_status, 'status' => 1])->get();
                } else {
                    // dd('dd');
                    $submissions = Submission::where(['presentation_type' => $request->selected_presentation_type, 'expert_id' => $authUser->id, 'request_status' => $request->selected_request_status, 'status' => 1])->get();
                }
                // dd($submissions);
            } else {
                $submissions = Submission::where(['presentation_type' => $request->selected_presentation_type, 'request_status' => $request->selected_request_status, 'status' => 1])->get();
            }
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            foreach ($submissions as $submission) {
                $authors = $submission->authors;
                $mainAuthor = null;
                $names = '';
                $affiliation = [];

                if ($authors->isNotEmpty()) {
                    $mainAuthor = $authors->first();
                    $groupedAuthors = $authors->groupBy(['designation', 'institution', 'institution_address']);
                    $duplicatedData = [];
                    $nonDuplicatedData = [];
                    $i = 1;

                    foreach ($groupedAuthors as $designationGroup) {
                        foreach ($designationGroup as $institutionGroup) {
                            foreach ($institutionGroup as $addressGroup) {
                                foreach ($addressGroup as $record) {
                                    $data = [
                                        'designation' => $record->designation ?? '',
                                        'institution' => $record->institution ?? '',
                                        'institution_address' => $record->institution_address ?? '',
                                        'countValue' => $i,
                                    ];

                                    if ($addressGroup->count() > 1) {
                                        $duplicatedData[$record->name][] = $data;
                                    } else {
                                        $nonDuplicatedData[$record->name] = $data;
                                    }
                                }
                                $i++;
                            }
                        }
                    }

                    $uniqueValues = [];
                    foreach ($duplicatedData as $key => $value) {
                        $names .= $key . ' ' . $value[0]['countValue'] . ', ';
                        if (!in_array($value[0]['countValue'], $uniqueValues)) {
                            $affiliation[] = $value[0]['countValue'] . $value[0]['designation'] . ', ' . $value[0]['institution'] . ', ' . $value[0]['institution_address'];
                            $uniqueValues[] = $value[0]['countValue'];
                        }
                    }

                    foreach ($nonDuplicatedData as $key => $value) {
                        $names .= $key . ' ' . $value['countValue'] . ', ';
                        $affiliation[] = $value['countValue'] . $value['designation'] . ', ' . $value['institution'] . ', ' . $value['institution_address'];
                    }

                    $names = rtrim($names, ', ');
                }

                // Add submission section
                $section = $phpWord->addSection();
                $presentationType = $submission->presentation_type == 1 ? 'Poster Submission' : 'Oral Submission';
                $section->addText($presentationType, ['name' => 'Times New Roman', 'size' => 18, 'bold' => true]);
                $section->addTextBreak(1);
                $section->addText($submission->topic, ['name' => 'Times New Roman', 'size' => 16, 'bold' => true]);
                $section->addTextBreak(1);
                if ($submission->expert_id !== $authUser->id) {

                    if ($authors->isNotEmpty()) {
                        $namesArray = explode(', ', $names);
                        $textRun = $section->addTextRun();
                        $totalNames = count($namesArray);

                        foreach ($namesArray as $key => $name) {
                            $parts = explode(' ', $name);
                            $number = array_pop($parts);
                            $person = implode(' ', $parts);

                            $textRun->addText($person . ' ', ['name' => 'Times New Roman', 'size' => 14, 'bold' => true]);
                            $textRun->addText($number, ['superscript' => true, 'name' => 'Times New Roman', 'size' => 10, 'bold' => true]);

                            if ($key !== $totalNames - 1) {
                                $textRun->addText(", ", ['name' => 'Times New Roman', 'size' => 14]);
                            }
                        }
                        $textRun->getParagraphStyle()->setLineHeight(0.8);

                        foreach ($affiliation as $affiliationText) {
                            $textRunAffiliation = $section->addTextRun();
                            $textRunAffiliation->addText(substr($affiliationText, 0, 1), ['superscript' => true, 'name' => 'Times New Roman', 'size' => 10]);
                            $textRunAffiliation->addText(substr($affiliationText, 1), ['name' => 'Times New Roman', 'size' => 12]);
                            $textRunAffiliation->getParagraphStyle()->setLineHeight(0.8);
                        }
                    }
                }
                if ($submission->expert_id !== $authUser->id) {

                    if ($mainAuthor) {
                        $section->addTextBreak(1);
                        $section->addText('Correspondence', ['name' => 'Times New Roman', 'size' => 14, 'bold' => true]);
                        $section->addText($mainAuthor->name, ['name' => 'Times New Roman', 'size' => 12]);
                        $section->addText($mainAuthor->designation, ['name' => 'Times New Roman', 'size' => 12]);
                        $section->addText($mainAuthor->institution, ['name' => 'Times New Roman', 'size' => 12]);
                        $section->addText($mainAuthor->institution_address, ['name' => 'Times New Roman', 'size' => 12]);
                        $section->addText('Email: ' . $mainAuthor->email, ['name' => 'Times New Roman', 'size' => 12]);
                        $section->addText('Phone: ' . $mainAuthor->phone, ['name' => 'Times New Roman', 'size' => 12]);
                        $section->addTextBreak(1);
                    }
                }

                $section->addText('Received Date: ' . Carbon::parse($submission->submitted_date)->format('d M, Y'), ['name' => 'Times New Roman', 'size' => 12]);
                if (!empty($submission->expert)) {
                    $section->addText('Reviewer: ' . $submission->expert->fullName($submission, 'expert'), ['name' => 'Times New Roman', 'size' => 12]);
                }
                $section->addTextBreak(1);

                $section->addText('Abstract', ['name' => 'Times New Roman', 'size' => 14, 'bold' => true]);
                $section->addText(htmlspecialchars(strip_tags($submission->abstract_content)), ['name' => 'Times New Roman', 'size' => 12]);
                $section->addTextBreak(1);

                $keywordsRun = $section->addTextRun();
                $keywordsRun->addText('Keywords: ', ['name' => 'Times New Roman', 'size' => 12, 'bold' => true]);
                $keywordsRun->addText($submission->keywords, ['name' => 'Times New Roman', 'size' => 12]);

                // Add page break between submissions
                $section->addPageBreak();
            }

            // Save the file
            $filename = 'Bulk_Submissions_' . now()->format('Ymd_His') . '.docx';
            $filePath = public_path('downloads/' . $filename);

            if (!file_exists(public_path('downloads'))) {
                mkdir(public_path('downloads'), 0777, true);
            }

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);
        }
    }
    public function wordExport($id)
    {
        $submission = Submission::where('id', $id)->first();
        $authors = $submission->authors;
        $mainAuthor = null;
        $names = '';
        $affiliation = [];
        if ($authors->isNotEmpty()) {
            // Group authors by combination of designation, institution, and institution_address
            $mainAuthor = $authors->where('main_author', 1)->first();
            $groupedAuthors = $authors->groupBy('designation', 'institution', 'institution_address');

            // Separate duplicates and non-duplicates
            $duplicated = $groupedAuthors->filter(function ($group) {
                return $group->count() > 1;
            });

            $nonDuplicated = $groupedAuthors->filter(function ($group) {
                return $group->count() === 1;
            });

            $duplicatedData = [];
            $nonDuplicatedData = [];

            // Process duplicated
            $i = 1;
            foreach ($duplicated as $duplicateGroup) {
                foreach ($duplicateGroup as $record) {
                    $name = $record->name;
                    $designation = $record->designation;
                    $institution = $record->institution;
                    $institutionAddress = $record->institution_address;

                    // Store duplicated records with their corresponding names
                    $duplicatedData[$name][] = [
                        'designation' => $designation,
                        'institution' => $institution,
                        'institution_address' => $institutionAddress,
                        'countValue' => $i,
                    ];
                }
                $i++;
            }
            // Process non-duplicated
            foreach ($nonDuplicated as $nonDuplicateGroup) {
                foreach ($nonDuplicateGroup as $record) {
                    $name = $record->name;
                    $designation = $record->designation;
                    $institution = $record->institution;
                    $institutionAddress = $record->institution_address;

                    // Store non-duplicated records with their corresponding names
                    $nonDuplicatedData[$name] = [
                        'designation' => $designation,
                        'institution' => $institution,
                        'institution_address' => $institutionAddress,
                        'countValue' => $i,
                    ];
                }
                $i++;
            }

            $uniqueValues = [];
            foreach ($duplicatedData as $key => $value) {
                $names .= $key . ' ' . $value[0]['countValue'] . ', ';

                if (!in_array($value[0]['countValue'], $uniqueValues)) {
                    $affiliation[] = $value[0]['countValue'] . $value[0]['designation'] . ', ' . $value[0]['institution'] . ', ' . $value[0]['institution_address'];
                    $uniqueValues[] = $value[0]['countValue'];
                }
            }
            foreach ($nonDuplicatedData as $key => $value) {
                $names .= $key . ' ' . $value['countValue'] . ', ';
                $affiliation[] = $value['countValue'] . $value['designation'] . ', ' . $value['institution'] . ', ' . $value['institution_address'];
            }
            $names = rtrim($names, ', ');
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addText($submission->topic, array('name' => 'Times New Roman', 'size' => 16, 'bold' => true));
        $section->addTextBreak(1);
        if ($authors->isNotEmpty()) {

            $namesArray = explode(', ', $names);

            $textRun = $section->addTextRun();
            $totalNames = count($namesArray);

            foreach ($namesArray as $key => $name) {
                $parts = explode(' ', $name);
                $person = '';
                $number = '';

                // Extract the number (last part)
                $number = array_pop($parts);

                // Construct the person's name
                foreach ($parts as $index => $part) {
                    if ($index !== count($parts) - 1) {
                        $person .= $part . ' ';
                    } else {
                        $person .= $part;
                    }
                }

                // Add the person's name with regular formatting
                $textRun->addText($person . ' ', array('name' => 'Times New Roman', 'size' => 14, 'bold' => true));

                // Add the number in superscript
                $textRun->addText($number, array('superscript' => true, 'name' => 'Times New Roman', 'size' => 10, 'bold' => true));

                if ($key !== $totalNames - 1) {
                    $textRun->addText(",", array('name' => 'Times New Roman', 'size' => 14));
                }
                $textRun->addText(" ", array('name' => 'Times New Roman', 'size' => 14)); // Add space between names
            }
            $textRun->getParagraphStyle()->setLineHeight(0.8);
            $textRuns = [];
            foreach ($affiliation as $ind => $affiliationText) {
                $textRuns[$ind] = $section->addTextRun();
                $firstChar = substr($affiliationText, 0, 1);
                $otherChars = substr($affiliationText, 1);
                $textRuns[$ind]->addText($firstChar, array('superscript' => true, 'name' => 'Times New Roman', 'size' => 10));
                $textRuns[$ind]->addText($otherChars, array('name' => 'Times New Roman', 'size' => 12));
                $textRuns[$ind]->getParagraphStyle()->setLineHeight(0.8);
            }
            $section->addTextBreak(1);
        }
        if ($mainAuthor != null) {
            $section->addText('Correspondence', array('name' => 'Times New Roman', 'size' => 14, 'bold' => true, 'line' => 0.5));
            $section->addText($mainAuthor->name, array('name' => 'Times New Roman', 'size' => 12));
            $section->addText($mainAuthor->designation, array('name' => 'Times New Roman', 'size' => 12));
            $section->addText($mainAuthor->institution, array('name' => 'Times New Roman', 'size' => 12));
            $section->addText($mainAuthor->institution_address, array('name' => 'Times New Roman', 'size' => 12));
            $section->addText('Email: ' . $mainAuthor->email, array('name' => 'Times New Roman', 'size' => 12));
            $section->addText('Phone: ' . $mainAuthor->phone, array('name' => 'Times New Roman', 'size' => 12));
            $section->addTextBreak(1);
        }
        $section->addText('Recieved Date: ' . Carbon::parse($submission->submitted_date)->format('d M, Y'), array('name' => 'Times New Roman', 'size' => 12));
        $section->addText('Accepted Date: ' . Carbon::parse($submission->accepted_date)->format('d M, Y'), array('name' => 'Times New Roman', 'size' => 12));
        $section->addTextBreak(1);
        $section->addText('Reviewer: ' . $submission->expert->name, array('name' => 'Times New Roman', 'size' => 12));
        $section->addTextBreak(1);
        $section->addText('Abstract', array('name' => 'Times New Roman', 'size' => 14, 'bold' => true));
        $section->addText(strip_tags($submission->abstract_content), array('name' => 'Times New Roman', 'size' => 12));
        $section->addTextBreak(1);
        $textRunKeyword = $section->addTextRun();
        $textRunKeyword->addText('Keywords: ', array('name' => 'Times New Roman', 'size' => 12, 'bold' => true));
        $textRunKeyword->addText($submission->keywords, array('name' => 'Times New Roman', 'size' => 12));
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $filename = $submission->presenter->presenter->name . '-Abstract Submission.docx';
        $objWriter->save($filename);

        // Move the file to a publicly accessible directory
        $publicPath = public_path('downloads');
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0777, true);
        }

        $filePath = $publicPath . '/' . $filename;
        rename($filename, $filePath);

        $headers = [
            'Content-Type' => 'application/docx',
        ];

        $fileSize = filesize($filePath);

        $response = response()->download($filePath, $filename, $headers)->deleteFileAfterSend(true);

        return $response;
    }
}
