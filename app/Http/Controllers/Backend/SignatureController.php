<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{Conference, Signature};
use Illuminate\Http\Request;
use Exception, Storage;

class SignatureController extends Controller
{
    public function index()
    {
        $latestConference = Conference::latestConference();
        $signatures = Signature::where(['conference_id' => $latestConference->id, 'status' => 1])->latest()->get();
        return view('backend.certificates.signatures.show', compact('signatures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.certificates.signatures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required',
                'designation' => 'required',
                'signature' => 'required|mimes:png'
            ];

            $validated = $request->validate($rules);

            $fileName = time() . '.' . $validated['signature']->getClientOriginalExtension();
            Storage::putFileAs("public/certificates/signatures", $validated['signature'], $fileName);
            $validated['signature'] = $fileName;

            $latestConference = Conference::latestConference();
            $validated['conference_id'] = $latestConference->id;

            Signature::create($validated);

            return redirect()->route('signature.index')->with('status', 'Certificate Signature Added Successfully');

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Signature $signature)
    {
        return view('backend.certificates.signatures.create', compact('signature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Signature $signature)
    {
        try {
            $rules = [
                'name' => 'required',
                'designation' => 'required',
                'signature' => 'nullable|mimes:png',
            ];

            $validated = $request->validate($rules);

            if (!empty($validated['signature'])) {
                Storage::delete('public/certificates/signatures/'.$signature->signature);
                $fileName = time() . '.' . $validated['signature']->getClientOriginalExtension();
                Storage::putFileAs("public/certificates/signatures", $validated['signature'], $fileName);
                $validated['signature'] = $fileName;
            }

            $signature->update($validated);

            return redirect()->route('signature.index')->with('status', 'Certificate Signature Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Signature $signature)
    {
        $signature->update(['status' => 0]);

        return redirect()->route('signature.index')->with('delete', 'Certificate Signature Deleted Successfully');
    }
}
