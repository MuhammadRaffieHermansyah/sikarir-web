<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-xl shadow p-6 text-white flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold">Selamat Datang di SIKARIR</h3>
                    <p class="text-indigo-100 text-sm mt-1">Sistem Informasi Karir & Pelatihan BLK (Balai Latihan Kerja)</p>
                </div>
                <a href="{{ url('/docs') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold text-sm rounded-lg shadow hover:bg-indigo-50 transition">
                    Buka Swagger API Docs ↗
                </a>
            </div>

            <!-- Grid Menu -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Mitra -->
                <a href="{{ route('mitras.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group">
                    <div class="text-sm font-semibold uppercase tracking-wider text-indigo-600 mb-1">Mitra</div>
                    <div class="text-lg font-bold text-gray-900 group-hover:text-indigo-600">Kelola Mitra Perusahaan</div>
                    <p class="text-sm text-gray-500 mt-2">Daftar, tambah, dan kelola data perusahaan mitra kerja sama.</p>
                </a>

                <!-- Peserta -->
                <a href="{{ route('pesertas.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group">
                    <div class="text-sm font-semibold uppercase tracking-wider text-emerald-600 mb-1">Peserta</div>
                    <div class="text-lg font-bold text-gray-900 group-hover:text-emerald-600">Kelola Data Peserta</div>
                    <p class="text-sm text-gray-500 mt-2">Data pribadi, NIK, kontak, dan riwayat peserta pelatihan.</p>
                </a>

                <!-- Admin BLK -->
                <a href="{{ route('admin-blk.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group">
                    <div class="text-sm font-semibold uppercase tracking-wider text-blue-600 mb-1">Admin BLK</div>
                    <div class="text-lg font-bold text-gray-900 group-hover:text-blue-600">Admin & Instruktur BLK</div>
                    <p class="text-sm text-gray-500 mt-2">Kelola akun dan penugasan staf administrator BLK.</p>
                </a>

                <!-- Lowongan -->
                <a href="{{ route('lowongan.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group">
                    <div class="text-sm font-semibold uppercase tracking-wider text-purple-600 mb-1">Lowongan</div>
                    <div class="text-lg font-bold text-gray-900 group-hover:text-purple-600">Lowongan Pekerjaan</div>
                    <p class="text-sm text-gray-500 mt-2">Publikasi dan kelola info lowongan kerja dari mitra.</p>
                </a>

                <!-- Pelatihan -->
                <a href="{{ route('pelatihan.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group">
                    <div class="text-sm font-semibold uppercase tracking-wider text-teal-600 mb-1">Program Pelatihan</div>
                    <div class="text-lg font-bold text-gray-900 group-hover:text-teal-600">Daftar Program Pelatihan</div>
                    <p class="text-sm text-gray-500 mt-2">Program kejuruan dan pelatihan vokasi BLK.</p>
                </a>

                <!-- Jadwal -->
                <a href="{{ route('jadwal-pelatihan.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group">
                    <div class="text-sm font-semibold uppercase tracking-wider text-amber-600 mb-1">Jadwal Pelatihan</div>
                    <div class="text-lg font-bold text-gray-900 group-hover:text-amber-600">Jadwal & Kuota</div>
                    <p class="text-sm text-gray-500 mt-2">Atur tanggal mulai, selesai, kuota, dan status batch.</p>
                </a>

                <!-- Kelas -->
                <a href="{{ route('kelas-pelatihan.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group">
                    <div class="text-sm font-semibold uppercase tracking-wider text-cyan-600 mb-1">Kelas</div>
                    <div class="text-lg font-bold text-gray-900 group-hover:text-cyan-600">Pendaftaran Peserta Kelas</div>
                    <p class="text-sm text-gray-500 mt-2">Kelola penempatan peserta ke dalam kelas pelatihan.</p>
                </a>

                <!-- Absensi -->
                <a href="{{ route('absen.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group">
                    <div class="text-sm font-semibold uppercase tracking-wider text-rose-600 mb-1">Absensi</div>
                    <div class="text-lg font-bold text-gray-900 group-hover:text-rose-600">Presensi Peserta</div>
                    <p class="text-sm text-gray-500 mt-2">Pencatatan hadir, izin, sakit, dan alpa peserta.</p>
                </a>

                <!-- Sertifikat -->
                <a href="{{ route('sertifikat.index') }}" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group">
                    <div class="text-sm font-semibold uppercase tracking-wider text-yellow-600 mb-1">Sertifikat</div>
                    <div class="text-lg font-bold text-gray-900 group-hover:text-yellow-600">Penerbitan Sertifikat</div>
                    <p class="text-sm text-gray-500 mt-2">Nomor sertifikat, tanggal terbit, dan file sertifikat digital.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
