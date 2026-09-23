<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\User;
use App\Models\AdminBlk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesertaController extends Controller
{
    public function index(): View
    {
        $pesertas = Peserta::with(['user', 'admin.user', 'kelas.jadwal.pelatihan', 'sertifikat'])
            ->latest('id_peserta')
            ->paginate(10);

        return view('pesertas.index', compact('pesertas'));
    }

    public function create(): View
    {
        $users = User::orderBy('name')->get();
        $admins = AdminBlk::with('user')->get();
        return view('pesertas.create', compact('users', 'admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_user'             => 'required|exists:users,id|unique:pesertas,id_user',
            'id_admin'            => 'nullable|exists:admin_blks,id_admin',
            'nomor_peserta'       => 'required|string|max:50|unique:pesertas,nomor_peserta',
            'jenis_kelamin'       => 'required|in:Laki-laki,Perempuan',
            'jurusan'             => 'required|string|max:100',
            'nomor_wa'            => 'required|string|max:30',
            'nomor_kk'            => 'required|string|max:30',
            'tanggal_lahir'       => 'required|date',
            'tempat_lahir'        => 'required|string|max:100',
            'pendidikan_terakhir' => 'required|string|max:100',
            'alamat_lengkap'      => 'required|string',
        ], [
            'id_user.required'       => 'Akun pengguna wajib dipilih.',
            'id_user.unique'         => 'Pengguna ini sudah terdaftar sebagai Peserta.',
            'nomor_peserta.required' => 'Nomor peserta (NIS) wajib diisi.',
            'nomor_peserta.unique'   => 'Nomor peserta (NIS) sudah digunakan.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'nomor_wa.required' => 'Nomor WA wajib diisi.',
            'nomor_kk.required' => 'Nomor KK wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
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
        $users   = User::orderBy('name')->get();
        $admins  = AdminBlk::with('user')->get();
        return view('pesertas.edit', compact('peserta', 'users', 'admins'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $peserta = Peserta::findOrFail($id);

        $validated = $request->validate([
            'id_user'             => 'required|exists:users,id|unique:pesertas,id_user,' . $peserta->id_peserta . ',id_peserta',
            'id_admin'            => 'nullable|exists:admin_blks,id_admin',
            'nomor_peserta'       => 'required|string|max:50|unique:pesertas,nomor_peserta,' . $peserta->id_peserta . ',id_peserta',
            'jenis_kelamin'       => 'required|in:Laki-laki,Perempuan',
            'jurusan'             => 'nullable|string|max:100',
            'nomor_wa'            => 'nullable|string|max:30',
            'nomor_kk'            => 'nullable|string|max:30',
            'tanggal_lahir'       => 'nullable|date',
            'tempat_lahir'        => 'nullable|string|max:100',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'alamat_lengkap'      => 'nullable|string',
        ], [
            'id_user.unique' => 'Akun pengguna ini sudah terdaftar sebagai Peserta.',
            'nomor_peserta.unique' => 'Nomor peserta (NIS) sudah digunakan.',
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

