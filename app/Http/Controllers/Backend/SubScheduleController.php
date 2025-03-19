<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Schedule, Hall, SubSchedule};
use Illuminate\Http\Request;
use Exception;

class SubScheduleController extends Controller
{
    public function index($slug)
    {
        $schedule = Schedule::whereSlug($slug)->first();
        return view('backend.schedule.sub-schedule.show', compact('schedule'));
    }

    public function create($slug)
    {
        $schedule = Schedule::whereSlug($slug)->first();
        $halls = [];
        if (!empty($schedule->hall_id)) {
            $halls = Hall::whereIn('id', json_decode($schedule->hall_id))->where('status', 1)->get();
        }
        return view('backend.schedule.sub-schedule.create', compact('schedule', 'halls'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'schedule_id'=> 'required',
                'agenda'=> 'required',
                'hall_id'=> 'nullable',
                'time'=> 'required',
                'duration'=> 'required'
            ]);

            if (!empty($request->hall_id)) {
                $validated['hall_id'] = json_encode($request->hall_id);
            } else {
                $validated['hall_id'] = null;
            }

            $schedule = Schedule::whereId($validated['schedule_id'])->first();
            SubSchedule::create($validated);

            return redirect()->route('sub-schedule.index', $schedule->slug)->with('status', 'Sub-Schedule Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit(SubSchedule $subSchedule)
    {
        $schedule = Schedule::whereId($subSchedule->schedule_id)->first();
        $halls = [];
        if (!empty($schedule->hall_id)) {
            $halls = Hall::whereIn('id', json_decode($schedule->hall_id))->where('status', 1)->get();
        }
        return view('backend.schedule.sub-schedule.create', compact('subSchedule', 'schedule', 'halls'));
    }

    public function update(Request $request, SubSchedule $subSchedule)
    {
        try {
            $validated = $request->validate([
                'schedule_id'=> 'required',
                'agenda'=> 'required',
                'hall_id'=> 'nullable',
                'time'=> 'required',
                'duration'=> 'required'
            ]);

            if (!empty($request->hall_id)) {
                $validated['hall_id'] = json_encode($request->hall_id);
            } else {
                $validated['hall_id'] = null;
            }

            $schedule = Schedule::whereId($validated['schedule_id'])->first();
            $subSchedule->update($validated);

            return redirect()->route('sub-schedule.index', $schedule->slug)->with('status', 'Sub-Schedule Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy(SubSchedule $subSchedule)
    {
        $subSchedule->update(['status' => 0]);

        return redirect()->back()->with('delete', 'Sub-Schedule Deleted Successfully');
    }
}
