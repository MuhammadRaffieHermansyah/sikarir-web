@props(['stats' => []])

@php
    $totalPeserta = $stats['peserta'] ?? 0;
    $totalInstruktur = $stats['instruktur'] ?? 0;
    $totalMitra = $stats['mitra'] ?? 0;
    $totalPelatihan = $stats['pelatihan'] ?? 0;
    $totalSertifikat = $stats['sertifikat'] ?? 0;
@endphp

<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
    <x-ui.stat
        label="Total Pengguna Terdaftar"
        :value="number_format($totalPeserta + $totalInstruktur + $totalMitra)"
        icon="users-2"
        :caption="number_format($totalPeserta).' peserta, '.number_format($totalInstruktur).' instruktur, '.number_format($totalMitra).' DU/DI'"
    >
        <x-slot:trailing>
            <x-ui.badge tone="success" size="sm">Data aktif</x-ui.badge>
        </x-slot:trailing>
    </x-ui.stat>

    <x-ui.stat
        label="Program Pelatihan Vokasi"
        :value="number_format($totalPelatihan)"
        icon="graduation-cap"
        caption="Program kejuruan terdaftar"
    >
        <x-slot:trailing>
            <x-ui.badge variant="secondary" size="sm">Kejuruan</x-ui.badge>
        </x-slot:trailing>
    </x-ui.stat>

    <x-ui.stat
        label="Sertifikat BNSP / BLK"
        :value="number_format($totalSertifikat)"
        icon="award"
        caption="Sertifikat kompetensi diterbitkan"
    >
    </x-ui.stat>
</div>

@isset($stats['mitra_menunggu'])
    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3" data-testid="ringkasan-tindak-lanjut">
        @foreach ([
            ['label' => 'Mitra Menunggu Verifikasi', 'value' => $stats['mitra_menunggu'], 'icon' => 'building-2', 'caption' => 'Periksa dokumen lalu verifikasi', 'route' => route('mitras.index', ['verifikasi' => 'menunggu']), 'perlu' => $stats['mitra_menunggu'] > 0],
            ['label' => 'Pelatihan Berjalan', 'value' => $stats['pelatihan_berjalan'], 'icon' => 'calendar-check', 'caption' => 'Jadwal berstatus berlangsung', 'route' => route('jadwal-pelatihan.index', ['status' => 'berlangsung']), 'perlu' => false],
            ['label' => 'Lamaran Masuk', 'value' => $stats['lamaran_masuk'], 'icon' => 'briefcase-business', 'caption' => number_format($stats['lamaran_minggu_ini']).' dalam 7 hari terakhir', 'route' => route('lowongan.index'), 'perlu' => false],
        ] as $kartu)
            <a href="{{ $kartu['route'] }}" class="block rounded-xl outline-none transition-shadow hover:shadow-md focus-visible:ring-[3px] focus-visible:ring-ring/50">
                <x-ui.stat :label="$kartu['label']" :value="number_format($kartu['value'])" :icon="$kartu['icon']" :caption="$kartu['caption']" class="h-full">
                    @if ($kartu['perlu'])
                        <x-slot:trailing>
                            <x-ui.badge tone="warning" size="sm">Perlu ditinjau</x-ui.badge>
                        </x-slot:trailing>
                    @endif
                </x-ui.stat>
            </a>
        @endforeach
    </div>
@endisset
