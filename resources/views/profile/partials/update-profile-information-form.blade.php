<section>
    <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
            <x-ui.card-title class="text-base font-bold">Informasi Profil</x-ui.card-title>
            <x-ui.card-description>Perbarui nama dan alamat email yang digunakan pada akun Anda.</x-ui.card-description>
        </x-ui.card-header>

        <x-ui.card-content>
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('patch')

                <x-ui.field data-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">
                    <x-ui.field-label for="name">Nama Lengkap</x-ui.field-label>
                    <x-ui.input
                        id="name"
                        name="name"
                        type="text"
                        :value="old('name', $user->name)"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Masukkan nama lengkap"
                    >
                        <x-slot:leading>
                            <x-lucide-user />
                        </x-slot:leading>
                    </x-ui.input>
                    <x-ui.field-error :messages="$errors->get('name')" />
                </x-ui.field>

                <x-ui.field data-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                    <x-ui.field-label for="email">Alamat Email</x-ui.field-label>
                    <x-ui.input
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email', $user->email)"
                        required
                        autocomplete="username"
                        placeholder="nama@email.com"
                    >
                        <x-slot:leading>
                            <x-lucide-mail />
                        </x-slot:leading>
                    </x-ui.input>
                    <x-ui.field-error :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <x-ui.alert tone="warning" class="mt-1">
                            <x-lucide-triangle-alert />
                            <x-ui.alert-description>
                                Alamat email Anda belum diverifikasi.
                                <x-ui.button type="submit" form="send-verification" variant="link" size="xs" class="h-auto p-0 text-xs font-semibold">
                                    Kirim ulang email verifikasi.
                                </x-ui.button>
                            </x-ui.alert-description>
                        </x-ui.alert>
                    @endif

                    @if (session('status') === 'verification-link-sent')
                        <x-ui.alert tone="success" class="mt-1">
                            <x-lucide-circle-check-big />
                            <x-ui.alert-description>
                                Tautan verifikasi baru telah dikirim ke alamat email Anda.
                            </x-ui.alert-description>
                        </x-ui.alert>
                    @endif
                </x-ui.field>

                <div class="flex flex-wrap items-center gap-3 border-t border-border pt-5">
                    <x-ui.button type="submit">
                        <x-lucide-save />
                        Simpan Perubahan
                    </x-ui.button>

                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2500)"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-success"
                        >
                            <x-lucide-circle-check-big class="size-3.5" />
                            Perubahan tersimpan.
                        </p>
                    @endif
                </div>
            </form>
        </x-ui.card-content>
    </x-ui.card>
</section>
