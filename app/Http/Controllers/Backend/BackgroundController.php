<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Conference, Background};
use Illuminate\Http\Request;
use Exception, Storage;

class BackgroundController extends Controller
{
    public function index()
    {
        $latestConference = Conference::latestConference();
        $backgrounds = Background::where(['conference_id' => $latestConference->id, 'status' => 1])->latest()->get();
        return view('backend.certificates.backgrounds.show', compact('backgrounds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.certificates.backgrounds.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'background_theme' => 'required|mimes:jpg,png'
            ];

            $validated = $request->validate($rules);

            $fileName = time() . '.' . $validated['background_theme']->getClientOriginalExtension();
            Storage::putFileAs("public/certificates/background-theme", $validated['background_theme'], $fileName);
            $validated['background_theme'] = $fileName;

            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;

            Background::create($validated);

            return redirect()->route('background.index')->with('status', 'Certificate Background Added Successfully');

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Background $background)
    {
        return view('backend.certificates.backgrounds.create', compact('background'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Background $background)
    {
        try {
            $rules = [
                'background_theme' => 'nullable|mimes:jpg,png',
            ];

            $validated = $request->validate($rules);

            if (!empty($validated['background_theme'])) {
                Storage::delete('public/certificates/background-theme/'.$background->background_theme);
                $fileName = time() . '.' . $validated['background_theme']->getClientOriginalExtension();
                Storage::putFileAs("public/certificates/background-theme", $validated['background_theme'], $fileName);
                $validated['background_theme'] = $fileName;
            }

            $background->update($validated);

            return redirect()->route('background.index')->with('status', 'Certificate Background Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Background $background)
    {
        $background->update(['status' => 0]);

        return redirect()->route('background.index')->with('delete', 'Certificate Background Deleted Successfully');
    }
}
