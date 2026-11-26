<?php

namespace Database\Seeders;

use App\Models\Sertifikat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * Pastikan setiap sertifikat demo punya file PDF di storage publik,
 * supaya tombol "Unduh PDF" di aplikasi tidak berujung 404 saat demo.
 * Aman dijalankan ulang: hanya menulis file yang belum ada.
 */
class SertifikatDemoSeeder extends Seeder
{
    public function run(): void
    {
        $disk = Storage::disk('public');

        Sertifikat::with(['peserta', 'jadwal.pelatihan'])
            ->whereNotNull('file_sertifikat')
            ->get()
            ->reject(fn (Sertifikat $sertifikat): bool => $disk->exists($sertifikat->file_sertifikat))
            ->each(function (Sertifikat $sertifikat) use ($disk): void {
                $disk->put($sertifikat->file_sertifikat, $this->buatPdf([
                    'SERTIFIKAT KOMPETENSI',
                    'UPT BLK Jember - siKarir',
                    '',
                    'Diberikan kepada: '.($sertifikat->peserta?->nama ?? 'Peserta'),
                    'Program: '.($sertifikat->jadwal?->pelatihan?->nama_pelatihan ?? 'Pelatihan Vokasi'),
                    'Nomor: '.$sertifikat->no_sertifikat,
                    'Tanggal terbit: '.Carbon::parse($sertifikat->tanggal_terbit)->format('d-m-Y'),
                    '',
                    'Dokumen contoh untuk demo aplikasi.',
                ]));
            });
    }

    /**
     * Susun PDF satu halaman (A4 landscape) berisi baris teks, tanpa library tambahan.
     *
     * @param  list<string>  $baris
     */
    private function buatPdf(array $baris): string
    {
        $isi = "BT\n/F1 30 Tf\n80 480 Td\n";
        foreach ($baris as $indeks => $teks) {
            $aman = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $teks);
            $isi .= ($indeks === 1 ? "/F1 18 Tf\n" : '').'('.$aman.") Tj\n0 -36 Td\n";
        }
        $isi .= "ET\n";

        $objek = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 842 595] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
            '<< /Length '.strlen($isi)." >>\nstream\n".$isi.'endstream',
        ];

        $pdf = "%PDF-1.4\n";
        $offset = [];
        foreach ($objek as $nomor => $badan) {
            $offset[] = strlen($pdf);
            $pdf .= ($nomor + 1)." 0 obj\n".$badan."\nendobj\n";
        }

        $xref = strlen($pdf);
        $pdf .= 'xref'."\n0 ".(count($objek) + 1)."\n0000000000 65535 f \n";
        foreach ($offset as $posisi) {
            $pdf .= sprintf("%010d 00000 n \n", $posisi);
        }

        return $pdf.'trailer'."\n<< /Size ".(count($objek) + 1)." /Root 1 0 R >>\nstartxref\n".$xref."\n%%EOF\n";
    }
}
