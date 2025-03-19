<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Notice, Conference};
use Illuminate\Http\Request;
use Exception, Str, Storage;

class NoticeController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();
        $conference = session()->get('conferenceDetail');

        $notices = Notice::where(['conference_id' => $conference->id, 'status' => 1])->latest()->get();
        return view('backend.notices.show', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.notices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required',
                'date' => 'required|date',
                'image' => 'required|mimes:jpg,png|max:500',
                'description' => 'required',
            ]);

            $imageName = time() . rand(0, 99) . '.' . $validated['image']->getClientOriginalExtension();
            Storage::putFileAs("public/notice", $validated['image'], $imageName);
            $validated['image'] = $imageName;

            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();

            Notice::create($validated);

            return redirect()->route('notice.index')->with('status', 'Notice Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show(Request $request)
    {
        $notice = Notice::whereId($request->id)->first();
        return view('backend.notices.view-data', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        return view('backend.notices.create', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        try {
            $validated = $request->validate([
                'title' => 'required',
                'date' => 'required|date',
                'image' => 'nullable|mimes:jpg,png|max:500',
                'description' => 'required',
            ]);

            if (!empty($validated['image'])) {
                Storage::delete("public/notice/".$notice->image);
                $imageName = time() . rand(0, 99) . '.' . $validated['image']->getClientOriginalExtension();
                Storage::putFileAs("public/notice", $validated['image'], $imageName);
                $validated['image'] = $imageName;
            }

            $notice->update($validated);

            return redirect()->route('notice.index')->with('status', 'Notice Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        $notice->update(['status' => 0]);

        return redirect()->back()->with('delete', 'Notice Deleted Successfully');
    }

    public function changeFeatured(Notice $notice)
    {
        if ($notice->is_featured == 1) {
            $isFeatured = 0;
        } else {
            $isFeatured = 1;
        }

        $notice->update(['is_featured' => $isFeatured]);

        return redirect()->back()->with('status', 'Notice featured status changed successfully.');
    }
}
