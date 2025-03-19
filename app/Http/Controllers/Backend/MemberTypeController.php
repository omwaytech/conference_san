<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MemberType;
use Illuminate\Http\Request;
use Exception;

class MemberTypeController extends Controller
{
    public function index()
    {
        $types = MemberType::where(['status' => 1])->get();
        return view('backend.member-type.show', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.member-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'delegate' => 'required',
                'type' => 'required',
            ]);

            MemberType::create($validated);

            return redirect()->route('member-type.index')->with('status', 'Member Type Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemberType $member_type)
    {
        return view('backend.member-type.create', compact('member_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MemberType $member_type)
    {
        try {
            $validated = $request->validate([
                'delegate' => 'required',
                'type' => 'required',
            ]);

            $member_type->update($validated);

            return redirect()->route('member-type.index')->with('status', 'Member Type Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
