<x-guest-layout title="Daftar Akun - siKarir UPT BLK Jember">
    <x-auth-shell
        eyebrow="Pendaftaran Peserta"
        title="Daftar lewat aplikasi siKarir"
        description="Pendaftaran akun peserta, pendaftaran pelatihan, presensi, dan sertifikat dilakukan di aplikasi mobile siKarir."
        hero-title="Bergabung Bersama Kami"
        hero-description="Pasang aplikasi siKarir di HP Anda untuk mendaftar pelatihan vokasi, sertifikasi kompetensi, dan peluang karir."
        icon="smartphone"
    >
        <ol class="space-y-3" data-testid="langkah-daftar-aplikasi">
            @foreach ([
                'Pasang aplikasi siKarir di HP Android Anda.',
                'Pilih "Daftar", isi nama, email, dan kata sandi.',
                'Lengkapi profil, lalu pilih program pelatihan yang dibuka.',
            ] as $nomor => $langkah)
                <li class="flex items-start gap-3 rounded-xl border border-border bg-muted/40 px-4 py-3 text-sm">
                    <span class="grid size-6 shrink-0 place-items-center rounded-full bg-primary text-xs font-bold text-primary-foreground">{{ $nomor + 1 }}</span>
                    <span class="text-foreground">{{ $langkah }}</span>
                </li>
            @endforeach
        </ol>

        <x-ui.alert class="mt-4">
            <x-lucide-info />
            <x-ui.alert-description>Instruktur memakai akun yang dibuatkan admin BLK dan juga masuk lewat aplikasi.</x-ui.alert-description>
        </x-ui.alert>

        <x-slot:links>
            <div class="rounded-xl border border-border bg-muted/40 px-4 py-3 text-center text-xs font-medium text-muted-foreground">
                Perusahaan atau mitra industri?
                <a href="{{ route('register.mitra') }}" class="inline-flex items-center gap-0.5 font-bold text-primary hover:underline">
                    Daftar sebagai mitra
                    <x-lucide-arrow-up-right class="size-3.5" />
                </a>
            </div>
            <div class="text-center text-xs text-muted-foreground">
                Admin BLK atau mitra yang sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Masuk</a>
            </div>
        </x-slot:links>
    </x-auth-shell>
</x-guest-layout>
