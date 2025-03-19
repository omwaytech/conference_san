<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ScientificSessionCategory;
use Illuminate\Http\Request;
use Exception, Str;

class ScientificSessionCategoryController extends Controller
{
    public function index()
    {
        $categories = ScientificSessionCategory::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('backend.scientific-session-category.show', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.scientific-session-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_name'=> 'required'
            ]);

            $validated['slug'] = Str::slug($validated['category_name']);

            ScientificSessionCategory::create($validated);

            return redirect()->route('scientific-session-category.index')->with('status', 'Scientific Session Category Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ScientificSessionCategory $scientificSessionCategory)
    {
        return view('backend.scientific-session-category.create', compact('scientificSessionCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ScientificSessionCategory $scientificSessionCategory)
    {
        try {
            $validated = $request->validate([
                'category_name'=> 'required'
            ]);

            $validated['slug'] = Str::slug($validated['category_name']);

            $scientificSessionCategory->update($validated);

            return redirect()->route('scientific-session-category.index')->with('status', 'Scientific Session Category Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScientificSessionCategory $scientificSessionCategory)
    {
        if ($scientificSessionCategory->schedules->isNotEmpty()) {
            $message = 'Cannot delete this category.';
        } else {
            $scientificSessionCategory->update(['status' => 0]);
            $message = 'Scientific Session Category Deleted Successfully.';
        }
        return redirect()->back()->with('delete', $message);
    }
}
