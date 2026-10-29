<?php

namespace App\Http\Controllers;

use App\Models\LamaranLowongan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LamaranLowonganController extends Controller
{
    /**
     * Update status lamaran peserta (Admin / Mitra only via web UI).
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $lamaran = LamaranLowongan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:melamar,diproses,wawancara,diterima,ditolak',
        ]);

        // Pastikan mitra hanya bisa update lamaran lowongan miliknya
        if (auth()->user()->role === 'mitra') {
            $idMitra = auth()->user()->mitra?->id_mitra;
            if ($lamaran->lowongan->id_mitra !== $idMitra) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah status lamaran ini.');
            }
        }

        $lamaran->update([
            'status'         => $request->status,
            'catatan_mitra'  => $request->input('catatan_mitra'),
        ]);

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui.');
    }
}

