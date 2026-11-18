<x-guest-layout title="Reset Kata Sandi - siKarir UPT BLK Jember">
    <x-auth-shell
        eyebrow="Kata Sandi Baru"
        title="Reset Kata Sandi"
        description="Buat kata sandi baru untuk akun Anda. Gunakan kombinasi yang kuat dan mudah Anda ingat."
        hero-title="Amankan Akun Anda"
        hero-description="Kata sandi yang kuat melindungi data pelatihan, presensi, dan sertifikat digital Anda."
        icon="lock-keyhole"
    >
        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <x-ui.field data-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                <x-ui.field-label for="email">Alamat Email</x-ui.field-label>
                <x-ui.input
                    id="email"
                    name="email"
                    type="email"
                    :value="old('email', $request->email)"
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

            <div class="grid gap-4 sm:grid-cols-2">
                <x-ui.field data-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
                    <x-ui.field-label for="password">Kata Sandi Baru</x-ui.field-label>
                    <x-ui.input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                    >
                        <x-slot:leading>
                            <x-lucide-lock />
                        </x-slot:leading>
                    </x-ui.input>
                    <x-ui.field-error :messages="$errors->get('password')" />
                </x-ui.field>

                <x-ui.field data-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}">
                    <x-ui.field-label for="password_confirmation">Konfirmasi Kata Sandi</x-ui.field-label>
                    <x-ui.input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="Ulangi kata sandi"
                    >
                        <x-slot:leading>
                            <x-lucide-shield-check />
                        </x-slot:leading>
                    </x-ui.input>
                    <x-ui.field-error :messages="$errors->get('password_confirmation')" />
                </x-ui.field>
            </div>

            <x-ui.button type="submit" size="lg" class="group mt-2 w-full">
                Simpan Kata Sandi Baru
                <x-lucide-arrow-right class="transition-transform group-hover:translate-x-0.5" />
            </x-ui.button>
        </form>

        <x-slot:links>
            <div class="rounded-xl border border-border bg-muted/40 px-4 py-3 text-center text-xs font-medium text-muted-foreground">
                Sudah selesai mengatur ulang?
                <a href="{{ route('login') }}" class="inline-flex items-center gap-0.5 font-bold text-primary hover:underline">
                    Masuk ke Akun
                    <x-lucide-arrow-up-right class="size-3.5" />
                </a>
            </div>
        </x-slot:links>
    </x-auth-shell>
</x-guest-layout>
