<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use Illuminate\Http\Request;
use Exception;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('backend.hall.show', compact('halls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.hall.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'hall_name'=> 'required'
            ]);

            Hall::create($validated);

            return redirect()->route('hall.index')->with('status', 'Hall Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hall $hall)
    {
        return view('backend.hall.create', compact('hall'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hall $hall)
    {
        try {
            $validated = $request->validate([
                'hall_name'=> 'required'
            ]);

            $hall->update($validated);

            return redirect()->route('hall.index')->with('status', 'Hall Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hall $hall)
    {
        if ($hall->schedules->isNotEmpty()) {
            $message = 'Cannot delete this hall.';
        } else {
            $hall->update(['status' => 0]);
            $message = 'Hall Deleted Successfully.';
        }
        return redirect()->route('hall.index')->with('delete', $message);
    }
}
