<x-guest-layout title="Verifikasi Email - siKarir UPT BLK Jember">
    <x-auth-shell
        eyebrow="Verifikasi Email"
        title="Cek Kotak Masuk Anda"
        description="Terima kasih telah mendaftar! Sebelum memulai, verifikasi alamat email Anda dengan mengklik tautan yang baru kami kirimkan."
        hero-title="Satu Langkah Lagi"
        hero-description="Verifikasi email memastikan notifikasi pelatihan, sertifikat, dan informasi karir sampai ke alamat yang benar."
        icon="mail-check"
    >
        @if (session('status') == 'verification-link-sent')
            <x-ui.alert tone="success" class="mb-4">
                <x-lucide-circle-check-big />
                <x-ui.alert-description>
                    Tautan verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat mendaftar.
                </x-ui.alert-description>
            </x-ui.alert>
        @endif

        <x-ui.alert tone="neutral">
            <x-lucide-mail />
            <x-ui.alert-description>
                Tidak menerima email? Periksa folder spam atau kirim ulang tautan verifikasi di bawah ini.
            </x-ui.alert-description>
        </x-ui.alert>

        <x-slot:links>
            <div class="space-y-2">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <x-ui.button type="submit" size="lg" class="group w-full">
                        Kirim Ulang Email Verifikasi
                        <x-lucide-send class="transition-transform group-hover:translate-x-0.5" />
                    </x-ui.button>
                </form>

                <form method="POST" action="{{ route('logout') }}" data-confirm-action="logout">
                    @csrf

                    <x-ui.button type="submit" variant="outline" size="lg" class="w-full">
                        <x-lucide-log-out />
                        Keluar dari Akun
                    </x-ui.button>
                </form>
            </div>
        </x-slot:links>
    </x-auth-shell>
</x-guest-layout>
