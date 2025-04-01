<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Sponsor, SponsorCategory, SponsorInvitation, Conference, SponsorAttendance, SponsorMeal};
use Illuminate\Http\Request;
use Exception, Storage, Image, Str;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('backend.sponsor.show', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = SponsorCategory::where('status', 1)->get();
        return view('backend.sponsor.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'sponsor_category_id' => 'required',
                'name' => 'required',
                'amount' => 'required',
                'logo' => 'nullable|mimes:png,jpg',
                'email' => 'nullable|email',
                'address' => 'nullable',
                'contact_person' => 'nullable',
                'phone' => 'required',
                'description' => 'nullable',
            ]);

            if (!empty($validated['logo'])) {
                $fileName = time() . '.' . $validated['logo']->getClientOriginalExtension();
                $image = Image::make($validated['logo']);

                $image->resize(1680, 820, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg');

                Storage::put("public/sponsors/{$fileName}", $image);
                $validated['logo'] = $fileName;
            }
            $validated['token'] = Str::random(60);
            // if ($validated['sponsor_category_id'] == 1) {
            //     $validated['total_attendee'] = 2;
            //     $validated['dinner_remaining'] = 2;
            //     $validated['dinner_remaining_2'] = 2;
            //     $validated['dinner_remaining_3'] = 2;
            //     $validated['dinner_remaining_4'] = 2;
            // } elseif ($validated['sponsor_category_id'] == 2) {
            //     $validated['total_attendee'] = 1;
            //     $validated['dinner_remaining'] = 1;
            //     $validated['dinner_remaining_2'] = 1;
            //     $validated['dinner_remaining_3'] = 1;
            //     $validated['dinner_remaining_4'] = 1;
            // }

            Sponsor::create($validated);

            return redirect()->route('sponsor.index')->with('status', 'Sponsor Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
        $categories = SponsorCategory::where('status', 1)->get();
        return view('backend.sponsor.create', compact('sponsor', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        try {
            $validated = $request->validate([
                'sponsor_category_id' => 'required',
                'name' => 'required',
                'amount' => 'required',
                'logo' => 'nullable|mimes:png,jpg',
                'email' => 'nullable|email',
                'address' => 'nullable',
                'contact_person' => 'nullable',
                'phone' => 'required',
                'description' => 'nullable',
            ]);

            if (!empty($validated['logo'])) {
                Storage::delete("public/sponsors/{$sponsor->logo}");
                $fileName = time() . '.' . $validated['logo']->getClientOriginalExtension();
                $image = Image::make($validated['logo']);

                $image->resize(1680, 820, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg');

                Storage::put("public/sponsors/{$fileName}", $image);
                $validated['logo'] = $fileName;
            }

            $sponsor->update($validated);

            return redirect()->route('sponsor.index')->with('status', 'Sponsor Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        $sponsor->update(['status' => 0]);

        return redirect()->route('sponsor.index')->with('delete', 'Sponsor Deleted Successfully');
    }

    public function changeStatus(Sponsor $sponsor)
    {
        if ($sponsor->visible_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $sponsor->update(['visible_status' => $status]);

        return redirect()->back()->with('status', 'Sponsor publish status changed successfully.');
    }

    public function inviteForConferenceForm(Request $request)
    {
        $sponsor = Sponsor::select('id', 'name')->whereId($request->id)->first();
        return view('backend.sponsor.invite-sponsor', compact('sponsor'));
    }

    public function inviteForConference(Request $request)
    {
        try {
            $validated = $request->validate([
                'no_of_people' => 'required|integer'
            ]);
            $type = 'success';
            $message = 'Successfully invited for conference.';

            $validated['sponsor_id'] = $request->id;
            $validated['token'] = Str::random(60);

            SponsorInvitation::create($validated);

            return response(['type' => $type, 'message' => $message]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function emptyRegistrationId()
    {
        $latestConference = Conference::latestConference();
        $registrants = Sponsor::where('status', 1)->get();
        foreach ($registrants as $registrant) {
            $registrant->update([
                'registration_id' => null
            ]);
        }
    }

    public function updatRegistrationId()
    {
        $registrants = Sponsor::where('status', 1)
            ->get()
            ->sortBy(fn($registrant) => strtolower(trim($registrant->name)));
        $validated = [];
        $prefixCounters = [];
        foreach ($registrants as $registrant) {
            $prefix = 'SPO_';


            // Initialize the counter if not set
            if (!isset($prefixCounters[$prefix])) {
                $prefixCounters[$prefix] = 1;
            }

            // Assign the next registration ID
            $validated['registration_id'] = $prefix . str_pad($prefixCounters[$prefix], 3, '0', STR_PAD_LEFT);
            $prefixCounters[$prefix]++;

            // Update the registrant record
            $registrant->update($validated);
        }
    }

    public function generatePass()
    {
        $sponsors = Sponsor::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('backend.sponsor.pass', compact('sponsors'));
    }

    public function sponsorProfile($token)
    {
        $sponsor = Sponsor::where('token', $token)->first();
        $conference = Conference::latestConference();
        return view('backend.sponsor.lunch-profile', compact('sponsor', 'conference'));
    }

    public function takeAttendance(Request $request)
    {
        try {
            $data['sponsor_id'] = $request->id;
            SponsorAttendance::create($data);
            return redirect()->back()->with('status', 'Attendance done successfully.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function takeMeal(Request $request)
    {
        try {
            $checkMealDataExist = SponsorMeal::where('sponsor_id', $request->id)->whereDate('created_at', date('Y-m-d'))->first();
            if (empty($checkMealDataExist)) {
                $data['sponsor_id'] = $request->id;
                if (date('H:i') < '16:00') {
                    $data['lunch_taken'] = 1;
                } else {
                    $data['dinner_taken'] = 1;
                }

                SponsorMeal::create($data);
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

    public function takeDinner($id, $day, $type)
    {
        $sponsor = Sponsor::whereId($id)->first();
        if ($day == 'day1') {
            if ($type == 'lunch') {
                $subtractDinner = $sponsor->dinner_remaining - 1;
                $sponsor->update(['dinner_remaining' => $subtractDinner]);
            } else {
                $subtractDinner3 = $sponsor->dinner_remaining_3 - 1;
                $sponsor->update(['dinner_remaining_3' => $subtractDinner3]);
            }
        } elseif ($day == 'day2') {
            if ($type == 'lunch') {
                $subtractDinner2 = $sponsor->dinner_remaining_2 - 1;
                $sponsor->update(['dinner_remaining_2' => $subtractDinner2]);
            } else {
                $subtractDinner4 = $sponsor->dinner_remaining_4 - 1;
                $sponsor->update(['dinner_remaining_4' => $subtractDinner4]);
            }
        }
        return redirect()->back()->with('status', 'Dinner Taken Successfully.');
    }

    public function addParticipant(Request $request)
    {
        $sponsor = Sponsor::whereId($request->id)->first();
        return view('backend.sponsor.add-participant', compact('sponsor'));
    }

    public function addParticipantSubmit(Request $request)
    {
        try {
            $validateRequest = $request->validate([
                'additional_value' => 'required|numeric',
            ]);

            $sponsor = Sponsor::whereId($request->id)->first();

            $validated['total_attendee'] = $sponsor->total_attendee + $validateRequest['additional_value'];
            // $validated['dinner_remaining'] = $sponsor->dinner_remaining + $validateRequest['additional_value'];
            // $validated['dinner_remaining_2'] = $sponsor->dinner_remaining_2 + $validateRequest['additional_value'];
            // $validated['dinner_remaining_3'] = $sponsor->dinner_remaining_3 + $validateRequest['additional_value'];
            // $validated['dinner_remaining_4'] = $sponsor->dinner_remaining_4 + $validateRequest['additional_value'];

            $sponsor->update($validated);

            $type = 'success';
            $message = "Total attendee edited successfully.";
        } catch (Exception $e) {
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }
}
