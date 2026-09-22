<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicLowonganController extends Controller
{
    public function index()
    {
    $lowongan = \App\Models\DaftarLowongan::all(); // sesuaikan nama Model kalian
    return view('public.lowongan-katalog', compact('lowongan'));
    }
}
