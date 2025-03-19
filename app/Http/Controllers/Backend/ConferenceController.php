<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\SubmissionSetting;
use Illuminate\Http\Request;
use Exception, Storage, Image, Str;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::where('status', 1)->latest()->get();
        return view('backend.conferences.show', compact('conferences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.conferences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'conference_theme' => 'required',
                'conference_logo' => 'nullable|mimes:png,jpg',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'early_bird_registration_deadline' => 'required|date',
                'regular_registration_deadline' => 'required|date|after_or_equal:early_bird_registration_deadline',
                'venue_name' => 'required',
                'venue_address' => 'required',
                'venue_contact' => 'required',
                'location_map' => 'required',
                'start_time' => 'required',
                'organizer_name' => 'required',
                'organizer_logo' => 'nullable|mimes:jpg,png',
                'contact_person' => 'required',
                'organizer_email' => 'required|email',
                'organizer_phone' => 'required',
                'description' => 'required'
            ]);

            if (!empty($validated['conference_logo'])) {
                $fileName = time() . '.' . $validated['conference_logo']->getClientOriginalExtension();
                $conferenceLogo = Image::make($validated['conference_logo']);

                $conferenceLogo->resize(1620, 820, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg');

                Storage::put("public/conference/{$fileName}", $conferenceLogo);
                $validated['conference_logo'] = $fileName;
            }

            if (!empty($validated['organizer_logo'])) {
                $logoName = time() . '.' . $validated['organizer_logo']->getClientOriginalExtension();
                $organizerLogo = Image::make($validated['organizer_logo']);

                $organizerLogo->resize(1620, 820, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg');

                Storage::put("public/conference/organizer/{$logoName}", $organizerLogo);
                $validated['organizer_logo'] = $logoName;
            }
            $validated['slug'] = Str::slug($validated['conference_theme']) . '-' . time();

            Conference::create($validated);

            return redirect()->route('conference.index')->with('status', 'Conference Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show(Request $request)
    {
        $conference = Conference::whereId($request->id)->first();
        return view('backend.conferences.view-data-modal', compact('conference'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conference $conference)
    {
        return view('backend.conferences.create', compact('conference'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Conference $conference)
    {
        try {
            $validated = $request->validate([
                'conference_theme' => 'required',
                'conference_logo' => 'nullable|mimes:png,jpg',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'early_bird_registration_deadline' => 'required|date',
                'regular_registration_deadline' => 'required|date|after_or_equal:early_bird_registration_deadline',
                'venue_name' => 'required',
                'venue_address' => 'required',
                'venue_contact' => 'required',
                'location_map' => 'required',
                'start_time' => 'required',
                'organizer_name' => 'required',
                'organizer_logo' => 'nullable|mimes:jpg,png',
                'contact_person' => 'required',
                'organizer_email' => 'required|email',
                'organizer_phone' => 'required',
                'description' => 'required'
            ]);

            if (!empty($validated['conference_logo'])) {
                Storage::delete('public/conference/'.$conference->conference_logo);
                $fileName = time() . '.' . $validated['conference_logo']->getClientOriginalExtension();
                $conferenceLogo = Image::make($validated['conference_logo']);

                $conferenceLogo->resize(1620, 820, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg');

                Storage::put("public/conference/{$fileName}", $conferenceLogo);
                $validated['conference_logo'] = $fileName;
            }

            if (!empty($validated['organizer_logo'])) {
                Storage::delete('public/conference/organizer/'.$conference->organizer_logo);
                $logoName = time() . '.' . $validated['organizer_logo']->getClientOriginalExtension();
                $organizerLogo = Image::make($validated['organizer_logo']);

                $organizerLogo->resize(1620, 820, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg');

                Storage::put("public/conference/organizer/{$logoName}", $organizerLogo);
                $validated['organizer_logo'] = $logoName;
            }

            $conference->update($validated);

            return redirect()->route('conference.index')->with('status', 'Conference Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function submissionSetting(Request $request)
    {
        $conference = Conference::latestConference();
        return view('backend.conferences.submission-setting', compact('conference'));
    }

    public function submissionSettingSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'conference_id' => 'required',
                'id' => 'nullable',
                'deadline' => 'nullable|date',
                'abstract_word_limit' => 'nullable|numeric',
                'keyword_word_limit' => 'nullable|numeric',
                'authors_limit' => 'nullable|numeric',
                'abstract_guidelines' => 'nullable',
                'poster_guidelines' => 'nullable',
            ]);

            $message = empty($validated['id']) ? 'Successfully inserted submission setting.' : 'Successfully updated submission setting';

            if (empty($validated['id'])) {
                $submitData = SubmissionSetting::create($validated);
            } else {
                $submissionSetting = SubmissionSetting::whereId($validated['id'])->first();
                $submitData = $submissionSetting->update($validated);
            }

            if (!$submitData) {
                throw new Exception("Error Processing Request", 1);
            }
            return redirect()->back()->with('status', $message);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function openConferencePortal($slug)
    {
        $conference = Conference::whereSlug($slug)->first();
        session(['conferenceDetail' => $conference]);
        $user = auth()->user();
        return view('backend.dashboard.show', compact('user'));
    }
}
