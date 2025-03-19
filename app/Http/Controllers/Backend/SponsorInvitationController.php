<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SponsorInvitation;
use Illuminate\Http\Request;
use Exception, Storage, Image, Str;

class SponsorInvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sponsors = SponsorInvitation::where('status', 1)->latest()->get();
        return view('backend.conferences.sponsor-invitation.show', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.conferences.sponsor-invitation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'image' => 'nullable|mimes:png,jpg',
                'address' => 'nullable',
                'phone' => 'nullable',
                'description' => 'nullable',
            ]);

            if (!empty($validated['image'])) {
                $fileName = time() . '.' . $validated['image']->getClientOriginalExtension();
                $image = Image::make($validated['image']);

                $image->resize(1680, 820, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg');

                Storage::put("public/sponsors/{$fileName}", $image);
                $validated['image'] = $fileName;
            }
            $validated['token'] = Str::random(60);
            $validated['no_of_people'] = 1;

            SponsorInvitation::create($validated);

            return redirect()->route('sponsor-invitation.index')->with('status', 'Sponsor Invitation Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SponsorInvitation $sponsor_invitation)
    {
        return view('backend.conferences.sponsor-invitation.create', compact('sponsor_invitation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SponsorInvitation $sponsor_invitation)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'image' => 'nullable|mimes:png,jpg',
                'address' => 'nullable',
                'phone' => 'nullable',
                'description' => 'nullable',
            ]);

            if (!empty($validated['image'])) {
                Storage::delete("public/sponsors/{$sponsor_invitation->image}");
                $fileName = time() . '.' . $validated['image']->getClientOriginalExtension();
                $image = Image::make($validated['image']);

                $image->resize(1680, 820, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg');

                Storage::put("public/sponsors/{$fileName}", $image);
                $validated['image'] = $fileName;
            }

            $sponsor_invitation->update($validated);

            return redirect()->route('sponsor-invitation.index')->with('status', 'Sponsor Invitation Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SponsorInvitation $sponsor_invitation)
    {
        $sponsor_invitation->update(['status' => 0]);

        return redirect()->route('sponsor-invitation.index')->with('delete', 'Sponsor Invitation Deleted Successfully');
    }
}
