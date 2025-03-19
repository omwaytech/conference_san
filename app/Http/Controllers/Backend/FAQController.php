<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Exception;

class FAQController extends Controller
{
    public function index()
    {
        $conference = session()->get('conferenceDetail');
        $faqs = FAQ::where(['conference_id' => $conference->id, 'status' => 1])->orderBy('id', 'ASC')->get();
        return view('backend.faq.show', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'question'=> 'required',
                'answer'=> 'required'
            ]);

            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;
            FAQ::create($validated);

            return redirect()->route('faq.index')->with('status', 'FAQ Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQ $faq)
    {
        return view('backend.faq.create', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FAQ $faq)
    {
        try {
            $validated = $request->validate([
                'question'=> 'required',
                'answer'=> 'required'
            ]);

            $faq->update($validated);

            return redirect()->route('faq.index')->with('status', 'FAQ Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FAQ $faq)
    {
        $faq->update(['status' => 0]);
        return redirect()->route('faq.index')->with('delete', 'FAQ Deleted Successfully.');
    }
}
