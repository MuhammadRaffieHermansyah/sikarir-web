<x-guest-layout title="Lupa Kata Sandi - siKarir UPT BLK Jember">
    <x-auth-shell
        eyebrow="Pemulihan Akun"
        title="Lupa Kata Sandi?"
        description="Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda."
        hero-title="Pulihkan Akses Akun"
        hero-description="Jangan khawatir. Proses pemulihan hanya membutuhkan beberapa langkah untuk kembali mengakses portal."
        icon="key-round"
    >
        @if (session('status'))
            <x-ui.alert tone="success" class="mb-4">
                <x-lucide-circle-check-big />
                <x-ui.alert-description>{{ session('status') }}</x-ui.alert-description>
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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
                    placeholder="nama@email.com"
                >
                    <x-slot:leading>
                        <x-lucide-mail />
                    </x-slot:leading>
                </x-ui.input>
                <x-ui.field-error :messages="$errors->get('email')" />
            </x-ui.field>

            <x-ui.button type="submit" size="lg" class="group mt-2 w-full">
                Kirim Tautan Reset
                <x-lucide-send class="transition-transform group-hover:translate-x-0.5" />
            </x-ui.button>
        </form>

        <x-slot:links>
            <div class="rounded-xl border border-border bg-muted/40 px-4 py-3 text-center text-xs font-medium text-muted-foreground">
                Sudah ingat kata sandi Anda?
                <a href="{{ route('login') }}" class="inline-flex items-center gap-0.5 font-bold text-primary hover:underline">
                    Kembali ke Halaman Masuk
                    <x-lucide-arrow-up-right class="size-3.5" />
                </a>
            </div>
        </x-slot:links>
    </x-auth-shell>
</x-guest-layout>
