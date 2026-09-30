<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelatihan;
use App\Models\DaftarPelatihan;
use App\Models\Instruktur;
use App\Models\RuanganWorkshop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalPelatihanController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Inisialisasi Query Utama untuk Tabel
        $query = JadwalPelatihan::with(['pelatihan', 'instruktur', 'ruanganWorkshop', 'kelas.peserta.user']);

        // 2. Filter Pencarian Keyword (Nama Pelatihan, Instruktur, Tempat)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('ruanganWorkshop', function ($sub) use ($search) { 
                    $sub->where('nama_ruangan', 'like', "%{$search}%");
                })
                  ->orWhereHas('instruktur', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('pelatihan', function ($sub) use ($search) {
                      $sub->where('nama_pelatihan', 'like', "%{$search}%");
                  });
            });
        }

        // 3. Filter Status Kelas (tersedia, berlangsung, selesai)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Hitung Statistik Metrics langsung dari DB (Biar Angka Card Atas Gak Jadi 0)
        $countBerlangsung = JadwalPelatihan::where('status', 'berlangsung')->count();
        $countTersedia    = JadwalPelatihan::where('status', 'tersedia')->count();
        $countSelesai     = JadwalPelatihan::where('status', 'selesai')->count();

        // 5. Paginate Data & Tahan Parameter URL saat Pindah Halaman
        $jadwals = $query->latest('id_jadwal')
                         ->paginate(10)
                         ->withQueryString();

        return view('jadwal-pelatihan.index', compact(
            'jadwals',
            'countBerlangsung',
            'countTersedia',
            'countSelesai'
        ));
    }

    public function create(): View
    {
        $pelatihans = DaftarPelatihan::with('durasi')->orderBy('nama_pelatihan')->get();
        $instrukturs = Instruktur::orderBy('nama')->get();
        $ruanganWorkshops = RuanganWorkshop::orderBy('nama_ruangan')->get();
        return view('jadwal-pelatihan.create', compact('pelatihans', 'instrukturs', 'ruanganWorkshops'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_pelatihan'    => 'required|exists:daftar_pelatihan,id_pelatihan',
            'tanggal_mulai'   => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'jam_mulai'       => 'nullable|date_format:H:i',
            'jam_selesai'     => 'nullable|date_format:H:i',
            'id_instruktur'    => 'required|exists:instruktur,id',
            'id_ruangan_workshop' => 'required|exists:ruangan_workshop,id',
            'status'          => 'required|in:tersedia,berlangsung,selesai',
        ], [
            'id_pelatihan.required'           => 'Program pelatihan wajib dipilih.',
            'tanggal_mulai.required'          => 'Tanggal mulai pelatihan wajib diisi.',
            'tanggal_selesai.required'        => 'Tanggal selesai pelatihan wajib diisi.',
            'tanggal_selesai.after_or_equal'  => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'jam_mulai.date_format'           => 'Format jam mulai tidak valid (contoh: 08:00).',
            'jam_selesai.date_format'         => 'Format jam selesai tidak valid (contoh: 15:30).',
            'id_instruktur.exists'            => 'Instruktur yang dipilih tidak terdaftar.',
            'id_ruangan_workshop.exists'      => 'Ruangan workshop yang dipilih tidak terdaftar.',
        ]);

        JadwalPelatihan::create($validated);
        return redirect()->route('jadwal-pelatihan.index')->with('success', 'Batch jadwal pelatihan berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $jadwal = JadwalPelatihan::with(['pelatihan.admin.user', 'instruktur', 'ruanganWorkshop', 'kelas.peserta.user', 'absensi', 'sertifikat'])->findOrFail($id);
        return view('jadwal-pelatihan.show', compact('jadwal'));
    }

    public function edit(int $id): View
    {
        $jadwal     = JadwalPelatihan::findOrFail($id);
        $pelatihans = DaftarPelatihan::with('durasi')->orderBy('nama_pelatihan')->get();
        $instrukturs = Instruktur::orderBy('nama')->get();
        $ruanganWorkshops = RuanganWorkshop::orderBy('nama_ruangan')->get();
        return view('jadwal-pelatihan.edit', compact('jadwal', 'pelatihans', 'ruanganWorkshops', 'instrukturs'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $jadwal = JadwalPelatihan::findOrFail($id);

        $validated = $request->validate([
            'id_pelatihan'    => 'required|exists:daftar_pelatihan,id_pelatihan',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai'       => 'required|date_format:H:i',
            'jam_selesai'     => 'required|date_format:H:i',
            'id_instruktur'    => 'required|exists:instruktur,id',
            'id_ruangan_workshop' => 'required|exists:ruangan_workshop,id',
            'status'          => 'required|in:tersedia,berlangsung,selesai',
        ], [
            'id_pelatihan.required'           => 'Program pelatihan wajib dipilih.',
            'tanggal_mulai.required'          => 'Tanggal mulai pelatihan wajib diisi.',
            'tanggal_selesai.required'        => 'Tanggal selesai pelatihan wajib diisi.',
            'tanggal_selesai.after_or_equal'  => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'jam_mulai.date_format'           => 'Format jam mulai tidak valid (contoh: 08:00).',
            'jam_selesai.date_format'         => 'Format jam selesai tidak valid (contoh: 15:30).',
            'id_instruktur.required'          => 'Instruktur pembimbing wajib dipilih.',
            'id_instruktur.exists'            => 'Instruktur yang dipilih tidak terdaftar.',
            'id_ruangan_workshop.required'    => 'Ruangan workshop wajib dipilih.',
            'id_ruangan_workshop.exists'      => 'Ruangan workshop yang dipilih tidak terdaftar.',
        ]);

        $jadwal->update($validated);
        return redirect()->route('jadwal-pelatihan.index')->with('success', 'Batch jadwal pelatihan berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $jadwal = JadwalPelatihan::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwal-pelatihan.index')->with('success', 'Batch jadwal pelatihan berhasil dihapus.');
    }
}