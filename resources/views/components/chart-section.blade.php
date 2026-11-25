@php
    $hariIndonesia = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat'];
    $senin = now()->startOfWeek();

    $perHari = \App\Models\Absen::query()
        ->whereBetween('tanggal', [$senin->toDateString(), $senin->copy()->addDays(4)->toDateString()])
        ->selectRaw("tanggal, COUNT(*) AS total, SUM(CASE WHEN status_kehadiran = 'hadir' THEN 1 ELSE 0 END) AS hadir")
        ->groupBy('tanggal')
        ->get()
        ->keyBy(fn ($row) => $row->tanggal->toDateString());

    $tren = collect($hariIndonesia)->map(function (string $nama, int $urutan) use ($senin, $perHari) {
        $row = $perHari->get($senin->copy()->addDays($urutan - 1)->toDateString());
        $total = (int) ($row->total ?? 0);
        $hadir = (int) ($row->hadir ?? 0);

        return [
            'hari' => $nama,
            'total' => $total,
            'persen' => $total > 0 ? (int) round($hadir / $total * 100) : 0,
        ];
    })->values();

    $totalMingguIni = (int) $perHari->sum('total');
    $hadirMingguIni = (int) $perHari->sum('hadir');
    $rataKehadiran = $totalMingguIni > 0 ? round($hadirMingguIni / $totalMingguIni * 100, 1) : 0;

    $hariIni = \App\Models\Absen::query()
        ->where('tanggal', today()->toDateString())
        ->selectRaw("COUNT(*) AS total,
            SUM(CASE WHEN status_kehadiran = 'hadir' THEN 1 ELSE 0 END) AS hadir,
            SUM(CASE WHEN status_kehadiran IN ('izin', 'sakit') THEN 1 ELSE 0 END) AS izin_sakit,
            SUM(CASE WHEN status_kehadiran IN ('alpha', 'alpa') THEN 1 ELSE 0 END) AS alpha")
        ->first();
    $totalHariIni = (int) ($hariIni->total ?? 0);
    $hadirHariIni = (int) ($hariIni->hadir ?? 0);
    $izinSakitHariIni = (int) ($hariIni->izin_sakit ?? 0);
    $alphaHariIni = (int) ($hariIni->alpha ?? 0);
    $persenHariIni = $totalHariIni > 0 ? round($hadirHariIni / $totalHariIni * 100, 1) : 0;
@endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <x-ui.card variant="sectioned" class="lg:col-span-2">
        <x-ui.card-header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <x-ui.card-title class="text-base">Tren Kehadiran Minggu Ini</x-ui.card-title>
                    <x-ui.card-description>Persentase peserta hadir per hari kerja berdasarkan data presensi.</x-ui.card-description>
                </div>
                <div class="flex items-center gap-4 text-xs text-muted-foreground">
                    <span class="flex items-center gap-1.5"><span class="size-3 rounded-sm bg-primary"></span> Hadir</span>
                </div>
            </div>
        </x-ui.card-header>

        <x-ui.card-content>
            <div class="flex h-44 items-end justify-between gap-4 border-b border-border px-4 pb-2 pt-6">
                @foreach ($tren as $hari)
                    <div class="flex h-full flex-1 flex-col items-center justify-end gap-1">
                        <span class="text-[10px] text-muted-foreground">{{ $hari['total'] > 0 ? $hari['persen'].'%' : '-' }}</span>
                        <div class="flex h-[85%] w-full max-w-10 items-end">
                            <div class="w-full rounded-t-sm bg-primary" style="height: {{ $hari['persen'] }}%"></div>
                        </div>
                        <span class="text-xs font-medium text-muted-foreground">{{ $hari['hari'] }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 grid grid-cols-1 gap-2 text-xs sm:grid-cols-3">
                <x-ui.item variant="muted" size="sm">
                    <x-lucide-circle-check class="size-4 text-success" />
                    <x-ui.item-content>
                        <x-ui.item-description>Rata-rata Kehadiran</x-ui.item-description>
                        <x-ui.item-title class="text-xs">{{ $totalMingguIni > 0 ? $rataKehadiran.'%' : 'Belum ada data' }}</x-ui.item-title>
                    </x-ui.item-content>
                </x-ui.item>
                <x-ui.item variant="muted" size="sm">
                    <x-lucide-file-check class="size-4 text-success" />
                    <x-ui.item-content>
                        <x-ui.item-description>Presensi Hadir</x-ui.item-description>
                        <x-ui.item-title class="text-xs">{{ number_format($hadirMingguIni) }} dari {{ number_format($totalMingguIni) }}</x-ui.item-title>
                    </x-ui.item-content>
                </x-ui.item>
                <x-ui.item variant="muted" size="sm">
                    <x-lucide-calendar class="size-4 text-success" />
                    <x-ui.item-content>
                        <x-ui.item-description>Batch Berlangsung</x-ui.item-description>
                        <x-ui.item-title class="text-xs">{{ number_format(\App\Models\JadwalPelatihan::where('status', 'berlangsung')->count()) }} batch</x-ui.item-title>
                    </x-ui.item-content>
                </x-ui.item>
            </div>
        </x-ui.card-content>
    </x-ui.card>

    <x-ui.card variant="sectioned">
        <x-ui.card-header>
            <div class="flex items-center justify-between">
                <x-ui.card-title class="flex items-center gap-2 text-base">
                    <span class="size-2 rounded-full bg-success"></span> Presensi Hari Ini
                </x-ui.card-title>
                <span class="text-[10px] text-muted-foreground">Per {{ now()->format('H:i') }} WIB</span>
            </div>
        </x-ui.card-header>

        <x-ui.card-content class="flex flex-col items-center gap-6">
            <x-ui.progress circular :value="$persenHariIni" :size="144" :thickness="12" show-value />

            <div class="grid w-full grid-cols-3 gap-2 rounded-lg bg-muted p-3 text-center text-xs">
                <div>
                    <div class="text-[10px] text-muted-foreground">Hadir</div>
                    <div class="font-bold text-foreground">{{ $hadirHariIni }}</div>
                </div>
                <div class="border-x border-border">
                    <div class="text-[10px] text-muted-foreground">Izin / Sakit</div>
                    <div class="font-bold text-foreground">{{ $izinSakitHariIni }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-muted-foreground">Alpha</div>
                    <div class="font-bold text-foreground">{{ $alphaHariIni }}</div>
                </div>
            </div>

            <x-ui.button variant="link" href="{{ route('absen.rekap', ['tanggal_mulai' => today()->toDateString(), 'tanggal_selesai' => today()->toDateString()]) }}" class="text-xs">
                Lihat Rekap Presensi Hari Ini
                <x-lucide-arrow-right />
            </x-ui.button>
        </x-ui.card-content>
    </x-ui.card>
</div>
