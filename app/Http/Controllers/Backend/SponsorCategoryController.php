<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{SponsorCategory, Conference};
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Exception, Str;

class SponsorCategoryController extends Controller
{
    public function index()
    {
        $latestConference = Conference::latestConference();
        $categories = SponsorCategory::where(['conference_id' => $latestConference->id, 'status' => 1])->get();
        return view('backend.sponsor-category.show', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.sponsor-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_name' => 'required|unique:sponsor_categories,category_name'
            ]);
            $validated['slug'] = Str::slug($validated['category_name']);
            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;

            SponsorCategory::create($validated);

            return redirect()->route('sponsor-category.index')->with('status', 'Sponsor Category Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SponsorCategory $sponsor_category)
    {
        return view('backend.sponsor-category.create', compact('sponsor_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SponsorCategory $sponsor_category)
    {
        try {
            $validated = $request->validate([
                'category_name' => 'required|unique:sponsor_categories,category_name,'.$sponsor_category->id
            ]);
            $validated['slug'] = Str::slug($validated['category_name']);

            $sponsor_category->update($validated);

            return redirect()->route('sponsor-category.index')->with('status', 'Sponsor Category Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SponsorCategory $sponsor_category)
    {
        try {
            $sponsor_category->update(['status' => 0]);

            return redirect()->route('sponsor-category.index')->with('delete', 'Sponsor Category Deleted Successfully');
        } catch (QueryException $e) {
            return redirect()->back()->with('delete', 'Cannot delete this sponser category.');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
