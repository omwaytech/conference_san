<?php

namespace App\Http\Controllers\Backend;

use App\Exports\ScientificSessionExport;
use App\Http\Controllers\Controller;
use App\Models\{ScientificSession, Hall, User, Conference, ScientificSessionCategory};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception, Excel;

class ScientificSessionController extends Controller
{
    public function index()
    {
        $sessions = ScientificSession::where('status', 1)->orderBy('day', 'ASC')->orderByRaw("STR_TO_DATE(time, '%h:%i%p') ASC")->get();

        $latestConference = Conference::latestConference();
        $startDate = Carbon::parse($latestConference->start_date);
        $endDate = Carbon::parse($latestConference->end_date); 

        $dates = [];

        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
        return view('backend.scientific-session.show', compact('sessions', 'dates'));
    }

    public function create()
    {
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
        return view('backend.scientific-session.create', compact('halls', 'users', 'dates', 'categories'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'category_id'=> 'required',
                'topic' => 'required',
                'type'=> 'required',
                'hall_id'=> 'nullable',
                'screen' => 'nullable',
                'chairperson'=> 'nullable',
                'co_chairperson'=> 'nullable',
                'participants'=> 'nullable',
                'day'=> 'required',
                'time'=> 'required',
                'duration'=> 'required',
            ];
            // if ($request->type == 5) {
            //     $rules['topic'] = 'required';
            // }
            $validated = $request->validate($rules);
            $checkAvailabilityOfTime = ScientificSession::where(['day' => $request->day, 'time' => $request->time, 'hall_id' => $request->hall_id, 'status' => 1])->first();

            if (empty($checkAvailabilityOfTime)) {
                // if (!empty($request->hall_id)) {
                //     $validated['hall_id'] = json_encode($request->hall_id);
                // } else {
                //     $validated['hall_id'] = null;
                // }
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
                if (!empty($request->participants)) {
                    $validated['participants'] = json_encode($request->participants);
                } else {
                    $validated['participants'] = null;
                }

                $latestConference = Conference::latestConference();
                $validated['conference_id'] = $latestConference->id;
                ScientificSession::create($validated);

                return redirect()->route('scientific-session.index')->with('status', 'Scientifc Session Added Successfully');
            } else {
                return redirect()->back()->withInput()->with('delete', 'Time Slot Already Consumed For This Hall.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show(Request $request)
    {
        $scientific_session = ScientificSession::whereId($request->id)->first();

        $latestConference = Conference::latestConference();
        $startDate = Carbon::parse($latestConference->start_date);
        $endDate = Carbon::parse($latestConference->end_date);

        $dates = [];

        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
        return view('backend.scientific-session.view-data-modal', compact('scientific_session', 'dates'));
    }

    public function edit(ScientificSession $scientific_session)
    {
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
        return view('backend.scientific-session.create', compact('halls', 'users', 'dates', 'categories', 'scientific_session'));
    }

    public function update(Request $request, ScientificSession $scientific_session)
    {
        try {
            $rules = [
                'category_id'=> 'required',
                'topic' => 'required',
                'type'=> 'required',
                'hall_id'=> 'nullable',
                'screen' => 'nullable',
                'chairperson'=> 'nullable',
                'co_chairperson'=> 'nullable',
                'participants'=> 'nullable',
                'day'=> 'required',
                'time'=> 'required',
                'duration'=> 'required'
            ];
            // if ($request->type == 5) {
            //     $rules['topic'] = 'required';
            // }
            $validated = $request->validate($rules);

            $checkAvailabilityOfTime = ScientificSession::where(['day' => $request->day, 'time' => $request->time, 'hall_id' => $request->hall_id, 'status' => 1])->whereNot('id', $scientific_session->id)->first();

            if (empty($checkAvailabilityOfTime)) {
                // if ($request->type != 5) {
                //     $validated['topic'] = null;
                // }

                // if (!empty($request->hall_id)) {
                //     $validated['hall_id'] = json_encode($request->hall_id);
                // } else {
                //     $validated['hall_id'] = null;
                // }
                if (!empty($request->chairperson)) {
                    $validated['chairperson'] = $request->chairperson;
                } else {
                    $validated['chairperson'] = null;
                }
                if (!empty($request->co_chairperson)) {
                    $validated['co_chairperson'] = $request->co_chairperson;
                } else {
                    $validated['co_chairperson'] = null;
                }
                if (!empty($request->participants)) {
                    $validated['participants'] = $request->participants;
                } else {
                    $validated['participants'] = null;
                }

                $scientific_session->update($validated);

                return redirect()->route('scientific-session.index')->with('status', 'Scientifc Session Updated Successfully');
            } else {
                return redirect()->back()->withInput()->with('delete', 'Time Slot Already Consumed For This Hall.');
            }

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy(ScientificSession $scientific_session)
    {
        $scientific_session->update(['status' => 0]);

        return redirect()->back()->with('delete', 'Scientifc Session Deleted Successfully');
    }

    public function exportExcel()
    {
        return Excel::download(new ScientificSessionExport(), 'ScientificSession.xlsx');
    }
}
