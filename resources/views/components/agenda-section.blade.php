<x-ui.card variant="sectioned" class="p-4">
    <div class="flex items-center justify-between">
        <x-ui.card-title class="text-sm">Agenda & Tenggat BLK</x-ui.card-title>
        <x-lucide-calendar class="size-4 text-muted-foreground" />
    </div>

    <div class="space-y-2">
        <x-ui.item size="sm" class="border-border">
            <div class="flex min-w-9 flex-col items-center rounded-md bg-primary px-1 py-1 text-center text-primary-foreground">
                <span class="text-[9px] font-bold uppercase tracking-wider">JUL</span>
                <span class="text-sm font-black leading-none">28</span>
            </div>
            <x-ui.item-content>
                <x-ui.item-title class="text-xs">Uji Sertifikasi BNSP Gelombang II</x-ui.item-title>
                <x-ui.item-description class="text-[10px]">Ruang Lab Uji BLK Pusat • 120 Peserta</x-ui.item-description>
                <x-ui.badge tone="danger" size="sm" class="mt-1">Tersisa 4 Hari</x-ui.badge>
            </x-ui.item-content>
        </x-ui.item>

        <x-ui.item size="sm" class="border-border">
            <div class="flex min-w-9 flex-col items-center rounded-md bg-muted px-1 py-1 text-center text-muted-foreground">
                <span class="text-[9px] font-bold uppercase tracking-wider">AGS</span>
                <span class="text-sm font-black leading-none">05</span>
            </div>
            <x-ui.item-content>
                <x-ui.item-title class="text-xs">Penutupan Laporan Akhir Magang</x-ui.item-title>
                <x-ui.item-description class="text-[10px]">Semester Ganjil 2024/2025 • Batas unggah nilai industri</x-ui.item-description>
            </x-ui.item-content>
        </x-ui.item>
    </div>
</x-ui.card>
