<section>
    <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
            <x-ui.card-title class="text-base font-bold">Perbarui Kata Sandi</x-ui.card-title>
            <x-ui.card-description>Gunakan kata sandi yang panjang dan sulit ditebak agar akun tetap aman.</x-ui.card-description>
        </x-ui.card-header>

        <x-ui.card-content>
            <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('put')

                <x-ui.field data-invalid="{{ $errors->updatePassword->has('current_password') ? 'true' : 'false' }}">
                    <x-ui.field-label for="update_password_current_password">Kata Sandi Saat Ini</x-ui.field-label>
                    <x-ui.input
                        id="update_password_current_password"
                        name="current_password"
                        type="password"
                        autocomplete="current-password"
                        placeholder="Masukkan kata sandi saat ini"
                    >
                        <x-slot:leading>
                            <x-lucide-lock />
                        </x-slot:leading>
                    </x-ui.input>
                    <x-ui.field-error :messages="$errors->updatePassword->get('current_password')" />
                </x-ui.field>

                <div class="grid gap-5 sm:grid-cols-2">
                    <x-ui.field data-invalid="{{ $errors->updatePassword->has('password') ? 'true' : 'false' }}">
                        <x-ui.field-label for="update_password_password">Kata Sandi Baru</x-ui.field-label>
                        <x-ui.input
                            id="update_password_password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                        >
                            <x-slot:leading>
                                <x-lucide-key-round />
                            </x-slot:leading>
                        </x-ui.input>
                        <x-ui.field-error :messages="$errors->updatePassword->get('password')" />
                    </x-ui.field>

                    <x-ui.field data-invalid="{{ $errors->updatePassword->has('password_confirmation') ? 'true' : 'false' }}">
                        <x-ui.field-label for="update_password_password_confirmation">Konfirmasi Kata Sandi</x-ui.field-label>
                        <x-ui.input
                            id="update_password_password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Ulangi kata sandi baru"
                        >
                            <x-slot:leading>
                                <x-lucide-shield-check />
                            </x-slot:leading>
                        </x-ui.input>
                        <x-ui.field-error :messages="$errors->updatePassword->get('password_confirmation')" />
                    </x-ui.field>
                </div>

                <div class="flex flex-wrap items-center gap-3 border-t border-border pt-5">
                    <x-ui.button type="submit">
                        <x-lucide-key-round />
                        Perbarui Kata Sandi
                    </x-ui.button>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2500)"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-success"
                        >
                            <x-lucide-circle-check-big class="size-3.5" />
                            Kata sandi berhasil diperbarui.
                        </p>
                    @endif
                </div>
            </form>
        </x-ui.card-content>
    </x-ui.card>
</section>
