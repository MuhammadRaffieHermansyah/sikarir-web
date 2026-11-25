<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MitraController extends Controller
{
    public function index(Request $request): View
    {
        $query = Mitra::with(['user', 'lowongan']);

        // Filter Pencarian (Nama Perusahaan, Bidang Usaha, Kota, Provinsi, No Telp)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_perusahaan', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('bidang_usaha', 'like', "%{$search}%")
                    ->orWhere('kota', 'like', "%{$search}%")
                    ->orWhere('provinsi', 'like', "%{$search}%")
                    ->orWhere('no_telp', 'like', "%{$search}%")
                    ->orWhere('jabatan_pic', 'like', "%{$search}%");
            });
        }

        // Filter Berdasarkan Jenis Mitra
        if ($request->filled('jenis_mitra')) {
            $query->where('jenis_mitra', $request->jenis_mitra);
        }

        // Ambil daftar jenis mitra unik untuk opsi dropdown filter
        $jenisMitraList = Mitra::distinct()->whereNotNull('jenis_mitra')->pluck('jenis_mitra');

        // Ambil data terbaru dengan pagination & pertahankan query string URL
        $mitras = $query->latest('id_mitra')
            ->paginate(10)
            ->withQueryString();

        return view('mitras.index', compact('mitras', 'jenisMitraList'));
    }

    public function create(): View
    {
        $users = User::orderBy('email')->get();

        return view('mitras.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'logo_perusahaan' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'nama' => 'required|string|max:255|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'nama_perusahaan' => 'required|unique:mitras,nama_perusahaan|string|max:255|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'id_user' => 'required|exists:users,id|unique:mitras,id_user',
            'jenis_mitra' => 'required|string|max:100',
            'bidang_usaha' => 'required|string|max:255|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'no_telp' => 'required|string|min:10|max:13|regex:/^[0-9]+$/',
            'no_izin' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s\/.\-]+$/',
            'jabatan_pic' => 'required|string|max:100|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'provinsi' => 'required|string|max:100|regex:/^[\pL\s.,\x27\-]+$/u',
            'kota' => 'required|string|max:100|regex:/^[\pL\s.,\x27\-]+$/u',
            'alamat' => 'required|string',
        ], [
            'logo_perusahaan.required' => 'Logo perusahaan wajib diunggah.',
            'nama.required' => 'Nama PIC wajib diisi.',
            'nama.regex' => 'Nama PIC hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'nama_perusahaan.unique' => 'Nama perusahaan sudah terdaftar.',
            'id_user.unique' => 'Akun pengguna ini sudah ditautkan ke mitra lain.',
            'jenis_mitra.required' => 'Jenis mitra wajib diisi.',
            'bidang_usaha.required' => 'Bidang usaha wajib diisi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_izin.required' => 'Nomor izin wajib diisi.',
            'jabatan_pic.required' => 'Jabatan PIC wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'kota.required' => 'Kota wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'nama_perusahaan.regex' => 'Nama perusahaan hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'bidang_usaha.regex' => 'Bidang usaha hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'jabatan_pic.regex' => 'Jabatan PIC hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'provinsi.regex' => 'Provinsi hanya boleh berisi huruf, spasi, dan tanda . , - \'.',
            'kota.regex' => 'Kota hanya boleh berisi huruf, spasi, dan tanda . , - \'.',
            'no_izin.regex' => 'Nomor izin hanya boleh berisi huruf, angka, spasi, serta tanda / . -',
            'logo_perusahaan.image' => 'File logo harus berupa gambar.',
            'logo_perusahaan.mimes' => 'Format logo yang diizinkan: jpeg, png, jpg, gif, webp, svg.',
            'logo_perusahaan.max' => 'Ukuran file logo maksimal 2MB.',
            'no_telp.regex' => 'Nomor telepon harus berupa angka.',
            'no_telp.min' => 'Nomor telepon minimal 10 digit.',
            'no_telp.max' => 'Nomor telepon maksimal 13 digit.',
        ]);

        if ($request->hasFile('logo_perusahaan')) {
            $validated['logo_perusahaan'] = $request->file('logo_perusahaan')
                ->store('logos/mitras', 'public');
        }

        Mitra::create($validated);

        return redirect()->route('mitras.index')->with('success', 'Data mitra DU/DI berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $mitra = Mitra::with(['user', 'verifiedBy'])->findOrFail($id);

        return view('mitras.show', compact('mitra'));
    }

    public function verify(Mitra $mitra): RedirectResponse
    {
        if ($mitra->is_verified) {
            return redirect()->route('mitras.show', $mitra)->with('success', 'Mitra ini sudah terverifikasi.');
        }

        $mitra->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => request()->user()->id,
        ]);

        return redirect()->route('mitras.show', $mitra)->with('success', 'Mitra berhasil diverifikasi dan kini dapat mengelola lowongan.');
    }

    public function downloadDocument(Mitra $mitra, string $document): StreamedResponse
    {
        $path = match ($document) {
            'legalitas' => $mitra->surat_legalitas_path,
            'permohonan' => $mitra->surat_permohonan_kerjasama_path,
        };

        abort_unless($path && Storage::exists($path), 404);

        return Storage::download($path, $document.'-'.$mitra->id_mitra.'.'.pathinfo($path, PATHINFO_EXTENSION));
    }

    public function edit(int $id): View
    {
        $mitra = Mitra::with('user')->findOrFail($id);
        $users = User::orderBy('email')->get();

        return view('mitras.edit', compact('mitra', 'users'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $mitra = Mitra::findOrFail($id);

        $validated = $request->validate([
            'logo_perusahaan' => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'nama' => 'nullable|string|max:255|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'nama_perusahaan' => ['required', 'string', 'max:255', 'regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u', Rule::unique('mitras', 'nama_perusahaan')->ignore($id, 'id_mitra')],
            'id_user' => 'required|',
            'jenis_mitra' => 'required|string|max:100',
            'bidang_usaha' => 'required|string|max:255|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'no_telp' => 'required|string|min:10|max:13|regex:/^[0-9]+$/',
            'no_izin' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z0-9\s\/.\-]+$/', Rule::unique('mitras', 'no_izin')->ignore($id, 'id_mitra')],
            'jabatan_pic' => 'required|string|max:100|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'provinsi' => 'required|string|max:100|regex:/^[\pL\s.,\x27\-]+$/u',
            'kota' => 'required|string|max:100|regex:/^[\pL\s.,\x27\-]+$/u',
            'alamat' => 'required|string',
        ], [
            'nama.required' => 'Nama PIC wajib diisi.',
            'nama.regex' => 'Nama PIC hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'nama_perusahaan.unique' => 'Nama perusahaan sudah terdaftar.',
            'jenis_mitra.required' => 'Jenis mitra wajib diisi.',
            'bidang_usaha.required' => 'Bidang usaha wajib diisi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_izin.required' => 'Nomor izin wajib diisi.',
            'jabatan_pic.required' => 'Jabatan PIC wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'kota.required' => 'Kota wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'nama_perusahaan.regex' => 'Nama perusahaan hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'bidang_usaha.regex' => 'Bidang usaha hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'jabatan_pic.regex' => 'Jabatan PIC hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'provinsi.regex' => 'Provinsi hanya boleh berisi huruf, spasi, dan tanda . , - \'.',
            'kota.regex' => 'Kota hanya boleh berisi huruf, spasi, dan tanda . , - \'.',
            'no_izin.regex' => 'Nomor izin hanya boleh berisi huruf, angka, spasi, serta tanda / . -',
            'logo_perusahaan.image' => 'File logo harus berupa gambar.',
            'logo_perusahaan.mimes' => 'Format logo yang diizinkan: jpeg, png, jpg, gif, webp, svg.',
            'logo_perusahaan.max' => 'Ukuran file logo maksimal 2MB.',
            'no_telp.regex' => 'Nomor telepon harus berupa angka.',
            'no_telp.min' => 'Nomor telepon minimal 10 digit.',
            'no_telp.max' => 'Nomor telepon maksimal 13 digit.',
        ]);

        if ($request->hasFile('logo_perusahaan')) {
            // Delete old logo if exists
            if ($mitra->logo_perusahaan) {
                Storage::disk('public')->delete($mitra->logo_perusahaan);
            }
            $validated['logo_perusahaan'] = $request->file('logo_perusahaan')
                ->store('logos/mitras', 'public');
        }

        $mitra->update($validated);

        return redirect()->route('mitras.index')->with('success', 'Data mitra DU/DI berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $mitra = Mitra::findOrFail($id);
        // Delete logo file from storage if exists
        if ($mitra->logo_perusahaan) {
            Storage::disk('public')->delete($mitra->logo_perusahaan);
        }
        $mitra->delete();

        return redirect()->route('mitras.index')->with('success', 'Data mitra DU/DI berhasil dihapus.');
    }
}
