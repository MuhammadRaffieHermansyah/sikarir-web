<x-guest-layout title="Konfirmasi Kata Sandi - siKarir UPT BLK Jember">
    <x-auth-shell
        eyebrow="Area Aman"
        title="Konfirmasi Kata Sandi"
        description="Ini adalah area aman aplikasi. Silakan konfirmasi kata sandi Anda sebelum melanjutkan."
        hero-title="Verifikasi Keamanan"
        hero-description="Konfirmasi ulang kata sandi untuk memastikan hanya Anda yang dapat mengakses area terbatas ini."
        icon="shield-check"
    >
        <x-ui.alert tone="info" class="mb-4">
            <x-lucide-shield-check />
            <x-ui.alert-description>
                Sesi Anda memerlukan verifikasi tambahan sebelum melanjutkan ke halaman berikutnya.
            </x-ui.alert-description>
        </x-ui.alert>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <x-ui.field data-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
                <x-ui.field-label for="password">Kata Sandi</x-ui.field-label>
                <x-ui.input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autofocus
                    autocomplete="current-password"
                    placeholder="Masukkan kata sandi Anda"
                >
                    <x-slot:leading>
                        <x-lucide-lock />
                    </x-slot:leading>
                </x-ui.input>
                <x-ui.field-error :messages="$errors->get('password')" />
            </x-ui.field>

            <x-ui.button type="submit" size="lg" class="group mt-2 w-full">
                Konfirmasi & Lanjutkan
                <x-lucide-arrow-right class="transition-transform group-hover:translate-x-0.5" />
            </x-ui.button>
        </form>
    </x-auth-shell>
</x-guest-layout>
