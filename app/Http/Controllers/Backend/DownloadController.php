<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Conference, Download};
use Illuminate\Http\Request;
use Exception, Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $latestConference = Conference::latestConference();
        $downloads = Download::where(['conference_id' => $latestConference->id, 'status' => 1])->latest()->get();
        return view('backend.downloads.show', compact('downloads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        return view('backend.downloads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'title' => 'required',
                'file' => 'required|mimes:jpg,pdf,doc,docx|max:8192'
            ];

            $validated = $request->validate($rules);

            $fileName = time() . '.' . $validated['file']->getClientOriginalExtension();
            Storage::putFileAs("public/downloads", $validated['file'], $fileName);
            $validated['file'] = $fileName;

            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;

            Download::create($validated);

            return redirect()->route('download.index')->with('status', 'File Added Successfully');

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Download $download)
    {
        return view('backend.downloads.create', compact('download'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Download $download)
    {
        try {
            $rules = [
                'title' => 'required',
                'file' => 'nullable|mimes:jpg,pdf,doc,docx|max:5120'
            ];

            $validated = $request->validate($rules);

            if (!empty($validated['file'])) {
                Storage::delete('public/downloads/'.$download->file);
                $fileName = time() . '.' . $validated['file']->getClientOriginalExtension();
                Storage::putFileAs("public/downloads", $validated['file'], $fileName);
                $validated['file'] = $fileName;
            }

            $download->update($validated);

            return redirect()->route('download.index')->with('status', 'File Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function changeFeatured(Download $download)
    {
        if ($download->is_featured == 1) {
            $isFeatured = 0;
        } else {
            $isFeatured = 1;
        }

        $download->update(['is_featured' => $isFeatured]);

        return redirect()->back()->with('status', 'File featured status changed successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Download $download)
    {
        $download->update(['status' => 0]);

        return redirect()->route('download.index')->with('delete', 'File Deleted Successfully');
    }
}
