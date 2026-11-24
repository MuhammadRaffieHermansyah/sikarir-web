<x-guest-layout title="Daftar Mitra - siKarir UPT BLK Jember">
    <x-auth-shell
        eyebrow="Kemitraan Industri"
        title="Daftar sebagai Mitra"
        description="Kirim data perusahaan dan dokumen pendukung untuk ditinjau admin BLK."
        hero-title="Buka Peluang Bersama BLK"
        hero-description="Setelah diverifikasi, perusahaan dapat mengelola lowongan kerja di siKarir."
        icon="building-2"
    >
        <form method="POST" action="{{ route('register.mitra.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <x-ui.field data-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">
                <x-ui.field-label for="name">Nama Penanggung Jawab</x-ui.field-label>
                <x-ui.input id="name" name="name" type="text" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama PIC perusahaan">
                    <x-slot:leading><x-lucide-user /></x-slot:leading>
                </x-ui.input>
                <x-ui.field-error :messages="$errors->get('name')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('nama_perusahaan') ? 'true' : 'false' }}">
                <x-ui.field-label for="nama_perusahaan">Nama Perusahaan</x-ui.field-label>
                <x-ui.input id="nama_perusahaan" name="nama_perusahaan" type="text" :value="old('nama_perusahaan')" required placeholder="Contoh: PT Maju Bersama">
                    <x-slot:leading><x-lucide-building-2 /></x-slot:leading>
                </x-ui.input>
                <x-ui.field-error :messages="$errors->get('nama_perusahaan')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                <x-ui.field-label for="email">Alamat Email</x-ui.field-label>
                <x-ui.input id="email" name="email" type="email" :value="old('email')" required autocomplete="username" placeholder="hrd@perusahaan.com">
                    <x-slot:leading><x-lucide-mail /></x-slot:leading>
                </x-ui.input>
                <x-ui.field-error :messages="$errors->get('email')" />
            </x-ui.field>

            <div class="grid gap-4 sm:grid-cols-2">
                <x-ui.field data-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
                    <x-ui.field-label for="password">Kata Sandi</x-ui.field-label>
                    <x-ui.input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                        <x-slot:leading><x-lucide-lock /></x-slot:leading>
                    </x-ui.input>
                    <x-ui.field-error :messages="$errors->get('password')" />
                </x-ui.field>

                <x-ui.field data-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}">
                    <x-ui.field-label for="password_confirmation">Konfirmasi Kata Sandi</x-ui.field-label>
                    <x-ui.input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Ulangi kata sandi">
                        <x-slot:leading><x-lucide-shield-check /></x-slot:leading>
                    </x-ui.input>
                    <x-ui.field-error :messages="$errors->get('password_confirmation')" />
                </x-ui.field>
            </div>

            <x-ui.field data-invalid="{{ $errors->has('surat_legalitas') ? 'true' : 'false' }}">
                <x-ui.field-label for="surat_legalitas">Surat Legalitas Perusahaan</x-ui.field-label>
                <x-ui.input id="surat_legalitas" name="surat_legalitas" type="file" required accept=".pdf,.doc,.docx" />
                <x-ui.field-description>PDF, DOC, atau DOCX. Maksimal 2 MB.</x-ui.field-description>
                <x-ui.field-error :messages="$errors->get('surat_legalitas')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('surat_permohonan_kerjasama') ? 'true' : 'false' }}">
                <x-ui.field-label for="surat_permohonan_kerjasama">Surat Permohonan Kerja Sama</x-ui.field-label>
                <x-ui.input id="surat_permohonan_kerjasama" name="surat_permohonan_kerjasama" type="file" required accept=".pdf,.doc,.docx" />
                <x-ui.field-description>PDF, DOC, atau DOCX. Maksimal 2 MB.</x-ui.field-description>
                <x-ui.field-error :messages="$errors->get('surat_permohonan_kerjasama')" />
            </x-ui.field>

            <x-ui.alert tone="info">
                <x-lucide-clock-3 />
                <x-ui.alert-description>Setelah mendaftar, Anda bisa masuk dashboard, tetapi akses kelola lowongan baru aktif setelah verifikasi admin.</x-ui.alert-description>
            </x-ui.alert>

            <x-ui.button type="submit" size="lg" class="group mt-2 w-full">
                Kirim Pendaftaran Mitra
                <x-lucide-arrow-right class="transition-transform group-hover:translate-x-0.5" />
            </x-ui.button>
        </form>

        <x-slot:links>
            <div class="rounded-xl border border-border bg-muted/40 px-4 py-3 text-center text-xs font-medium text-muted-foreground">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Masuk Sekarang</a>
            </div>
        </x-slot:links>
    </x-auth-shell>
</x-guest-layout>
