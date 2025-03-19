<?php

namespace App\Http\Controllers\Backend;

use App\Exports\CommittePaymentStatusExport;
use App\Http\Controllers\Controller;
use App\Models\{Committee, Conference};
use Illuminate\Http\Request;
use Exception, Str, Excel;

class CommitteeController extends Controller
{
    public function index()
    {
        $committees = Committee::where(['status' => 1])->latest()->get();
        $latestConference = Conference::latestConference();
        return view('backend.committee.show', compact('committees', 'latestConference'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.committee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'committee_name' => 'required|string|unique:committees,committee_name',
                'focal_person' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required',
                'description' => 'nullable'
            ]);

            $validated['slug'] = Str::slug($validated['committee_name']);

            Committee::create($validated);

            return redirect()->route('committee.index')->with('status', 'Committee Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Committee $committee)
    {
        return view('backend.committee.create', compact('committee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Committee $committee)
    {
        try {
            $validated = $request->validate([
                'committee_name' => 'required|string|unique:committees,committee_name,' . $committee->id,
                'focal_person' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required',
                'description' => 'nullable'
            ]);
            $validated['slug'] = Str::slug($validated['committee_name']);

            $committee->update($validated);

            return redirect()->route('committee.index')->with('status', 'Committee Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function paymentStatus()
    {
        
        return Excel::download(new CommittePaymentStatusExport(), 'PaymentStatus.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Committee $committee)
    {
        $committee->update(['status' => 0]);

        return redirect()->route('committee.index')->with('delete', 'Committee Deleted Successfully');
    }
}
