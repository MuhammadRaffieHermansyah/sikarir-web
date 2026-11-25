<?php

namespace App\Http\Controllers;

use App\Models\AdminBlk;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PesertaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Peserta::with('user:id,email')->withCount('kelas');

        // Filter Pencarian (Nama, Email, NIS / Nomor Peserta, Jurusan, Nomor WA)
        if ($request->filled('search')) {
            $like = $this->likePattern($request->string('search')->toString());
            $query->where(function ($q) use ($like) {
                $q->where('nomor_peserta', 'like', $like)
                    ->orWhere('nama', 'like', $like)
                    ->orWhere('jurusan', 'like', $like)
                    ->orWhere('nomor_wa', 'like', $like)
                    ->orWhereIn('id_user', User::select('id')->where('email', 'like', $like));
            });
        }

        // Filter Spesifik Berdasarkan Jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        // Ambil daftar jurusan unik untuk opsi dropdown filter
        $jurusanList = Cache::remember('peserta.jurusan-list', 300, fn () => Peserta::whereNotNull('jurusan')->distinct()->orderBy('jurusan')->pluck('jurusan'));

        // Ambil data terbaru dengan pagination & pertahankan query string URL
        $pesertas = $query->latest('id_peserta')
            ->paginate(10)
            ->withQueryString();

        return view('pesertas.index', compact('pesertas', 'jurusanList'));
    }

    public function create(): View
    {
        $users = User::select('id', 'email', 'role')->withProfileNames()->where('role', 'peserta')->doesntHave('peserta')->orderBy('email')->get();
        $admins = AdminBlk::select('id_admin', 'nama')->orderBy('nama')->get();

        return view('pesertas.create', compact('users', 'admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id|unique:pesertas,id_user',
            'id_admin' => 'nullable|exists:admin_blks,id_admin',
            'nama' => 'required|string|max:255|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'nomor_peserta' => 'required|string|max:50|unique:pesertas,nomor_peserta',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'jurusan' => 'required|string|max:100|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'nomor_wa' => ['required', 'string', 'max:30', 'regex:/^\+?[0-9]{8,20}$/'],
            'nomor_kk' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:100|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'pendidikan_terakhir' => 'required|string|max:100|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'alamat_lengkap' => 'required|string|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
        ], [
            'id_user.required' => 'Akun pengguna wajib dipilih.',
            'id_user.unique' => 'Pengguna ini sudah terdaftar sebagai Peserta.',
            'nama.required' => 'Nama peserta wajib diisi.',
            'nama.regex' => 'Nama peserta hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'nomor_peserta.required' => 'Nomor peserta (NIS) wajib diisi.',
            'nomor_peserta.unique' => 'Nomor peserta (NIS) sudah digunakan.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'nomor_wa.required' => 'Nomor WA wajib diisi.',
            'nomor_wa.regex' => 'Nomor WA hanya boleh berisi angka (8-20 digit, boleh diawali +).',
            'nomor_kk.regex' => 'Nomor KK harus 16 digit angka.',
            'nomor_kk.required' => 'Nomor KK wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'jurusan.regex' => 'Jurusan hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'tempat_lahir.regex' => 'Tempat lahir hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'pendidikan_terakhir.regex' => 'Pendidikan terakhir hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'alamat_lengkap.regex' => 'Alamat lengkap hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
        ]);

        Peserta::create($validated);

        return redirect()->route('pesertas.index')->with('success', 'Data peserta vokasi berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $peserta = Peserta::with(['user', 'admin.user', 'kelas.jadwal.pelatihan', 'absensi.jadwal.pelatihan', 'sertifikat.jadwal.pelatihan'])->findOrFail($id);

        return view('pesertas.show', compact('peserta'));
    }

    public function edit(int $id): View
    {
        $peserta = Peserta::with('user')->findOrFail($id);
        $users = User::select('id', 'email')
            ->where('role', 'peserta')
            ->where(fn ($q) => $q->doesntHave('peserta')->orWhere('id', $peserta->id_user))
            ->orderBy('email')->get();
        $admins = AdminBlk::select('id_admin', 'nama')->orderBy('nama')->get();

        return view('pesertas.edit', compact('peserta', 'users', 'admins'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $peserta = Peserta::findOrFail($id);

        $validated = $request->validate([
            'id_user' => 'required|exists:users,id|unique:pesertas,id_user,'.$peserta->id_peserta.',id_peserta',
            'id_admin' => 'nullable|exists:admin_blks,id_admin',
            'nama' => 'required|string|max:255|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'nomor_peserta' => 'required|string|max:50|unique:pesertas,nomor_peserta,'.$peserta->id_peserta.',id_peserta',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'jurusan' => 'nullable|string|max:100|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'nomor_wa' => ['nullable', 'string', 'max:30', 'regex:/^\+?[0-9]{8,20}$/'],
            'nomor_kk' => ['nullable', 'string', 'regex:/^[0-9]{16}$/'],
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'pendidikan_terakhir' => 'nullable|string|max:100|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
            'alamat_lengkap' => 'nullable|string|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
        ], [
            'id_user.unique' => 'Akun pengguna ini sudah terdaftar sebagai Peserta.',
            'nama.required' => 'Nama peserta wajib diisi.',
            'nama.regex' => 'Nama peserta hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'nomor_peserta.unique' => 'Nomor peserta (NIS) sudah digunakan.',
            'nomor_wa.regex' => 'Nomor WA hanya boleh berisi angka (8-20 digit, boleh diawali +).',
            'nomor_kk.regex' => 'Nomor KK harus 16 digit angka.',
            'jurusan.regex' => 'Jurusan hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'tempat_lahir.regex' => 'Tempat lahir hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'pendidikan_terakhir.regex' => 'Pendidikan terakhir hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'alamat_lengkap.regex' => 'Alamat lengkap hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
        ]);

        $peserta->update($validated);

        return redirect()->route('pesertas.index')->with('success', 'Data peserta vokasi berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();

        return redirect()->route('pesertas.index')->with('success', 'Data peserta vokasi berhasil dihapus.');
    }
}
