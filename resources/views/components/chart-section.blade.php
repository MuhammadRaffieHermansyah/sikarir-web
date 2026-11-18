<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <x-ui.card variant="sectioned" class="lg:col-span-2">
        <x-ui.card-header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <x-ui.card-title class="text-base">Tren Aktivitas & Log Presensi</x-ui.card-title>
                    <x-ui.card-description>Tingkat kehadiran harian dan pengisian jurnal industri minggu berjalan.</x-ui.card-description>
                </div>
                <div class="flex items-center gap-4 text-xs text-muted-foreground">
                    <span class="flex items-center gap-1.5"><span class="size-3 rounded-sm bg-primary"></span> Presensi Masuk</span>
                    <span class="flex items-center gap-1.5"><span class="size-3 rounded-sm bg-chart-2"></span> Jurnal Terkirim</span>
                </div>
            </div>
        </x-ui.card-header>

        <x-ui.card-content>
            <div class="flex h-44 items-end justify-between gap-4 border-b border-border px-4 pb-2 pt-6">
                @foreach ([['Senin', 98, 92], ['Selasa', 97, 95], ['Rabu', 96, 90], ['Kamis', 98, 94], ['Jumat', 95, 88]] as [$day, $presensi, $jurnal])
                    <div class="flex h-full flex-1 flex-col items-center justify-end gap-1">
                        <span class="text-[10px] text-muted-foreground">{{ $presensi }}%</span>
                        <div class="flex h-[85%] w-full max-w-10 items-end gap-1">
                            <div class="h-[{{ $presensi }}%] w-1/2 rounded-t-sm bg-primary"></div>
                            <div class="h-[{{ $jurnal }}%] w-1/2 rounded-t-sm bg-chart-2"></div>
                        </div>
                        <span class="text-xs font-medium text-muted-foreground">{{ $day }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 grid grid-cols-1 gap-2 text-xs sm:grid-cols-3">
                <x-ui.item variant="muted" size="sm">
                    <x-lucide-circle-check class="size-4 text-success" />
                    <x-ui.item-content>
                        <x-ui.item-description>Rata-rata Presensi</x-ui.item-description>
                        <x-ui.item-title class="text-xs">96.8% Tepat Waktu</x-ui.item-title>
                    </x-ui.item-content>
                </x-ui.item>
                <x-ui.item variant="muted" size="sm">
                    <x-lucide-file-check class="size-4 text-success" />
                    <x-ui.item-content>
                        <x-ui.item-description>Log Jurnal Masuk</x-ui.item-description>
                        <x-ui.item-title class="text-xs">821 dari 865</x-ui.item-title>
                    </x-ui.item-content>
                </x-ui.item>
                <x-ui.item variant="muted" size="sm">
                    <x-lucide-clock class="size-4 text-success" />
                    <x-ui.item-content>
                        <x-ui.item-description>Total Jam Pelatihan</x-ui.item-description>
                        <x-ui.item-title class="text-xs">34,600 Jam</x-ui.item-title>
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
                <span class="text-[10px] text-muted-foreground">Per 09:30 WIB</span>
            </div>
        </x-ui.card-header>

        <x-ui.card-content class="flex flex-col items-center gap-6">
            <x-ui.progress circular :value="96.8" :size="144" :thickness="12" show-value />

            <div class="grid w-full grid-cols-3 gap-2 rounded-lg bg-muted p-3 text-center text-xs">
                <div>
                    <div class="text-[10px] text-muted-foreground">Terlambat</div>
                    <div class="font-bold text-foreground">18</div>
                </div>
                <div class="border-x border-border">
                    <div class="text-[10px] text-muted-foreground">Izin / Sakit</div>
                    <div class="font-bold text-foreground">9</div>
                </div>
                <div>
                    <div class="text-[10px] text-muted-foreground">Alpha</div>
                    <div class="font-bold text-foreground">0</div>
                </div>
            </div>

            <x-ui.button variant="link" href="#" class="text-xs">
                Lihat Detail Presensi Real-Time
                <x-lucide-arrow-right />
            </x-ui.button>
        </x-ui.card-content>
    </x-ui.card>
</div>
