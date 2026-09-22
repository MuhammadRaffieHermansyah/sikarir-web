<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicPelatihanController extends Controller
{
    public function index()
{
    $pelatihan = \App\Models\DaftarPelatihan::all();
    return view('public.pelatihan-katalog', compact('pelatihan'));
}
}
