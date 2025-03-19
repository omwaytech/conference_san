<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Conference, Content};
use Illuminate\Http\Request;
use Exception, Storage, Str;

class ContentController extends Controller
{
    public function index()
    {
        $latestConference = Conference::latestConference();
        $contents = Content::where(['conference_id' => $latestConference->id, 'status' => 1])->latest()->get();
        return view('backend.contents.show', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.contents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'title' => 'required',
                'file' => 'required_without:description|mimes:pdf|max:5120',
                'description' => 'required_without:file'
            ];

            $validated = $request->validate($rules);

            if (!empty($validated['file'])) {
                $fileName = time() . '.' . $validated['file']->getClientOriginalExtension();
                Storage::putFileAs("public/contents", $validated['file'], $fileName);
                $validated['file'] = $fileName;
            }

            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();

            Content::create($validated);

            return redirect()->route('content.index')->with('status', 'Content Added Successfully');

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content)
    {
        return view('backend.contents.create', compact('content'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Content $content)
    {
        try {
            $rules = [
                'title' => 'required',
                'file' => 'nullable|mimes:pdf|max:5120',
                'description' => 'nullable'
            ];

            $validated = $request->validate($rules);

            if (!empty($validated['file'])) {
                Storage::delete('public/contents/'.$content->file);
                $fileName = time() . '.' . $validated['file']->getClientOriginalExtension();
                Storage::putFileAs("public/contents", $validated['file'], $fileName);
                $validated['file'] = $fileName;
            }
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();

            $content->update($validated);

            return redirect()->route('content.index')->with('status', 'Content Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        $content->update(['status' => 0]);

        return redirect()->route('content.index')->with('delete', 'Content Deleted Successfully');
    }
}
