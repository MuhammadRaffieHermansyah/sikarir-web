<x-guest-layout title="Masuk - siKarir UPT BLK Jember">
    <x-auth-shell
        eyebrow="Portal Masuk Resmi"
        title="Masuk ke Akun"
        description="Silakan masukkan email dan kata sandi Anda untuk mengakses portal administrator."
        hero-title="Sistem Informasi Karir & Vokasi"
        hero-description="Portal terpadu pengelolaan pelatihan kerja, presensi peserta, dan penerbitan sertifikat digital."
        icon="graduation-cap"
    >
        @if (session('status'))
            <x-ui.alert tone="success" class="mb-4">
                <x-lucide-circle-check-big />
                <x-ui.alert-description>{{ session('status') }}</x-ui.alert-description>
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <x-ui.field data-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                <x-ui.field-label for="email">Alamat Email</x-ui.field-label>
                <x-ui.input
                    id="email"
                    name="email"
                    type="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="admin@blk.go.id"
                >
                    <x-slot:leading>
                        <x-lucide-mail />
                    </x-slot:leading>
                </x-ui.input>
                <x-ui.field-error :messages="$errors->get('email')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
                <div class="flex items-center justify-between gap-2">
                    <x-ui.field-label for="password">Kata Sandi</x-ui.field-label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-primary hover:underline">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <x-ui.input
                    id="password"
                    name="password"
                    type="password"
                    required
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
                Masuk ke Dashboard
                <x-lucide-arrow-right class="transition-transform group-hover:translate-x-0.5" />
            </x-ui.button>
        </form>

        <x-slot:links>
            @if (Route::has('register'))
                <div class="rounded-xl border border-border bg-muted/40 px-4 py-3 text-center text-xs font-medium text-muted-foreground">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-0.5 font-bold text-primary hover:underline">
                        Daftar Akun Baru
                        <x-lucide-arrow-up-right class="size-3.5" />
                    </a>
                </div>
            @endif
        </x-slot:links>
    </x-auth-shell>
</x-guest-layout>
