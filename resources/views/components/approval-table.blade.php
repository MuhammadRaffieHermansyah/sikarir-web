<x-ui.card variant="sectioned" class="p-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <x-ui.card-title class="text-sm">Jurnal Harian Magang Butuh Approval</x-ui.card-title>
            <x-ui.badge tone="warning" size="sm">12 Menunggu</x-ui.badge>
        </div>
        <x-ui.button variant="link" href="#" class="text-xs">Buka Semua Jurnal</x-ui.button>
    </div>

    <x-ui.table>
        <x-ui.table-header>
            <x-ui.table-row>
                <x-ui.table-head>Peserta Magang</x-ui.table-head>
                <x-ui.table-head>Program & Mitra Industri</x-ui.table-head>
                <x-ui.table-head>Waktu Log</x-ui.table-head>
                <x-ui.table-head>Ringkasan Aktivitas</x-ui.table-head>
                <x-ui.table-head>Status</x-ui.table-head>
            </x-ui.table-row>
        </x-ui.table-header>
        <x-ui.table-body>
            @foreach ([
                ['Ahmad Fauzi', '2024-MTR-018', 'Teknik Mekatronika', 'PT Astra Honda Motor', 'Hari ini, 08:15', 'Shift Pagi (Line 4)', 'Kalibrasi sensor...', 'warning', 'Menunggu Review'],
                ['Siti Nurhaliza', '2024-DKV-042', 'Desain Komunikasi Visual', 'Telkom Digital Studio', 'Hari ini, 09:00', 'Remote / Hybrid', 'Penyelesaian aset UI...', 'warning', 'Menunggu Review'],
                ['Rizky Ramadhan', '2024-TKJ-009', 'Teknisi Jaringan & Fiber', 'PT Telkom Indonesia', 'Kemarin, 17:40', 'ODC Hub Wilayah 2', 'Splicing kabel optik 24-core', 'success', 'Disetujui'],
                ['Maya Anggraini', '2024-ADM-031', 'Administrasi Perkantoran', 'Bank Mandiri KCP Vokasi', 'Kemarin, 16:30', 'Operasional Cabang', 'Rekonsiliasi berkas...', 'danger', 'Perlu Revisi'],
            ] as [$nama, $nis, $program, $mitra, $waktu, $shift, $aktivitas, $tone, $status])
                <x-ui.table-row>
                    <x-ui.table-cell>
                        <div class="flex items-center gap-2.5">
                            <x-ui.avatar class="size-8">
                                <x-ui.avatar-fallback class="bg-muted text-[10px] font-bold">
                                    {{ mb_substr($nama, 0, 1) }}
                                </x-ui.avatar-fallback>
                            </x-ui.avatar>
                            <div>
                                <div class="font-semibold text-foreground">{{ $nama }}</div>
                                <div class="text-[10px] text-muted-foreground">NIS. {{ $nis }}</div>
                            </div>
                        </div>
                    </x-ui.table-cell>
                    <x-ui.table-cell>
                        <div class="font-medium text-foreground">{{ $program }}</div>
                        <div class="flex items-center gap-1 text-[10px] text-muted-foreground">
                            <x-lucide-building-2 class="size-3" /> {{ $mitra }}
                        </div>
                    </x-ui.table-cell>
                    <x-ui.table-cell>
                        <div class="font-medium text-foreground">{{ $waktu }}</div>
                        <div class="text-[10px] text-muted-foreground">{{ $shift }}</div>
                    </x-ui.table-cell>
                    <x-ui.table-cell class="max-w-[150px] truncate">{{ $aktivitas }}</x-ui.table-cell>
                    <x-ui.table-cell>
                        <x-ui.badge :tone="$tone" size="sm">{{ $status }}</x-ui.badge>
                    </x-ui.table-cell>
                </x-ui.table-row>
            @endforeach
        </x-ui.table-body>
    </x-ui.table>
</x-ui.card>
