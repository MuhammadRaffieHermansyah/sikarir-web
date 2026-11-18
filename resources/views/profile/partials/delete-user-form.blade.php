<section>
    <x-ui.card variant="sectioned" class="border-destructive/30">
        <x-ui.card-header>
            <x-ui.card-title class="text-base font-bold text-destructive">Hapus Akun</x-ui.card-title>
            <x-ui.card-description>
                Setelah akun dihapus, seluruh data dan sumber daya di dalamnya akan terhapus permanen. Unduh terlebih dahulu data yang ingin Anda simpan.
            </x-ui.card-description>
        </x-ui.card-header>

        <x-ui.card-content>
            <x-ui.button
                variant="destructive"
                size="sm"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            >
                <x-lucide-trash-2 />
                Hapus Akun
            </x-ui.button>
        </x-ui.card-content>
    </x-ui.card>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
            @csrf
            @method('delete')

            <x-ui.dialog-header>
                <x-ui.dialog-title>Apakah Anda yakin ingin menghapus akun?</x-ui.dialog-title>
                <x-ui.dialog-description>
                    Tindakan ini permanen. Masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun beserta seluruh datanya.
                </x-ui.dialog-description>
            </x-ui.dialog-header>

            @if ($errors->userDeletion->has('password'))
                <x-ui.alert tone="danger">
                    <x-lucide-circle-alert />
                    <x-ui.alert-description>{{ $errors->userDeletion->first('password') }}</x-ui.alert-description>
                </x-ui.alert>
            @endif

            <x-ui.field data-invalid="{{ $errors->userDeletion->has('password') ? 'true' : 'false' }}">
                <x-ui.field-label for="password" class="sr-only">Kata Sandi</x-ui.field-label>
                <x-ui.input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Masukkan kata sandi Anda"
                    autocomplete="current-password"
                >
                    <x-slot:leading>
                        <x-lucide-lock />
                    </x-slot:leading>
                </x-ui.input>
            </x-ui.field>

            <x-ui.dialog-footer>
                <x-ui.button type="button" variant="outline" x-on:click="$dispatch('close')">
                    Batal
                </x-ui.button>

                <x-ui.button type="submit" variant="destructive">
                    <x-lucide-trash-2 />
                    Hapus Akun Permanen
                </x-ui.button>
            </x-ui.dialog-footer>
        </form>
    </x-modal>
</section>
