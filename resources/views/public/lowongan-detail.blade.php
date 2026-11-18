@extends('layouts.public')

@section('title', $lowongan->judul_lowongan . ' - Lowongan siKarir UPT BLK Jember')

@section('content')
@php
    $telp  = $lowongan->mitra->no_telp ?? null;
    $wa    = $telp ? preg_replace('/^0/', '62', preg_replace('/\D+/', '', $telp)) : null;
    $email = $lowongan->mitra->user->email ?? null;
    $tgl   = $lowongan->tanggal_posting ? $lowongan->tanggal_posting->translatedFormat('d F Y') : '-';
@endphp

<div class="public-page">
    <div class="max-w-7xl mx-auto px-0 py-8 md:py-12 space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 flex-wrap">
            <a href="{{ url('/') }}" class="hover:text-emerald-700 transition">Beranda</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <a href="{{ route('lowongan.katalog') }}" class="hover:text-emerald-700 transition">Lowongan Kerja</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-slate-700 truncate">{{ $lowongan->judul_lowongan }}</span>
        </nav>

        <div class="grid lg:grid-cols-12 gap-8">

            {{-- KOLOM KIRI --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- Header lowongan --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    @if ($lowongan->gambar_url)
                        <img src="{{ $lowongan->gambar_url }}" alt="Foto {{ $lowongan->judul_lowongan }}" class="w-full max-h-80 object-cover">
                    @endif
                    <div class="p-6 space-y-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="space-y-1.5">
                                <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">
                                    {{ $lowongan->mitra->bidang_usaha ?? 'Lowongan Mitra' }}
                                </span>
                                <h1 class="text-xl md:text-2xl font-black text-slate-900 leading-snug">{{ $lowongan->judul_lowongan }}</h1>
                            </div>
                            <span class="text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full shrink-0 uppercase tracking-wider">
                                {{ ucfirst($lowongan->status) }}
                            </span>
                        </div>

                        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs font-medium text-slate-600 pt-4 border-t border-slate-100">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="building-2" class="w-4 h-4 text-slate-400"></i>
                                {{ $lowongan->mitra->nama_perusahaan ?? '-' }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i>
                                {{ $lowongan->lokasi ?? 'Lokasi Fleksibel' }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                                Diposting {{ $tgl }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                    <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </div>
                        <h2 class="font-bold text-slate-800 text-sm">Deskripsi Pekerjaan &amp; Tanggung Jawab</h2>
                    </div>
                    <div class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">{{ $lowongan->deskripsi ?: 'Belum ada deskripsi pekerjaan yang ditambahkan.' }}</div>
                </div>

                {{-- Kualifikasi --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                    <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                            <i data-lucide="check-square" class="w-4 h-4"></i>
                        </div>
                        <h2 class="font-bold text-slate-800 text-sm">Kualifikasi &amp; Persyaratan</h2>
                    </div>
                    <div class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">{{ $lowongan->kualifikasi ?: 'Belum ada kualifikasi yang dicantumkan.' }}</div>
                </div>
            </div>

            {{-- KOLOM KANAN --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- Info perusahaan --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-4">
                    <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Info Perusahaan</h3>
                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-400 block mb-0.5">Perusahaan</span>
                            <span class="font-bold text-slate-800">{{ $lowongan->mitra->nama_perusahaan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5">Bidang Usaha</span>
                            <span class="font-semibold text-slate-700">{{ $lowongan->mitra->bidang_usaha ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5">Wilayah</span>
                            <span class="font-semibold text-slate-700">{{ $lowongan->mitra->kota ?? '-' }}{{ $lowongan->mitra->provinsi ? ', ' . $lowongan->mitra->provinsi : '' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-3">
                    <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Berminat? Hubungi Perusahaan</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Lowongan ini bersifat informasi. Pendaftaran dilakukan langsung melalui kontak perusahaan di bawah.
                    </p>
                    <div class="space-y-2">
                        @if ($wa)
                            <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener"
                               class="w-full px-3.5 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold rounded-xl shadow-sm flex items-center justify-center gap-2 transition">
                                <i data-lucide="phone" class="w-4 h-4"></i> {{ $telp }}
                            </a>
                        @endif
                        @if ($email)
                            <a href="mailto:{{ $email }}?subject={{ rawurlencode('Minat Lowongan: ' . $lowongan->judul_lowongan) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl flex items-center justify-center gap-2 transition break-all">
                                <i data-lucide="mail" class="w-4 h-4 shrink-0"></i> {{ $email }}
                            </a>
                        @endif
                        @if (!$wa && !$email)
                            <p class="text-xs text-slate-400">Kontak perusahaan belum dicantumkan.</p>
                        @endif
                    </div>
                </div>

                {{-- Lowongan lainnya --}}
                @if ($lainnya->isNotEmpty())
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-3">
                        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Lowongan Lainnya</h3>
                        <div class="space-y-3">
                            @foreach ($lainnya as $lain)
                                <a href="{{ route('lowongan.detail', $lain->id_lowongan) }}" class="flex items-center gap-3 group">
                                    @if ($lain->gambar_url)
                                        <img src="{{ $lain->gambar_url }}" alt="" class="w-11 h-11 rounded-lg object-cover shrink-0 border border-slate-100">
                                    @else
                                        <div class="w-11 h-11 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0">
                                            <i data-lucide="building-2" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 transition truncate">{{ $lain->judul_lowongan }}</div>
                                        <div class="text-[11px] text-slate-400 truncate">{{ $lain->mitra->nama_perusahaan ?? '-' }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <a href="{{ route('lowongan.katalog') }}"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl flex items-center justify-center gap-2 transition">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Lowongan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
