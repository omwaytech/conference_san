<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use Exception;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('backend.designations.show', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.designations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'designation'=> 'required'
            ]);

            Designation::create($validated);

            return redirect()->route('designation.index')->with('status', 'Designation Added Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        return view('backend.designations.create', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        try {
            $validated = $request->validate([
                'designation'=> 'required'
            ]);

            $designation->update($validated);

            return redirect()->route('designation.index')->with('status', 'Designation Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        if ($designation->committeeMembers->isNotEmpty()) {
            $message = 'Cannot delete this designation.';
        } else {
            $designation->update(['status' => 0]);
            $message = 'Designation Deleted Successfully.';
        }
        return redirect()->route('designation.index')->with('delete', $message);
    }

    public function order()
    {
        $designations = Designation::orderBy('order_no', 'ASC')->get();
        return view('backend.designations.order', compact('designations'));
    }

    public function orderSubmit(Request $request)
    {
        $posts = Designation::all();

        foreach ($posts as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['order_no' => $order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
    }
}
