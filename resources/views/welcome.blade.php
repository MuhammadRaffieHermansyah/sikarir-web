@extends('layouts.public')

@section('title', 'siKarir — Skill baru, peluang baru | UPT BLK Jember')

@section('content')
@php
    $pelatihans = $pelatihans ?? [];
    $lowongans = $lowongans ?? [];
    $berita = $berita ?? [];
    $alumni = $alumni ?? [];
@endphp

<style>
    .sikarir-home {
        --sk-ink: #12372e;
        --sk-green: #0d4939;
        --sk-lime: #d8f36a;
        --sk-paper: #f7f8f3;
        --sk-line: #e3e8df;
        --sk-hero-bg: url('/images/hero-image.webp');
        background: var(--sk-paper);
        color: var(--sk-ink);
    }
    .sikarir-home * { box-sizing: border-box; }
    .sk-wrap { width: min(1160px, calc(100% - 48px)); margin-inline: auto; }
    .sk-eyebrow { display: inline-flex; align-items: center; gap: 9px; color: #47705d; font-size: 11px; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; }
    .sk-eyebrow::before { width: 8px; height: 8px; border-radius: 99px; background: #a7c748; content: ''; }
    .sk-title { margin: 10px 0 0; color: #14382f; font-size: clamp(32px, 4.3vw, 54px); font-weight: 800; letter-spacing: -.055em; line-height: .99; }
    .sk-copy { color: #61736b; font-size: 15px; line-height: 1.75; }
    .sk-hero { position: relative; isolation: isolate; display: flex; min-height: min(760px, calc(100vh - 72px)); align-items: center; overflow: hidden; background-color: #083d30; background-image: linear-gradient(90deg, rgba(4, 40, 31, .97) 0%, rgba(4, 40, 31, .9) 40%, rgba(4, 40, 31, .25) 76%, rgba(4, 40, 31, .08) 100%), var(--sk-hero-bg, url('/images/hero-image.webp')); background-position: center right; background-size: cover; }
    .sk-hero::after { position: absolute; z-index: -1; right: 6%; bottom: 9%; width: 100px; height: 100px; border: 1px solid rgba(216, 243, 106, .48); border-radius: 50%; content: ''; }
    .sk-hero-inner { width: min(1160px, calc(100% - 48px)); margin: 0 auto; padding: 76px 0 104px; }
    .sk-hero .sk-eyebrow { color: #d8f36a; }
    .sk-hero h1 { max-width: 790px; margin: 22px 0 0; color: #fff; font-size: clamp(48px, 8.2vw, 104px); font-weight: 800; letter-spacing: -.075em; line-height: .9; }
    .sk-hero h1 em { color: var(--sk-lime); font-style: normal; }
    .sk-hero p { max-width: 570px; margin: 24px 0 0; color: rgba(239, 247, 239, .83); font-size: clamp(15px, 1.5vw, 18px); line-height: 1.7; }
    .sk-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }
    .sk-btn { display: inline-flex; min-height: 48px; align-items: center; justify-content: center; gap: 10px; padding: 0 20px; border: 1px solid transparent; border-radius: 999px; font-size: 13px; font-weight: 800; text-decoration: none; transition: transform .18s ease, background-color .18s ease, color .18s ease, border-color .18s ease; }
    .sk-btn:hover { transform: translateY(-2px); }
    .sk-btn:active { transform: translateY(1px); }
    .sk-btn-lime { background: var(--sk-lime); color: #183a2b; }
    .sk-btn-lime:hover { background: #e5ff83; }
    .sk-btn-glass { border-color: rgba(255,255,255,.35); color: #fff; background: rgba(255,255,255,.08); }
    .sk-btn-glass:hover { background: rgba(255,255,255,.16); }
    .sk-search { position: relative; z-index: 2; display: grid; grid-template-columns: 1fr auto; gap: 12px; align-items: end; margin-top: -44px; padding: 16px; border: 1px solid #e5e9e3; border-radius: 22px; background: #fff; box-shadow: 0 18px 50px rgba(20, 49, 39, .12); }
    .sk-search label { display: block; margin: 0 0 7px 4px; color: #65766c; font-size: 10px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }
    .sk-search-field { display: flex; min-height: 50px; align-items: center; gap: 10px; padding: 0 14px; border: 1px solid #e4e9e2; border-radius: 14px; background: #f8faf6; }
    .sk-search-field i { color: #718579; }
    .sk-search input { width: 100%; border: 0; outline: 0; background: transparent; color: #183c30; font-size: 14px; }
    .sk-search input::placeholder { color: #96a39a; }
    .sk-search .sk-btn { min-height: 50px; border-radius: 14px; background: var(--sk-green); color: white; }
    .sk-search .sk-btn:hover { background: #08392d; }
    .sk-stats { padding: 36px 0 56px; }
    .sk-stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); overflow: hidden; border: 1px solid var(--sk-line); border-radius: 20px; background: #fff; }
    .sk-stat { padding: 23px 24px; border-right: 1px solid var(--sk-line); }
    .sk-stat:last-child { border-right: 0; }
    .sk-stat strong { display: block; color: var(--sk-ink); font-size: clamp(24px, 3vw, 34px); font-weight: 800; letter-spacing: -.06em; }
    .sk-stat span { display: block; margin-top: 3px; color: #708077; font-size: 12px; line-height: 1.5; }
    .sk-section { padding: 78px 0; }
    .sk-section-soft { border-block: 1px solid var(--sk-line); background: #f0f3ec; }
    .sk-head { display: flex; align-items: end; justify-content: space-between; gap: 24px; margin-bottom: 30px; }
    .sk-head .sk-title { max-width: 650px; }
    .sk-link { display: inline-flex; align-items: center; gap: 8px; color: #28634e; font-size: 13px; font-weight: 800; text-decoration: none; }
    .sk-link:hover { color: #102f26; }
    .sk-grid-3 { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
    .sk-service { min-height: 205px; padding: 24px; border: 1px solid var(--sk-line); border-radius: 20px; background: #fff; transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
    .sk-service:hover, .sk-program:hover, .sk-job:hover { transform: translateY(-3px); border-color: #c3d5a5; box-shadow: 0 16px 30px rgba(18,55,46,.08); }
    .sk-icon { display: grid; width: 44px; height: 44px; place-items: center; border-radius: 14px; background: #eff5e6; color: #28634e; }
    .sk-service h3 { margin: 21px 0 7px; color: #183b30; font-size: 17px; font-weight: 800; letter-spacing: -.03em; }
    .sk-service p { margin: 0; color: #718077; font-size: 13px; line-height: 1.7; }
    .sk-program-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
    .sk-program { display: flex; min-width: 0; flex-direction: column; overflow: hidden; border: 1px solid var(--sk-line); border-radius: 20px; background: #fff; transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
    .sk-program-media { position: relative; height: 168px; overflow: hidden; background: #e8eee4; }
    .sk-program-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s ease; }
    .sk-program:hover .sk-program-media img { transform: scale(1.03); }
    .sk-chip { position: absolute; top: 12px; left: 12px; padding: 7px 10px; border: 1px solid rgba(255,255,255,.6); border-radius: 999px; background: rgba(15, 56, 43, .85); color: #fff; font-size: 10px; font-weight: 800; backdrop-filter: blur(8px); }
    .sk-program-body { display: flex; flex: 1; flex-direction: column; padding: 18px; }
    .sk-program-body .sk-category { color: #56806a; font-size: 10px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }
    .sk-program-body h3 { margin: 8px 0; color: #183b30; font-size: 16px; font-weight: 800; line-height: 1.35; }
    .sk-program-body p { display: -webkit-box; overflow: hidden; margin: 0; color: #718077; font-size: 12px; line-height: 1.65; -webkit-box-orient: vertical; -webkit-line-clamp: 3; line-clamp: 3; }
    .sk-card-actions { display: flex; gap: 8px; margin-top: auto; padding-top: 18px; }
    .sk-card-actions a { display: inline-flex; min-height: 40px; flex: 1; align-items: center; justify-content: center; border: 1px solid #dfe6dc; border-radius: 12px; color: #305745; font-size: 11px; font-weight: 800; text-decoration: none; }
    .sk-card-actions a:last-child { border-color: var(--sk-green); background: var(--sk-green); color: #fff; }
    .sk-card-actions a:hover { border-color: #94aa8a; }
    .sk-job-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
    .sk-job { display: flex; min-height: 235px; flex-direction: column; padding: 22px; border: 1px solid var(--sk-line); border-radius: 20px; background: #fff; transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
    .sk-job-top { display: flex; align-items: start; justify-content: space-between; gap: 12px; }
    .sk-job h3 { margin: 0; color: #183b30; font-size: 17px; font-weight: 800; line-height: 1.35; }
    .sk-status { flex: none; padding: 6px 9px; border-radius: 99px; background: #eff5e6; color: #376749; font-size: 10px; font-weight: 800; }
    .sk-job-company, .sk-job-location { display: flex; align-items: center; gap: 8px; margin: 13px 0 0; color: #75847b; font-size: 12px; }
    .sk-job-desc { margin: 16px 0; color: #718077; font-size: 12px; line-height: 1.7; }
    .sk-job-foot { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: auto; padding-top: 14px; border-top: 1px solid #edf0eb; }
    .sk-job-foot small { color: #8a978f; font-size: 10px; }
    .sk-job-foot strong { display: block; margin-top: 4px; color: #345141; font-size: 12px; }
    .sk-job-foot a { padding: 10px 14px; border-radius: 12px; background: var(--sk-green); color: #fff; font-size: 11px; font-weight: 800; text-decoration: none; }
    .sk-steps { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0; margin-top: 38px; }
    .sk-step { position: relative; padding: 0 24px 0 0; }
    .sk-step:not(:last-child)::after { position: absolute; top: 22px; left: 50px; width: calc(100% - 64px); height: 1px; background: #cdd9c8; content: ''; }
    .sk-step-number { position: relative; z-index: 1; display: grid; width: 46px; height: 46px; place-items: center; border: 1px solid #cdd9c8; border-radius: 50%; background: var(--sk-paper); color: #315d47; font-size: 12px; font-weight: 800; }
    .sk-step h3 { margin: 19px 0 8px; color: #183b30; font-size: 16px; font-weight: 800; }
    .sk-step p { margin: 0; color: #718077; font-size: 12px; line-height: 1.7; }
    .sk-story-grid { display: grid; grid-template-columns: 1.05fr .95fr; gap: 54px; }
    .sk-story-list { display: grid; gap: 12px; }
    .sk-story { display: flex; gap: 15px; padding: 13px; border: 1px solid var(--sk-line); border-radius: 17px; background: #fff; }
    .sk-story img { width: 94px; height: 82px; flex: none; border-radius: 12px; object-fit: cover; }
    .sk-story h3 { margin: 6px 0; color: #183b30; font-size: 14px; font-weight: 800; line-height: 1.4; }
    .sk-story p { margin: 0; color: #718077; font-size: 11px; line-height: 1.6; }
    .sk-story-meta { color: #64816e; font-size: 9px; font-weight: 800; letter-spacing: .09em; text-transform: uppercase; }
    .sk-alumni { display: grid; gap: 12px; }
    .sk-quote { padding: 20px; border: 1px solid var(--sk-line); border-radius: 18px; background: #fff; }
    .sk-quote-person { display: flex; align-items: center; gap: 11px; margin-bottom: 12px; }
    .sk-quote-person img { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; }
    .sk-quote-person strong { display: block; color: #183b30; font-size: 12px; }
    .sk-quote-person span { display: block; margin-top: 3px; color: #7e8c83; font-size: 10px; }
    .sk-quote blockquote { margin: 0; color: #566a5e; font-size: 12px; line-height: 1.75; }
    .sk-about { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 17px 19px; border-radius: 16px; background: #eaf1df; }
    .sk-about strong { color: #183b30; font-size: 12px; }
    .sk-about p { margin: 4px 0 0; color: #718077; font-size: 11px; line-height: 1.55; }
    .sk-about a { flex: none; color: #28634e; font-size: 11px; font-weight: 800; text-decoration: none; }
    .sk-cta { padding: 42px; border-radius: 26px; background: #103e32; color: white; }
    .sk-cta-inner { display: flex; align-items: center; justify-content: space-between; gap: 28px; }
    .sk-cta h2 { max-width: 580px; margin: 13px 0 0; color: #fff; font-size: clamp(30px, 4vw, 47px); font-weight: 800; letter-spacing: -.06em; line-height: 1; }
    .sk-cta p { max-width: 570px; margin: 14px 0 0; color: rgba(239,247,239,.76); font-size: 13px; line-height: 1.7; }
    .sk-empty { grid-column: 1 / -1; padding: 38px 20px; border: 1px dashed #cbd6c8; border-radius: 18px; color: #7d8c81; text-align: center; font-size: 13px; }
    @media (max-width: 900px) {
        .sk-program-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .sk-story-grid { gap: 30px; }
        .sk-cta-inner { align-items: start; flex-direction: column; }
    }
    @media (max-width: 640px) {
        .sk-wrap, .sk-hero-inner { width: min(100% - 36px, 520px); }
        .sk-hero { min-height: 720px; align-items: start; background-image: linear-gradient(90deg, rgba(4, 40, 31, .93), rgba(4, 40, 31, .72)), var(--sk-hero-bg, url('/images/hero-image.webp')); background-position: 58% center; }
        .sk-hero-inner { padding: 80px 0 130px; }
        .sk-hero h1 { font-size: clamp(49px, 14vw, 70px); }
        .sk-hero::after { right: 9%; bottom: 5%; width: 58px; height: 58px; }
        .sk-search { grid-template-columns: 1fr; margin-top: -84px; padding: 12px; border-radius: 18px; }
        .sk-search .sk-btn { width: 100%; }
        .sk-stats { padding: 28px 0 36px; }
        .sk-stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .sk-stat { padding: 17px; border-bottom: 1px solid var(--sk-line); }
        .sk-stat:nth-child(2) { border-right: 0; }
        .sk-stat:nth-child(n+3) { border-bottom: 0; }
        .sk-section { padding: 56px 0; }
        .sk-head { align-items: start; flex-direction: column; margin-bottom: 22px; }
        .sk-grid-3, .sk-job-grid { grid-template-columns: 1fr; }
        .sk-service { min-height: 0; }
        .sk-program-grid { gap: 12px; }
        .sk-program-media { height: 130px; }
        .sk-program-body { padding: 14px; }
        .sk-program-body h3 { font-size: 14px; }
        .sk-program-body p { font-size: 11px; }
        .sk-card-actions { flex-direction: column; padding-top: 13px; }
        .sk-card-actions a { min-height: 37px; }
        .sk-steps { grid-template-columns: 1fr; gap: 24px; margin-top: 26px; }
        .sk-step { display: grid; grid-template-columns: 46px 1fr; column-gap: 15px; padding: 0; }
        .sk-step:not(:last-child)::after { top: 48px; left: 22px; width: 1px; height: calc(100% - 22px); }
        .sk-step-number { grid-row: span 2; }
        .sk-step h3 { margin: 2px 0 5px; }
        .sk-story-grid { grid-template-columns: 1fr; gap: 38px; }
        .sk-cta { padding: 26px 21px; border-radius: 20px; }
        .sk-cta .sk-actions { width: 100%; }
        .sk-cta .sk-btn { width: 100%; }
        .sk-story img { width: 82px; height: 76px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .sk-btn, .sk-service, .sk-program, .sk-job, .sk-program-media img { transition: none; }
        .sk-btn:hover, .sk-service:hover, .sk-program:hover, .sk-job:hover { transform: none; }
    }
</style>

<div class="sikarir-home">
    {{-- Hero: portal dan aksi utama --}}
    <section class="sk-hero" style="--sk-hero-bg: url('{{ asset('images/hero-image.webp') }}');">
        <div class="sk-hero-inner">
            <span class="sk-eyebrow">Portal resmi UPT BLK Jember</span>
            <h1>Skill baru.<br><em>Peluang baru.</em></h1>
            <p>Temukan pelatihan vokasi, sertifikasi kompetensi, dan peluang kerja yang terhubung dengan industri bersama UPT BLK Jember.</p>
            <div class="sk-actions">
                <a href="{{ route('pelatihan.katalog') }}" class="sk-btn sk-btn-lime">Jelajahi pelatihan <i data-lucide="arrow-up-right" class="w-4 h-4"></i></a>
                <a href="{{ route('lowongan.katalog') }}" class="sk-btn sk-btn-glass">Cari lowongan <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
            </div>
        </div>
    </section>

    {{-- Pencarian cepat --}}
    <div class="sk-wrap">
        <form method="GET" action="{{ route('pelatihan.katalog') }}" class="sk-search">
            <div>
                <label for="home-search">Cari pelatihan atau kejuruan</label>
                <div class="sk-search-field"><i data-lucide="search" class="w-4 h-4"></i><input id="home-search" type="search" name="q" placeholder="Contoh: otomotif, las, tata boga..."></div>
            </div>
            <button type="submit" class="sk-btn">Temukan program <i data-lucide="arrow-right" class="w-4 h-4"></i></button>
        </form>
    </div>

    {{-- Statistik yang sudah digunakan di halaman --}}
    <section class="sk-stats">
        <div class="sk-wrap sk-stats-grid">
            <div class="sk-stat"><strong>12+</strong><span>Kejuruan pelatihan</span></div>
            <div class="sk-stat"><strong>94%</strong><span>Lulusan terserap kerja &amp; wirausaha</span></div>
            <div class="sk-stat"><strong>Gratis</strong><span>Program dibiayai APBD &amp; APBN</span></div>
            <div class="sk-stat"><strong>BNSP</strong><span>Sertifikasi standar kompetensi</span></div>
        </div>
    </section>

    {{-- Layanan --}}
    <section class="sk-section sk-section-soft">
        <div class="sk-wrap">
            <div class="sk-head">
                <div><span class="sk-eyebrow">Dari belajar sampai kerja</span><h2 class="sk-title">Satu tempat buat<br>naik level.</h2></div>
            </div>
            <div class="sk-grid-3">
                @foreach ([
                    ['icon' => 'user-round-check', 'title' => 'Pendaftaran pelatihan', 'desc' => 'Pelatihan Reguler Berbasis Kompetensi (PBK) dan Mobile Training Unit (MTU) pedesaan.'],
                    ['icon' => 'briefcase-business', 'title' => 'Bursa kerja khusus', 'desc' => 'Peluang kerja terverifikasi bagi alumni vokasi dan pencari kerja umum.'],
                    ['icon' => 'badge-check', 'title' => 'Sertifikasi kompetensi', 'desc' => 'Uji kompetensi profesi melalui LSP-P1 BLK Jember berlisensi BNSP.'],
                    ['icon' => 'messages-square', 'title' => 'Konsultasi karir', 'desc' => 'Bimbingan jabatan bersama instruktur dan tenaga konseling ketenagakerjaan.'],
                    ['icon' => 'building-2', 'title' => 'Magang & kemitraan', 'desc' => 'Program on-the-job training bersama Dunia Usaha dan Dunia Industri (DUDI).'],
                    ['icon' => 'file-check-2', 'title' => 'Verifikasi sertifikat', 'desc' => 'Cek keaslian sertifikat kelulusan BLK dan e-Sertifikat kompetensi.'],
                ] as $layanan)
                    <article class="sk-service">
                        <div class="sk-icon"><i data-lucide="{{ $layanan['icon'] }}" class="w-5 h-5"></i></div>
                        <h3>{{ $layanan['title'] }}</h3>
                        <p>{{ $layanan['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Program pelatihan --}}
    <section class="sk-section">
        <div class="sk-wrap">
            <div class="sk-head">
                <div><span class="sk-eyebrow">Belajar yang kepake</span><h2 class="sk-title">Pilih skill.<br>Mulai dari sini.</h2></div>
                <a href="{{ route('pelatihan.katalog') }}" class="sk-link">Semua pelatihan <i data-lucide="arrow-up-right" class="w-4 h-4"></i></a>
            </div>
            <div class="sk-program-grid">
                @forelse ($pelatihans as $item)
                    <article class="sk-program">
                        <div class="sk-program-media">
                            <img src="{{ $item->gambar_url ?? asset('images/hero-image.webp') }}" alt="{{ $item->nama_pelatihan }}" loading="lazy">
                            <span class="sk-chip">{{ $item->sumber_dana ?? 'Program pelatihan' }}</span>
                        </div>
                        <div class="sk-program-body">
                            <span class="sk-category">{{ $item->kategori ?? 'Kejuruan' }}</span>
                            <h3>{{ $item->nama_pelatihan }}</h3>
                            <p>{{ $item->deskripsi_pelatihan }}</p>
                            <div class="sk-card-actions">
                                <a href="{{ route('pelatihan.katalog') . '#' . ($item->id_pelatihan ?? $item->id) }}">Lihat silabus</a>
                                <a href="{{ route('register') }}">Daftar</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="sk-empty">Belum ada data pelatihan aktif.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Lowongan kerja --}}
    <section class="sk-section sk-section-soft">
        <div class="sk-wrap">
            <div class="sk-head">
                <div><span class="sk-eyebrow">Langkah berikutnya</span><h2 class="sk-title">Peluang kerja<br>buat kamu kejar.</h2></div>
                <a href="{{ route('lowongan.katalog') }}" class="sk-link">Semua lowongan <i data-lucide="arrow-up-right" class="w-4 h-4"></i></a>
            </div>
            <div class="sk-job-grid">
                @forelse ($lowongans as $job)
                    <article class="sk-job">
                        <div class="sk-job-top"><h3>{{ $job->judul_lowongan }}</h3><span class="sk-status">{{ ucfirst($job->status) }}</span></div>
                        <p class="sk-job-company"><i data-lucide="building-2" class="w-4 h-4"></i>{{ $job->mitra->nama_perusahaan ?? $job->mitra->nama ?? '-' }}</p>
                        <p class="sk-job-location"><i data-lucide="map-pin" class="w-4 h-4"></i>{{ $job->lokasi ?? '-' }}</p>
                        <p class="sk-job-desc">{{ $job->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        <div class="sk-job-foot">
                            <div><small>Diposting</small><strong>{{ $job->tanggal_posting ? \Carbon\Carbon::parse($job->tanggal_posting)->format('d M Y') : '-' }}</strong></div>
                            <a href="{{ route('lowongan.katalog') . '#' . $job->id_lowongan }}">Lihat posisi</a>
                        </div>
                    </article>
                @empty
                    <div class="sk-empty">Belum ada lowongan aktif saat ini.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Alur pendaftaran --}}
    <section class="sk-section">
        <div class="sk-wrap">
            <span class="sk-eyebrow">Alurnya transparan</span>
            <h2 class="sk-title">Empat langkah buat<br>mulai perjalananmu.</h2>
            <div class="sk-steps">
                @foreach ([
                    ['title' => 'Buat akun', 'desc' => 'Daftarkan akun siKarir menggunakan NIK yang valid dan lengkapi profil.'],
                    ['title' => 'Pilih kejuruan', 'desc' => 'Cari program aktif yang sesuai minat, jadwal, dan kuota.'],
                    ['title' => 'Ikuti seleksi', 'desc' => 'Jalani tes tertulis online dan verifikasi wawancara di workshop BLK.'],
                    ['title' => 'Belajar & sertifikasi', 'desc' => 'Ikuti pelatihan hingga uji kompetensi resmi BNSP.'],
                ] as $step)
                    <article class="sk-step">
                        <span class="sk-step-number">{{ sprintf('%02d', $loop->iteration) }}</span>
                        <h3>{{ $step['title'] }}</h3>
                        <p>{{ $step['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Warta dan alumni --}}
    <section class="sk-section sk-section-soft">
        <div class="sk-wrap sk-story-grid">
            <div>
                <div class="sk-head"><div><span class="sk-eyebrow">Info terbaru</span><h2 class="sk-title">Warta &amp; agenda BLK.</h2></div></div>
                <div class="sk-story-list">
                    @forelse ($berita as $b)
                        <article class="sk-story">
                            <img src="{{ $b->gambar_url ?? asset('images/hero-image.webp') }}" alt="" loading="lazy">
                            <div><span class="sk-story-meta">{{ $b->kategori ?? 'Pengumuman' }} · {{ $b->tanggal ?? '' }}</span><h3>{{ $b->judul }}</h3><p>{{ $b->ringkasan }}</p></div>
                        </article>
                    @empty
                        <div class="sk-empty">Belum ada warta terbaru.</div>
                    @endforelse
                </div>
            </div>
            <div>
                <div class="sk-head"><div><span class="sk-eyebrow">Cerita lulusan</span><h2 class="sk-title">Dari BLK ke dunia kerja.</h2></div></div>
                <div class="sk-alumni">
                    @forelse ($alumni as $a)
                        <article class="sk-quote">
                            <div class="sk-quote-person"><img src="{{ $a->foto_url ?? asset('images/logo-sikarir.png') }}" alt="" loading="lazy"><div><strong>{{ $a->nama }}</strong><span>{{ $a->profesi }}</span></div></div>
                            <blockquote>“{{ $a->testimoni }}”</blockquote>
                        </article>
                    @empty
                        <div class="sk-empty">Belum ada testimoni alumni.</div>
                    @endforelse
                    <div class="sk-about"><div><strong>Tentang UPT BLK Jember</strong><p>Lembaga pelatihan vokasi Disnakertrans Jatim dengan fasilitas workshop.</p></div><a href="{{ route('tentang.index') }}">Kenali BLK <span aria-hidden="true">↗</span></a></div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="sk-section">
        <div class="sk-wrap sk-cta">
            <div class="sk-cta-inner">
                <div><span class="sk-eyebrow">Masa depan dimulai dari skill</span><h2>Siap mulai langkah barumu?</h2><p>Daftar akun siKarir, temukan program yang cocok, dan siapkan diri untuk peluang berikutnya.</p></div>
                <div class="sk-actions"><a href="{{ route('register') }}" class="sk-btn sk-btn-lime">Buat akun siKarir <i data-lucide="arrow-up-right" class="w-4 h-4"></i></a></div>
            </div>
        </div>
    </section>
</div>
@endsection
