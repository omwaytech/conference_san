<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Schedule, Hall};
use App\Models\Conference;
use Illuminate\Http\Request;
use Exception;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('backend.schedule.show', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $halls = Hall::where('status', 1)->get();
        return view('backend.schedule.create', compact('halls'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'agenda'=> 'required',
                'hall_id'=> 'nullable',
                'date'=> 'required',
                'time'=> 'required',
                'duration'=> 'required'
            ]);

            if (!empty($request->hall_id)) {
                $validated['hall_id'] = json_encode($request->hall_id);
            } else {
                $validated['hall_id'] = null;
            }

            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;
            $validated['slug'] = 'schedule-' . time();
            Schedule::create($validated);

            return redirect()->route('schedule.index')->with('status', 'Schedule Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $halls = Hall::where('status', 1)->get();
        return view('backend.schedule.create', compact('schedule', 'halls'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        try {
            $validated = $request->validate([
                'agenda'=> 'required',
                'hall_id'=> 'nullable',
                'date'=> 'required',
                'time'=> 'required',
                'duration'=> 'required'
            ]);

            if (!empty($request->hall_id)) {
                $validated['hall_id'] = json_encode($request->hall_id);
            } else {
                $validated['hall_id'] = null;
            }
            $validated['slug'] = 'schedule-' . time();
            $schedule->update($validated);

            return redirect()->route('schedule.index')->with('status', 'Schedule Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->update(['status' => 0]);

        return redirect()->route('schedule.index')->with('delete', 'Schedule Deleted Successfully');
    }
}
