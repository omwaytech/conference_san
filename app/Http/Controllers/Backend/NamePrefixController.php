<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\NamePrefix;
use Illuminate\Http\Request;
use Exception, Storage;

class NamePrefixController extends Controller
{
    public function index()
    {
        $prefixes = NamePrefix::where(['status' => 1])->latest()->get();
        return view('backend.name-prefix.show', compact('prefixes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.name-prefix.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'prefix' => 'required'
            ];

            $validated = $request->validate($rules);

            NamePrefix::create($validated);

            return redirect()->route('name-prefix.index')->with('status', 'Name Prefix Added Successfully');

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NamePrefix $name_prefix)
    {
        return view('backend.name-prefix.create', compact('name_prefix'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NamePrefix $name_prefix)
    {
        try {
            $rules = [
                'prefix' => 'required',
            ];

            $validated = $request->validate($rules);

            $name_prefix->update($validated);

            return redirect()->route('name-prefix.index')->with('status', 'Name Prefix Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NamePrefix $name_prefix)
    {
        $name_prefix->update(['status' => 0]);

        return redirect()->route('name-prefix.index')->with('delete', 'Name Prefix Deleted Successfully');
    }
}
