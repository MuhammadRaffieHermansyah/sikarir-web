<?php

namespace App\Http\Controllers;

use App\Models\DaftarPelatihan;
use App\Models\Instruktur;
use App\Models\JadwalPelatihan;
use App\Models\RuanganWorkshop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalPelatihanController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Inisialisasi Query Utama untuk Tabel
        $query = JadwalPelatihan::with(['pelatihan:id_pelatihan,nama_pelatihan,kuota', 'instruktur:id,nama', 'ruanganWorkshop:id,nama_ruangan'])
            ->withCount('kelas');

        // 2. Filter Pencarian Keyword (Nama Pelatihan, Instruktur, Tempat)
        if ($request->filled('search')) {
            $like = $this->likePattern($request->string('search')->toString());
            $query->where(function ($q) use ($like) {
                $q->whereIn('id_ruangan_workshop', RuanganWorkshop::select('id')->where('nama_ruangan', 'like', $like))
                    ->orWhereIn('id_instruktur', Instruktur::select('id')->where('nama', 'like', $like))
                    ->orWhereIn('id_pelatihan', DaftarPelatihan::select('id_pelatihan')->where('nama_pelatihan', 'like', $like));
            });
        }

        // 3. Filter Status Kelas (tersedia, berlangsung, selesai)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Hitung Statistik Metrics langsung dari DB (Biar Angka Card Atas Gak Jadi 0)
        $statusCounts = JadwalPelatihan::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $countBerlangsung = (int) ($statusCounts['berlangsung'] ?? 0);
        $countTersedia = (int) ($statusCounts['tersedia'] ?? 0);
        $countSelesai = (int) ($statusCounts['selesai'] ?? 0);

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
            'id_pelatihan' => 'required|exists:daftar_pelatihan,id_pelatihan',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
            'id_instruktur' => 'nullable|exists:instruktur,id',
            'id_ruangan_workshop' => 'nullable|exists:ruangan_workshop,id',
            'status' => 'required|in:tersedia,berlangsung,selesai',
            'lokasi_latitude' => 'nullable|numeric|between:-90,90',
            'lokasi_longitude' => 'nullable|numeric|between:-180,180',
            'radius_meter' => 'nullable|integer|min:10|max:10000',
        ], [
            'id_pelatihan.required' => 'Program pelatihan wajib dipilih.',
            'tanggal_mulai.required' => 'Tanggal mulai pelatihan wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai pelatihan wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid (contoh: 08:00).',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid (contoh: 15:30).',
            'id_instruktur.exists' => 'Instruktur yang dipilih tidak terdaftar.',
            'id_ruangan_workshop.exists' => 'Ruangan workshop yang dipilih tidak terdaftar.',
        ]);

        if (empty($validated['lokasi_latitude'])) {
            $validated['lokasi_latitude'] = -8.1763;
        }
        if (empty($validated['lokasi_longitude'])) {
            $validated['lokasi_longitude'] = 113.7007;
        }
        if (empty($validated['radius_meter'])) {
            $validated['radius_meter'] = 100;
        }

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
        $jadwal = JadwalPelatihan::findOrFail($id);
        $pelatihans = DaftarPelatihan::with('durasi')->orderBy('nama_pelatihan')->get();
        $instrukturs = Instruktur::orderBy('nama')->get();
        $ruanganWorkshops = RuanganWorkshop::orderBy('nama_ruangan')->get();

        return view('jadwal-pelatihan.edit', compact('jadwal', 'pelatihans', 'ruanganWorkshops', 'instrukturs'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $jadwal = JadwalPelatihan::findOrFail($id);

        $validated = $request->validate([
            'id_pelatihan' => 'required|exists:daftar_pelatihan,id_pelatihan',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'id_instruktur' => 'required|exists:instruktur,id',
            'id_ruangan_workshop' => 'required|exists:ruangan_workshop,id',
            'status' => 'required|in:tersedia,berlangsung,selesai',
            'lokasi_latitude' => 'nullable|numeric|between:-90,90',
            'lokasi_longitude' => 'nullable|numeric|between:-180,180',
            'radius_meter' => 'nullable|integer|min:10|max:10000',
        ], [
            'id_pelatihan.required' => 'Program pelatihan wajib dipilih.',
            'tanggal_mulai.required' => 'Tanggal mulai pelatihan wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai pelatihan wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid (contoh: 08:00).',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid (contoh: 15:30).',
            'id_instruktur.required' => 'Instruktur pembimbing wajib dipilih.',
            'id_instruktur.exists' => 'Instruktur yang dipilih tidak terdaftar.',
            'id_ruangan_workshop.required' => 'Ruangan workshop wajib dipilih.',
            'id_ruangan_workshop.exists' => 'Ruangan workshop yang dipilih tidak terdaftar.',
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
