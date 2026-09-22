<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicPelatihanController extends Controller
{
    public function index()
{
    $pelatihan = \App\Models\DaftarPelatihan::all(); // sesuaikan nama Model kalian
    return view('public.pelatihan-katalog', compact('pelatihan'));
}
}
