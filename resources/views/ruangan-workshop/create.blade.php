@extends('layouts.app')

@section('title', 'Tambah Ruangan Workshop - BLK CONNECT')

@section('content')

    <!-- Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div>

            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">

                <a href="{{ route('admin-blk.index') }}"
                   class="hover:text-emerald-700 transition">
                    Beranda
                </a>

                <span>&gt;</span>

                <a href="{{ route('ruangan-workshop.index') }}"
                   class="hover:text-emerald-700 transition">
                    Ruangan Workshop
                </a>

                <span>&gt;</span>

                <span class="text-slate-600 font-medium">
                    Tambah Ruangan Workshop
                </span>

            </div>


            <h1 class="text-xl font-black text-slate-900 tracking-tight">
                Tambah Ruangan Workshop
            </h1>

            <p class="text-xs text-slate-500 mt-0.5">
                Daftarkan nama ruangan workshop.
            </p>

        </div>


        <div>

            <a href="{{ route('ruangan-workshop.index') }}"
               class="bg-white border border-slate-200 hover:bg-slate-50
                      text-slate-700 text-xs font-semibold px-3 py-2
                      rounded-lg flex items-center gap-1.5 shadow-sm transition">

                <i data-lucide="arrow-left" class="w-4 h-4"></i>

                Kembali ke Daftar

            </a>

        </div>

    </div>


    <!-- Error Validation -->
    @if($errors->any())

        <div class="bg-rose-50 border border-rose-200 text-rose-800
                    px-4 py-3 rounded-xl text-xs space-y-1 shadow-sm">

            <div class="font-bold flex items-center gap-1.5">

                <i data-lucide="alert-circle"
                   class="w-4 h-4 text-rose-600"></i>

                Mohon perbaiki beberapa kesalahan berikut:

            </div>


            <ul class="list-disc list-inside space-y-0.5
                       text-rose-700 pl-4">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- Form Layout -->
    <form action="{{ route('ruangan-workshop.store') }}"
          method="POST"
          class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        @csrf

        {{-- 
            Menyimpan asal halaman.
            Kalau datang dari Jadwal Pelatihan,
            nilainya akan menjadi "jadwal".
        --}}
        <input type="hidden"
               name="from"
               value="{{ request('from') }}">


        <!-- Main Form Fields -->
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-xl border border-slate-200
                        shadow-sm p-6 space-y-5">


                <!-- Header Card -->
                <div class="border-b border-slate-100 pb-3
                            flex items-center gap-2">

                    <div class="w-7 h-7 rounded-lg bg-emerald-50
                                text-emerald-800 flex items-center
                                justify-center">

                        <i data-lucide="building-2"
                           class="w-4 h-4"></i>

                    </div>


                    <h2 class="font-bold text-slate-800 text-sm">
                        Informasi Ruangan Workshop
                    </h2>

                </div>


                <!-- Nama Ruangan -->
                <div>

                    <label for="nama_ruangan"
                           class="block text-xs font-semibold
                                  text-slate-700 mb-1.5">

                        Nama Ruangan
                        <span class="text-rose-500">*</span>

                    </label>


                    <input
                        type="text"
                        name="nama_ruangan"
                        id="nama_ruangan"
                        value="{{ old('nama_ruangan') }}"
                        maxlength="150"
                        placeholder="Contoh: Workshop Otomotif"
                        class="w-full px-3 py-2 text-xs
                               border border-slate-200 rounded-lg
                               focus:outline-none focus:ring-2
                               focus:ring-emerald-700
                               focus:border-transparent
                               @error('nama_ruangan')
                                   border-rose-400 bg-rose-50/50
                               @enderror"
                    />


                    <!-- Keterangan -->
                    <p class="text-slate-400 text-[11px] mt-1">

                        Masukkan nama ruangan workshop,
                        maksimal 150 karakter.

                    </p>

                    <!-- Error Field -->
                    @error('nama_ruangan')

                        <p class="text-rose-600 text-[11px] mt-1">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

            </div>

        </div>


        <!-- Right Column -->
        <div class="space-y-6">

            <div class="bg-white rounded-xl border border-slate-200
                        shadow-sm p-5 space-y-4">


                <!-- Panduan -->
                <h3 class="font-bold text-slate-800 text-xs pb-2
                           border-b border-slate-100
                           flex items-center gap-2">

                    <i data-lucide="info"
                       class="w-4 h-4 text-emerald-700"></i>

                    Panduan Pengisian

                </h3>


                <div class="space-y-3 text-xs text-slate-600
                            leading-relaxed">

                    <p>

                        Data ruangan workshop ini akan digunakan
                        sebagai pilihan pada form
                        <strong>Jadwal Pelatihan</strong>.

                    </p>


                    <div class="p-3 bg-slate-50 rounded-lg
                                border border-slate-100
                                text-[11px] text-slate-500">

                        Contoh:

                        <span class="font-bold text-slate-700">
                            Workshop Otomotif
                        </span>

                    </div>

                </div>


                <!-- Button -->
                <div class="pt-2 space-y-2">


                    <!-- Simpan -->
                    <button
                        type="submit"
                        class="w-full bg-emerald-900
                               hover:bg-emerald-950 text-white
                               font-semibold text-xs py-2.5 px-4
                               rounded-lg shadow-sm
                               flex items-center justify-center
                               gap-2 transition">

                        <i data-lucide="save"
                           class="w-4 h-4"></i>

                        Simpan Ruangan

                    </button>


                    <!-- Batal -->
                    <a
                        href="{{ route('ruangan-workshop.index') }}"
                        class="w-full bg-slate-100 hover:bg-slate-200
                               text-slate-700 font-semibold text-xs
                               py-2.5 px-4 rounded-lg
                               flex items-center justify-center
                               gap-2 transition">

                        Batal

                    </a>

                </div>

            </div>

        </div>

    </form>

@endsection