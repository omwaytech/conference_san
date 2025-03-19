<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('backend.certificates.index', compact('sponsors'));
    }

    public function generate()
    {
        $sponsors = Sponsor::get();
        return view('backend.certificates.certificate', compact('sponsors'));
    }

    public function generateIndividual($id)
    {
        $sponsor = Sponsor::whereId($id)->first();
        return view('backend.certificates.certificate', compact('sponsor'));
    }
}
