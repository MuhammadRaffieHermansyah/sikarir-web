<?php

namespace App\Http\Controllers;

use App\Models\AdminBlk;
use App\Models\DaftarPelatihan;
use App\Models\JadwalPelatihan;
use App\Models\Peserta;
use App\Models\Sertifikat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SertifikatController extends Controller
{
    public function index(Request $request): View
    {
        $query = Sertifikat::with(['peserta:id_peserta,id_user,nama', 'peserta.user:id,email', 'jadwal:id_jadwal,id_pelatihan', 'jadwal.pelatihan:id_pelatihan,nama_pelatihan']);
        $this->scopeToOwnPeserta($query, $request);

        if ($request->filled('search')) {
            $like = $this->likePattern($request->string('search')->toString());
            $query->where(function ($q) use ($like) {
                $q->where('no_sertifikat', 'like', $like)
                    ->orWhereIn('id_peserta', Peserta::select('id_peserta')->where('nama', 'like', $like))
                    ->orWhereIn('id_jadwal', JadwalPelatihan::select('id_jadwal')
                        ->whereIn('id_pelatihan', DaftarPelatihan::select('id_pelatihan')->where('nama_pelatihan', 'like', $like)));
            });
        }

        $sertifikats = $query->latest('id_sertifikat')
            ->paginate(10)
            ->withQueryString();

        return view('sertifikat.index', compact('sertifikats'));
    }

    public function create(): View
    {
        $pesertas = Peserta::with('user')->orderBy('nomor_peserta')->get();
        $jadwals = JadwalPelatihan::with('pelatihan')->orderBy('id_jadwal', 'desc')->get();
        $admins = AdminBlk::with('user')->get();

        return view('sertifikat.create', compact('pesertas', 'jadwals', 'admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_peserta' => 'required|exists:pesertas,id_peserta',
            'id_jadwal' => 'required|exists:jadwal_pelatihan,id_jadwal',
            'id_admin' => 'required|exists:admin_blks,id_admin',
            'no_sertifikat' => 'required|string|max:100|unique:sertifikats,no_sertifikat|regex:/^[a-zA-Z0-9\s\/.\-]+$/',
            'tanggal_terbit' => 'required|date',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'id_peserta.required' => 'Siswa penerima sertifikat wajib dipilih.',
            'id_jadwal.required' => 'Batch kelas yang diselesaikan wajib dipilih.',
            'id_admin.required' => 'Admin BLK penandatangan wajib dipilih.',
            'no_sertifikat.required' => 'Nomor seri sertifikat wajib diisi.',
            'no_sertifikat.unique' => 'Nomor seri sertifikat sudah digunakan.',
            'tanggal_terbit.required' => 'Tanggal penerbitan sertifikat wajib diisi.',
            'no_sertifikat.regex' => 'Nomor sertifikat hanya boleh berisi huruf, angka, spasi, serta tanda / . -',
        ]);

        // Check if peserta already has sertifikat for this jadwal
        if (Sertifikat::where('id_peserta', $validated['id_peserta'])->where('id_jadwal', $validated['id_jadwal'])->exists()) {
            return back()->withInput()->withErrors(['error' => 'Siswa ini sudah memiliki sertifikat untuk program pelatihan tersebut.']);
        }

        if ($request->hasFile('file_sertifikat')) {
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }

        Sertifikat::create($validated);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat kompetensi vokasi berhasil diterbitkan.');
    }

    public function show(Request $request, int $id): View
    {
        $query = Sertifikat::with(['peserta.user', 'jadwal.pelatihan', 'admin.user']);
        $this->scopeToOwnPeserta($query, $request);
        $sertifikat = $query->findOrFail($id);

        return view('sertifikat.show', compact('sertifikat'));
    }

    public function edit(int $id): View
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $pesertas = Peserta::with('user')->get();
        $jadwals = JadwalPelatihan::with('pelatihan')->get();
        $admins = AdminBlk::with('user')->get();

        return view('sertifikat.edit', compact('sertifikat', 'pesertas', 'jadwals', 'admins'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $sertifikat = Sertifikat::findOrFail($id);

        $validated = $request->validate([
            'id_peserta' => 'required|exists:pesertas,id_peserta',
            'id_jadwal' => 'required|exists:jadwal_pelatihan,id_jadwal',
            'id_admin' => 'required|exists:admin_blks,id_admin',
            'no_sertifikat' => 'required|string|max:100|unique:sertifikats,no_sertifikat,'.$sertifikat->id_sertifikat.',id_sertifikat|regex:/^[a-zA-Z0-9\s\/.\-]+$/',
            'tanggal_terbit' => 'required|date',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'no_sertifikat.regex' => 'Nomor sertifikat hanya boleh berisi huruf, angka, spasi, serta tanda / . -',
        ]);

        // Prevent moving to a (peserta, jadwal) combination that already has a sertifikat
        $comboExists = Sertifikat::where('id_peserta', $validated['id_peserta'])
            ->where('id_jadwal', $validated['id_jadwal'])
            ->where('id_sertifikat', '!=', $sertifikat->id_sertifikat)
            ->exists();

        if ($comboExists) {
            return back()->withInput()->withErrors(['error' => 'Siswa ini sudah memiliki sertifikat untuk program pelatihan tersebut.']);
        }

        if ($request->hasFile('file_sertifikat')) {
            if ($sertifikat->file_sertifikat) {
                Storage::disk('public')->delete($sertifikat->file_sertifikat);
            }
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }

        $sertifikat->update($validated);

        return redirect()->route('sertifikat.index')->with('success', 'Data sertifikat kompetensi berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $sertifikat = Sertifikat::findOrFail($id);
        if ($sertifikat->file_sertifikat) {
            Storage::disk('public')->delete($sertifikat->file_sertifikat);
        }
        $sertifikat->delete();

        return redirect()->route('sertifikat.index')->with('success', 'Data sertifikat kompetensi berhasil dihapus.');
    }

    /**
     * Peserta hanya boleh melihat sertifikatnya sendiri.
     */
    private function scopeToOwnPeserta(Builder $query, Request $request): void
    {
        $user = $request->user();

        if ($user?->role === 'peserta') {
            $query->where('id_peserta', $user->peserta?->id_peserta ?? 0);
        }
    }
}
