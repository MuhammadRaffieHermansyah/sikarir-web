<x-ui.card variant="sectioned" class="p-4">
    <div class="flex items-center justify-between">
        <div>
            <x-ui.card-title class="text-sm">Aksi Cepat Administrator</x-ui.card-title>
            <x-ui.card-description class="text-[11px]">Jalankan instruksi rutin tanpa meninggalkan layar.</x-ui.card-description>
        </div>
        <x-ui.badge variant="secondary" size="sm">Rutin</x-ui.badge>
    </div>

    <div class="space-y-1">
        <x-ui.item href="#" size="sm" class="hover:bg-accent/50">
            <x-lucide-user-plus class="size-4 text-muted-foreground" />
            <x-ui.item-content><x-ui.item-title class="text-xs">Tambah User / Siswa Baru</x-ui.item-title></x-ui.item-content>
            <x-lucide-chevron-right class="ms-auto size-4 text-muted-foreground" />
        </x-ui.item>

        <x-ui.item href="{{ route('mitras.create') }}" size="sm" class="hover:bg-accent/50">
            <x-lucide-building class="size-4 text-muted-foreground" />
            <x-ui.item-content><x-ui.item-title class="text-xs">Registrasi Mitra Industri Baru</x-ui.item-title></x-ui.item-content>
            <x-lucide-chevron-right class="ms-auto size-4 text-muted-foreground" />
        </x-ui.item>

        <x-ui.item href="{{ route('absen.rekap') }}" size="sm" variant="muted">
            <x-lucide-circle-check-big class="size-4 text-success" />
            <x-ui.item-content><x-ui.item-title class="text-xs">Rekap Presensi Hari Ini</x-ui.item-title></x-ui.item-content>
            <x-ui.badge tone="success" size="sm">12</x-ui.badge>
        </x-ui.item>

        <x-ui.item href="{{ route('sertifikat.index') }}" size="sm" class="hover:bg-accent/50">
            <x-lucide-printer class="size-4 text-muted-foreground" />
            <x-ui.item-content><x-ui.item-title class="text-xs">Cetak Sertifikat Kompetensi Massal</x-ui.item-title></x-ui.item-content>
            <x-lucide-chevron-right class="ms-auto size-4 text-muted-foreground" />
        </x-ui.item>
    </div>
</x-ui.card>
