<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Author, ConferenceRegistration, SubmissionSetting, Submission, User, Conference};
use Illuminate\Http\Request;
use Exception;

class AuthorController extends Controller
{
    public function index($id)
    {
        $submission = Submission::where('id', $id)->first();
        $authUser = auth()->user();
        // if ($userRole[0] == 4) {
        //     if ($submission->conferenceRegistration->user == null) {
        //         return redirect()->route('submission.index')->with('delete', 'Permission Denied.');
        //     } else {
        //         if (auth()->user()->id != $submission->conferenceRegistration->user_id) {
        //             return redirect()->route('submission.index')->with('delete', 'Permission Denied.');
        //         } else {
        //             return view('backend.submission.authors', compact('submission', 'userRole'));
        //         }
        //     }
        // } else {
            return view('backend.submission.authors', compact('submission', 'authUser'));
        // }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function form(Request $request)
    {
        $submission = Submission::select('id', 'topic', 'conference_id')->where('id', $request->topicId)->first();
        $author = null;
        if ($request->has('authorId')) {
            $author = Author::where('id', $request->authorId)->first();
        }
        $authors = Author::where('submission_id', $request->topicId)->get();
        $authorLimit = SubmissionSetting::select('authors_limit')->first();
        return view('backend.submission.add-author-modal', compact('submission', 'author', 'authors', 'authorLimit'));
    }

    public function oldAuthor(Request $request)
    {
        $author = Author::select('designation', 'institution', 'institution_address')->where('id', $request->oldAuthor)->first();
        return response()->json($author);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'submission_id'=> 'required',
                'name'=> 'required',
                'email'=> 'required|email',
                'designation'=> 'required',
                'institution'=> 'required',
                'institution_address'=> 'required',
                'main_author'=> 'nullable',
            ];

            if ($request->has('main_author')) {
                $rules['phone'] = 'required';
            } else {
                $rules['phone'] ='nullable';
            }

            $validated = $request->validate($rules);

            $latestConference = Conference::latestConference();
            $authorLimit = SubmissionSetting::where('conference_id', $latestConference->id)->select('authors_limit')->first();
            $authorsCount = Author::where(['submission_id' => $request->submission_id, 'status' => 1])->get()->count();

            if (@$authorLimit->authors_limit == $authorsCount) {
                return redirect()->back()->with('delete', 'Author Limit Reached.');
            } else {
                Author::create($validated);

                return redirect()->back()->with('status', 'Author Added Successfully');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        try {
            $rules = [
                'submission_id'=> 'required',
                'name'=> 'required',
                'email'=> 'required|email',
                'designation'=> 'required',
                'institution'=> 'required',
                'institution_address'=> 'required',
                'main_author'=> 'nullable',
            ];

            if ($request->has('main_author')) {
                $rules['phone'] = 'required';
            } else {
                $rules['phone'] ='nullable';
            }

            $validated = $request->validate($rules);

            if ($request->has('main_author')) {
                $validated['main_author'] = 1;
            } else {
                $validated['main_author'] = 0;
            }

            $author->update($validated);

            return redirect()->back()->with('status', 'Author Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->update(['status' => 0]);

        return redirect()->back()->with('delete', 'Author Deleted Successfully');
    }
}
