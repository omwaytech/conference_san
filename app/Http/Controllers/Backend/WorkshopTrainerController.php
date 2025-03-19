<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Workshop, WorkshopTrainer};
use Illuminate\Http\Request;
use Exception, Storage;

class WorkshopTrainerController extends Controller
{
    public function index($slug)
    {
        $workshop = Workshop::where("slug", $slug)->first();
        $trainers = WorkshopTrainer::where(['workshop_id' => $workshop->id, 'status' => 1])->latest()->get();
        $authUser = auth()->user();
        return view('backend.workshops.trainers.show', compact('trainers', 'workshop', 'authUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($slug)
    {
        $workshop = Workshop::where("slug", $slug)->first();
        return view('backend.workshops.trainers.create', compact('workshop'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'workshop_id' => 'required',
                'name' => 'required',
                'affiliation' => 'required',
                'image' => 'required|mimes:jpg,png|max:500',
                'cv' => 'nullable|mimes:pdf|max:250'
            ];

            $validated = $request->validate($rules);

            $workshop = Workshop::where('id', $validated['workshop_id'])->first();

            $imgName = time() . rand(1, 999) . '.' . $validated['image']->getClientOriginalExtension();
            Storage::putFileAs("public/workshop/trainers/image", $validated['image'], $imgName);
            $validated['image'] = $imgName;

            if (!empty($validated['cv'])) {
                $fileName = time() . '.' . $validated['cv']->getClientOriginalExtension();
                Storage::putFileAs("public/workshop/trainers/cv", $validated['cv'], $fileName);
                $validated['cv'] = $fileName;
            }

            WorkshopTrainer::create($validated);

            return redirect()->route('workshop-trainer.index', $workshop->slug)->with('status', 'Trainer Added Successfully');

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug, WorkshopTrainer $trainer)
    {
        $workshop = Workshop::where("slug", $slug)->first();
        return view('backend.workshops.trainers.create', compact('workshop', 'trainer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkshopTrainer $trainer)
    {
        try {
            $rules = [
                'workshop_id' => 'required',
                'name' => 'required',
                'affiliation' => 'required',
                'image' => 'nullable|mimes:jpg,png|max:500',
                'cv' => 'nullable|mimes:pdf|max:250'
            ];

            $validated = $request->validate($rules);

            $workshop = Workshop::where('id', $validated['workshop_id'])->first();

            if (!empty($validated['image'])) {
                Storage::delete("public/workshop/trainers/image/{$trainer->image}");
                $imgName = time() . rand(1, 999) . '.' . $validated['image']->getClientOriginalExtension();
                Storage::putFileAs("public/workshop/trainers/image", $validated['image'], $imgName);
                $validated['image'] = $imgName;
            }

            if (!empty($validated['cv'])) {
                Storage::delete("public/workshop/trainers/cv/{$trainer->cv}");
                $fileName = time() . '.' . $validated['cv']->getClientOriginalExtension();
                Storage::putFileAs("public/workshop/trainers/cv", $validated['cv'], $fileName);
                $validated['cv'] = $fileName;
            }

            $trainer->update($validated);

            return redirect()->route('workshop-trainer.index', $workshop->slug)->with('status', 'Trainer Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkshopTrainer $trainer)
    {
        $trainer->update(['status' => 0]);
        return redirect()->back()->with('delete', 'Trainer Deleted Successfully');
    }
}
