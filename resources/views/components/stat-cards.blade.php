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
