<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Modul;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function store(Request $request, int $idModul): JsonResponse
    {
        $modul = Modul::with('jadwal')->findOrFail($idModul);
        abort_unless($modul->jadwal->diampuOleh($request->user()), 403, 'Hanya instruktur pengampu yang dapat menambah materi.');

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:file,link,teks'],
            'file' => ['required_if:tipe,file', 'file', 'max:51200', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,mp4,jpg,jpeg,png'],
            'url' => ['required_if:tipe,link', 'nullable', 'url:http,https', 'max:2048'],
            'konten' => ['required_if:tipe,teks', 'nullable', 'string'],
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'file.required_if' => 'File wajib diunggah.',
            'url.required_if' => 'URL wajib diisi.',
            'konten.required_if' => 'Konten wajib diisi.',
        ]);

        $attributes = ['judul' => $data['judul'], 'tipe' => $data['tipe']];

        if ($data['tipe'] === 'file') {
            $file = $request->file('file');
            $attributes['url'] = $file->store('materi', 'public');
            $attributes['nama_file'] = $file->getClientOriginalName();
        } elseif ($data['tipe'] === 'link') {
            $attributes['url'] = $data['url'];
        } else {
            $attributes['konten'] = $data['konten'];
        }

        $materi = $modul->materi()->create($attributes);

        return response()->json([
            'message' => 'Materi berhasil ditambahkan',
            'data' => self::format($materi),
        ], 201);
    }

    public function destroy(Request $request, int $idMateri): JsonResponse
    {
        $materi = Materi::with('modul.jadwal')->findOrFail($idMateri);
        abort_unless($materi->modul->jadwal->diampuOleh($request->user()), 403, 'Hanya instruktur pengampu yang dapat menghapus materi.');

        if ($materi->tipe === 'file' && $materi->url) {
            Storage::disk('public')->delete($materi->url);
        }
        $materi->delete();

        return response()->json(['message' => 'Materi berhasil dihapus']);
    }

    /**
     * @return array<string, mixed>
     */
    public static function format(Materi $materi): array
    {
        return array_filter([
            'id_materi' => $materi->id_materi,
            'id_modul' => $materi->id_modul,
            'judul' => $materi->judul,
            'tipe' => $materi->tipe,
            'url' => $materi->url,
            'nama_file' => $materi->nama_file,
            'konten' => $materi->konten,
        ], fn ($value) => $value !== null);
    }
}
