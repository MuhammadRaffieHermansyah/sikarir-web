@extends('layouts.public')

@section('title', 'siKarir — Skill baru, peluang baru | UPT BLK Jember')

@section('content')
  @php
    $pelatihans = $pelatihans ?? [];
    $lowongans = $lowongans ?? [];

    $fallbackImg = asset('images/hero-image.webp');
    $dashboardUrl = \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : url('/');

    // Batas tampilan di beranda (sisanya diarahkan ke halaman katalog)
    $batasPelatihan = 6;   // 3 kolom x 2 baris
    $batasLowongan = 3;    // 3 kolom x 1 baris

    // Total bisa dikirim controller ($totalPelatihan / $totalLowongan); kalau tidak, dihitung dari data yang ada
    $totalPelatihan = $totalPelatihan ?? collect($pelatihans)->count();
    $totalLowongan = $totalLowongan ?? collect($lowongans)->count();

    $pelatihanTampil = collect($pelatihans)->take($batasPelatihan);
    $lowonganTampil = collect($lowongans)->take($batasLowongan);

    // Daftar kategori untuk filter pelatihan (nilai default harus sama dengan yang dipakai di kartu)
    $kategoriList = $pelatihanTampil
        ->map(fn ($p) => $p->kategori ?? 'Kejuruan')
        ->unique()
        ->values();
  @endphp

  {{-- Animasi scroll: self-contained di file ini (tanpa @push, tanpa edit app.css) --}}
  <style>
    @keyframes sk-reveal {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: none; }
    }
    /* Sebelum terlihat: sembunyikan. Hanya aktif kalau JS jalan (.reveal-ready) */
    .reveal-ready [data-reveal]:not(.is-visible),
    .reveal-ready [data-reveal-group]:not(.is-visible) > * { opacity: 0; }

    /* 'backwards' = efek hanya saat animasi, setelah itu hover:-translate-y dll tetap jalan */
    .reveal-ready [data-reveal].is-visible,
    .reveal-ready [data-reveal-group].is-visible > * {
      animation: sk-reveal .7s cubic-bezier(.22, 1, .36, 1) backwards;
      animation-delay: calc(var(--i, 0) * 90ms);
    }

    @media (prefers-reduced-motion: reduce) {
      .reveal-ready [data-reveal]:not(.is-visible),
      .reveal-ready [data-reveal-group]:not(.is-visible) > * { opacity: 1; }
      .reveal-ready [data-reveal].is-visible,
      .reveal-ready [data-reveal-group].is-visible > * { animation: none; }
    }
  </style>
  <script>document.documentElement.classList.add('reveal-ready');</script>

  {{-- Progress bar scroll --}}
  <div id="sk-progress" class="pointer-events-none fixed inset-x-0 top-0 z-[60] h-1 origin-left bg-sikarir-lime" style="transform: scaleX(0)"></div>

  {{-- Hero --}}
  <section class="relative isolate overflow-hidden bg-primary text-primary-foreground">
    <img
      src="{{ $fallbackImg }}"
      alt=""
      fetchpriority="high"
      decoding="async"
      data-parallax
      class="absolute inset-0 size-full object-cover object-center opacity-40"
    >
    <div class="absolute inset-0 bg-gradient-to-r from-[#04281f]/95 via-[#04281f]/85 to-[#04281f]/25"></div>
    <div class="pointer-events-none absolute -bottom-24 right-[6%] size-32 rounded-full border border-sikarir-lime/40"></div>

    <div class="site-container relative py-20 md:py-28" data-reveal-group>
      <x-ui.badge class="gap-2 border-primary-foreground/20 bg-primary-foreground/10 text-primary-foreground">
        <span class="size-2 rounded-full bg-sikarir-lime"></span>
        Portal resmi UPT BLK Jember
      </x-ui.badge>

      <h1 class="mt-5 max-w-3xl text-5xl font-black leading-[0.9] tracking-[-0.075em] text-white sm:text-6xl lg:text-7xl">
        Skill baru.<br>
        <span class="text-sikarir-lime">Peluang baru.</span>
      </h1>

      <p class="mt-6 max-w-xl text-sm leading-relaxed text-primary-foreground/80 sm:text-base">
        Temukan pelatihan vokasi, sertifikasi kompetensi, dan peluang kerja yang terhubung dengan industri bersama UPT BLK Jember.
      </p>

      <div class="mt-8 flex flex-wrap gap-3">
        <x-ui.button href="{{ route('pelatihan.katalog') }}" size="lg" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
          Jelajahi pelatihan
          <x-lucide-arrow-up-right />
        </x-ui.button>

        <x-ui.button href="{{ route('lowongan.katalog') }}" size="lg" variant="outline" class="border-primary-foreground/35 bg-primary-foreground/5 text-primary-foreground hover:bg-primary-foreground/15 hover:text-primary-foreground">
          Cari lowongan
          <x-lucide-arrow-right />
        </x-ui.button>
      </div>
    </div>
  </section>

  {{-- Quick search (tab Pelatihan / Lowongan) --}}
  <div
    class="site-container relative z-10 -mt-10"
    data-reveal
    x-data="{
      tab: 'pelatihan',
      q: '',
      routes: @js(['pelatihan' => route('pelatihan.katalog'), 'lowongan' => route('lowongan.katalog')]),
      placeholders: {
        pelatihan: 'Contoh: otomotif, las, tata boga...',
        lowongan: 'Contoh: operator, admin, teknisi...'
      },
      chips: {
        pelatihan: ['Otomotif', 'Las', 'Tata Boga', 'Menjahit', 'Komputer'],
        lowongan: ['Operator', 'Admin', 'Teknisi', 'Driver']
      },
      pick(chip) {
        this.q = chip;
        this.$nextTick(() => this.$refs.form.requestSubmit());
      }
    }"
  >
    <form
      x-ref="form"
      method="GET"
      action="{{ route('pelatihan.katalog') }}"
      :action="routes[tab]"
      class="rounded-2xl border border-border bg-card p-4 shadow-xl shadow-primary/10"
    >
      <div class="mb-3 inline-flex rounded-lg bg-muted p-1 text-xs font-bold" role="tablist">
        <button
          type="button" role="tab"
          :aria-selected="tab === 'pelatihan'"
          @click="tab = 'pelatihan'"
          :class="tab === 'pelatihan' ? 'bg-card text-primary shadow-sm' : 'text-muted-foreground'"
          class="rounded-md px-4 py-1.5 transition"
        >Pelatihan</button>
        <button
          type="button" role="tab"
          :aria-selected="tab === 'lowongan'"
          @click="tab = 'lowongan'"
          :class="tab === 'lowongan' ? 'bg-card text-primary shadow-sm' : 'text-muted-foreground'"
          class="rounded-md px-4 py-1.5 transition"
        >Lowongan</button>
      </div>

      <div class="grid gap-3 sm:grid-cols-[1fr_auto] sm:items-end">
        <div>
          <label for="home-search" class="mb-1.5 block text-[10px] font-bold uppercase tracking-[0.12em] text-muted-foreground">
            <span x-text="tab === 'pelatihan' ? 'Cari pelatihan atau kejuruan' : 'Cari lowongan kerja'">Cari pelatihan atau kejuruan</span>
          </label>
          <div class="relative">
            <x-lucide-search class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
            <input
              id="home-search" name="q" type="search" autocomplete="off"
              x-model="q"
              :placeholder="placeholders[tab]"
              placeholder="Contoh: otomotif, las, tata boga..."
              class="h-11 w-full rounded-lg border border-border bg-background pl-9 pr-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            >
          </div>
        </div>

        <x-ui.button type="submit" size="lg" class="font-bold">
          <span x-text="tab === 'pelatihan' ? 'Temukan program' : 'Cari lowongan'">Temukan program</span>
          <x-lucide-arrow-right />
        </x-ui.button>
      </div>

      <div class="mt-3 flex flex-wrap items-center gap-2">
        <span class="text-[11px] text-muted-foreground">Populer:</span>
        <template x-for="chip in chips[tab]" :key="chip">
          <button
            type="button"
            @click="pick(chip)"
            class="rounded-full border border-border px-3 py-1 text-[11px] font-medium text-foreground transition hover:border-primary hover:bg-accent"
            x-text="chip"
          ></button>
        </template>
      </div>
    </form>
  </div>

  {{-- Stats --}}
  <section class="site-container py-10">
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4" data-reveal-group>
      @foreach ([
          ['icon' => 'book-open', 'value' => '12+', 'label' => 'Kejuruan pelatihan'],
          ['icon' => 'trending-up', 'value' => '94%', 'label' => 'Lulusan terserap kerja & wirausaha'],
          ['icon' => 'wallet', 'value' => 'Gratis', 'label' => 'Program dibiayai APBD & APBN'],
          ['icon' => 'award', 'value' => 'BNSP', 'label' => 'Sertifikasi standar kompetensi'],
      ] as $stat)
        <x-ui.stat
          :label="$stat['label']"
          :value="$stat['value']"
          :icon="$stat['icon']"
        />
      @endforeach
    </div>
  </section>

  {{-- Layanan --}}
  <section class="border-y border-border bg-muted/40 py-16 md:py-20">
    <div class="site-container">
      <div class="max-w-2xl" data-reveal>
        <x-ui.badge variant="secondary" class="gap-2 uppercase tracking-wide">
          <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
          Dari belajar sampai kerja
        </x-ui.badge>
        <h2 class="mt-4 text-3xl font-black tracking-tight text-foreground sm:text-4xl">
          Satu tempat buat<br>naik level.
        </h2>
      </div>

      <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
        @foreach ([
            ['icon' => 'user-round-check', 'title' => 'Pendaftaran online', 'desc' => 'Buat akun siKarir, lengkapi biodata dan pas foto, lalu pilih program pelatihan yang sedang dibuka.', 'href' => auth()->check() ? $dashboardUrl : route('register')],
            ['icon' => 'book-open', 'title' => 'Program pelatihan kejuruan', 'desc' => 'Pelatihan berbasis kompetensi di workshop UPT BLK Jember, lengkap dengan jadwal, instruktur, dan silabus.', 'href' => route('pelatihan.katalog')],
            ['icon' => 'truck', 'title' => 'Mobile Training Unit (MTU)', 'desc' => 'Pelatihan keliling ke desa binaan. Masyarakat mengajukan kejuruan, lalu BLK melakukan survei lokasi.', 'href' => null],
            ['icon' => 'badge-check', 'title' => 'Uji kompetensi & sertifikasi', 'desc' => 'Peserta pelatihan difasilitasi uji kompetensi oleh lembaga sertifikasi profesi untuk memperoleh sertifikat.', 'href' => null],
            ['icon' => 'briefcase-business', 'title' => 'Info lowongan kerja', 'desc' => 'Informasi lowongan dari mitra industri beserta kontak mitra bagi yang berminat.', 'href' => route('lowongan.katalog')],
            ['icon' => 'building-2', 'title' => 'Kemitraan dunia usaha', 'desc' => 'Kerja sama dengan Dunia Usaha dan Dunia Industri (DUDI) agar pelatihan selaras dengan kebutuhan kerja.', 'href' => null],
        ] as $layanan)
          <x-ui.card class="relative transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-md">
            <span class="grid size-11 place-items-center rounded-xl bg-accent text-accent-foreground">
              <x-dynamic-component :component="'lucide-'.$layanan['icon']" class="size-5" />
            </span>
            @if ($layanan['href'])
              <x-lucide-arrow-up-right class="absolute right-5 top-5 size-4 text-muted-foreground" />
            @endif
            <h3 class="mt-4 text-base font-bold text-foreground">
              @if ($layanan['href'])
                <a href="{{ $layanan['href'] }}" class="after:absolute after:inset-0 after:rounded-xl focus-visible:outline-none focus-visible:after:ring-2 focus-visible:after:ring-primary">{{ $layanan['title'] }}</a>
              @else
                {{ $layanan['title'] }}
              @endif
            </h3>
            <p class="mt-1.5 text-sm leading-relaxed text-muted-foreground">{{ $layanan['desc'] }}</p>
          </x-ui.card>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Program pelatihan (dengan filter kategori) --}}
  <section class="site-container py-16 md:py-20" x-data="{ kategori: 'semua' }">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
      <div data-reveal>
        <x-ui.badge variant="secondary" class="gap-2 uppercase tracking-wide">
          <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
          Pelatihan Tersedia
        </x-ui.badge>
        <h2 class="mt-4 text-3xl font-black tracking-tight text-foreground sm:text-4xl">
          Pilih skill.<br>Mulai dari sini.
        </h2>
      </div>

      <x-ui.button href="{{ route('pelatihan.katalog') }}" variant="ghost" class="font-bold text-primary">
        Semua pelatihan
        <x-lucide-arrow-up-right />
      </x-ui.button>
    </div>

    @if ($kategoriList->count() > 1)
      <div class="mt-6 flex flex-wrap gap-2">
        <button
          type="button"
          @click="kategori = 'semua'"
          :class="kategori === 'semua' ? 'bg-primary text-primary-foreground' : 'bg-card text-foreground hover:bg-accent'"
          class="rounded-full border border-border px-4 py-1.5 text-xs font-bold transition"
        >Semua</button>

        @foreach ($kategoriList as $kat)
          <button
            type="button"
            @click="kategori = @js($kat)"
            :class="kategori === @js($kat) ? 'bg-primary text-primary-foreground' : 'bg-card text-foreground hover:bg-accent'"
            class="rounded-full border border-border px-4 py-1.5 text-xs font-bold transition"
          >{{ $kat }}</button>
        @endforeach
      </div>
    @endif

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
      @forelse ($pelatihanTampil as $item)
        <div
          x-show="kategori === 'semua' || kategori === @js($item->kategori ?? 'Kejuruan')"
          x-transition.opacity.duration.200ms
        >
          <x-ui.card class="flex h-full flex-col overflow-hidden p-0 transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-md">
            <div class="relative h-40 overflow-hidden bg-muted">
              <img
                src="{{ $item->gambar_url ?? $fallbackImg }}"
                onerror="this.onerror=null;this.src='{{ $fallbackImg }}'"
                alt="{{ $item->nama_pelatihan }}"
                loading="lazy"
                class="size-full object-cover"
              >
              <x-ui.badge class="absolute left-3 top-3 bg-primary/90 text-primary-foreground backdrop-blur">
                {{ $item->sumber_dana ?? 'Program pelatihan' }}
              </x-ui.badge>
            </div>

            <div class="flex flex-1 flex-col p-4">
              <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-primary">
                {{ $item->kategori ?? 'Kejuruan' }}
              </span>
              <h3 class="mt-1.5 text-sm font-bold leading-snug text-foreground">{{ $item->nama_pelatihan }}</h3>
              <p class="mt-1.5 line-clamp-3 text-xs leading-relaxed text-muted-foreground">{{ $item->deskripsi_pelatihan }}</p>

              <div class="mt-auto flex gap-2 pt-4">
                <x-ui.button
                  href="{{ route('pelatihan.katalog') . '#' . ($item->id_pelatihan ?? $item->id) }}"
                  variant="outline"
                  size="xs"
                  class="flex-1"
                >
                  Lihat silabus
                </x-ui.button>

                @guest
                  <x-ui.button href="{{ route('register') }}" size="xs" class="flex-1">
                    Daftar
                  </x-ui.button>
                @else
                  <x-ui.button href="{{ $dashboardUrl }}" size="xs" class="flex-1">
                    Dashboard
                  </x-ui.button>
                @endguest
              </div>
            </div>
          </x-ui.card>
        </div>
      @empty
        <x-ui.empty class="sm:col-span-2 lg:col-span-3">
          <x-ui.empty-header>
            <x-ui.empty-media variant="icon">
              <x-lucide-book-open />
            </x-ui.empty-media>
            <x-ui.empty-title>Belum ada data pelatihan aktif.</x-ui.empty-title>
            <x-ui.empty-description>Silakan cek kembali katalog pelatihan beberapa waktu lagi.</x-ui.empty-description>
          </x-ui.empty-header>
        </x-ui.empty>
      @endforelse
    </div>

    @if ($totalPelatihan > $pelatihanTampil->count())
      <div class="mt-8 flex flex-col items-center gap-3 text-center" data-reveal>
        <p class="text-xs text-muted-foreground">
          Menampilkan {{ $pelatihanTampil->count() }} dari {{ $totalPelatihan }} program pelatihan.
        </p>
        <x-ui.button href="{{ route('pelatihan.katalog') }}" variant="outline" class="font-bold">
          Lihat selengkapnya
          <x-lucide-arrow-right />
        </x-ui.button>
      </div>
    @endif
  </section>

  {{-- Lowongan --}}
  <section class="border-y border-border bg-muted/40 py-16 md:py-20">
    <div class="site-container">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div data-reveal>
          <x-ui.badge variant="secondary" class="gap-2 uppercase tracking-wide">
            <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
            Langkah berikutnya
          </x-ui.badge>
          <h2 class="mt-4 text-3xl font-black tracking-tight text-foreground sm:text-4xl">
            Peluang kerja<br>buat kamu kejar.
          </h2>
        </div>

        <x-ui.button href="{{ route('lowongan.katalog') }}" variant="ghost" class="font-bold text-primary">
          Semua lowongan
          <x-lucide-arrow-up-right />
        </x-ui.button>
      </div>

      <div class="mt-8 grid gap-4 md:grid-cols-3" data-reveal-group>
        @forelse ($lowonganTampil as $job)
          @php
            $jobAktif = in_array(strtolower((string) $job->status), ['aktif', 'dibuka', 'buka'], true);
          @endphp

          <x-ui.card class="flex flex-col overflow-hidden p-0 transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-md">
            @if ($job->gambar_url)
              <img
                src="{{ $job->gambar_url }}"
                onerror="this.onerror=null;this.src='{{ $fallbackImg }}'"
                alt="{{ $job->judul_lowongan }}"
                class="aspect-[16/9] w-full object-cover"
                loading="lazy"
              >
            @else
              <div class="grid aspect-[16/9] w-full place-items-center bg-accent text-accent-foreground">
                <x-lucide-building-2 class="size-8" />
              </div>
            @endif

            <div class="flex flex-1 flex-col p-5">
              <div class="flex items-start justify-between gap-3">
                <h3 class="text-base font-bold leading-snug text-foreground">
                  <a href="{{ route('lowongan.detail', $job->id_lowongan) }}" class="transition hover:text-primary">
                    {{ $job->judul_lowongan }}
                  </a>
                </h3>
                <x-ui.badge class="shrink-0 capitalize {{ $jobAktif ? 'bg-emerald-100 text-emerald-800' : 'bg-muted text-muted-foreground' }}">
                  {{ $job->status }}
                </x-ui.badge>
              </div>

              <div class="mt-3 space-y-1.5 text-xs text-muted-foreground">
                <p class="flex items-center gap-2">
                  <x-lucide-building-2 class="size-3.5 text-primary" />
                  {{ $job->mitra->nama_perusahaan ?? '-' }}
                </p>
                <p class="flex items-center gap-2">
                  <x-lucide-map-pin class="size-3.5 text-primary" />
                  {{ $job->lokasi ?? '-' }}
                </p>
              </div>

              <p class="mt-4 line-clamp-3 text-xs leading-relaxed text-muted-foreground">
                {{ $job->deskripsi ?? 'Tidak ada deskripsi.' }}
              </p>

              <div class="mt-auto flex items-center justify-between gap-3 border-t border-border pt-4">
                <div class="text-[10px] text-muted-foreground">
                  Diposting
                  <span class="mt-0.5 block text-xs font-bold text-foreground">
                    {{ $job->tanggal_posting ? \Carbon\Carbon::parse($job->tanggal_posting)->translatedFormat('d M Y') : '-' }}
                  </span>
                </div>

                <x-ui.button href="{{ route('lowongan.detail', $job->id_lowongan) }}" size="sm">
                  Lihat selengkapnya
                  <x-lucide-arrow-right />
                </x-ui.button>
              </div>
            </div>
          </x-ui.card>
        @empty
          <x-ui.empty class="md:col-span-3">
            <x-ui.empty-header>
              <x-ui.empty-media variant="icon">
                <x-lucide-briefcase-business />
              </x-ui.empty-media>
              <x-ui.empty-title>Belum ada lowongan aktif saat ini.</x-ui.empty-title>
              <x-ui.empty-description>Lowongan baru dari mitra industri akan tampil di sini.</x-ui.empty-description>
            </x-ui.empty-header>
          </x-ui.empty>
        @endforelse
      </div>

      @if ($totalLowongan > $lowonganTampil->count())
        <div class="mt-8 flex flex-col items-center gap-3 text-center" data-reveal>
          <p class="text-xs text-muted-foreground">
            Menampilkan {{ $lowonganTampil->count() }} dari {{ $totalLowongan }} lowongan.
          </p>
          <x-ui.button href="{{ route('lowongan.katalog') }}" variant="outline" class="font-bold">
            Lihat selengkapnya
            <x-lucide-arrow-right />
          </x-ui.button>
        </div>
      @endif
    </div>
  </section>

  {{-- Alur pendaftaran --}}
  <section class="site-container py-16 md:py-20">
    <div class="max-w-2xl" data-reveal>
      <x-ui.badge variant="secondary" class="gap-2 uppercase tracking-wide">
        <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
        Alurnya transparan
      </x-ui.badge>
      <h2 class="mt-4 text-3xl font-black tracking-tight text-foreground sm:text-4xl">
        Empat langkah buat<br>mulai perjalananmu.
      </h2>
    </div>

    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
      @foreach ([
          ['title' => 'Buat akun', 'desc' => 'Daftarkan akun siKarir menggunakan NIK yang valid dan lengkapi profil.'],
          ['title' => 'Pilih kejuruan', 'desc' => 'Cari program aktif yang sesuai minat, jadwal, dan kuota.'],
          ['title' => 'Ikuti seleksi', 'desc' => 'Jalani tes tertulis online dan verifikasi wawancara di workshop BLK.'],
          ['title' => 'Belajar & sertifikasi', 'desc' => 'Ikuti pelatihan hingga uji kompetensi resmi BNSP.'],
      ] as $step)
        <div class="relative">
          <span class="grid size-11 place-items-center rounded-full border border-border bg-card text-xs font-black text-primary shadow-sm">
            {{ sprintf('%02d', $loop->iteration) }}
          </span>
          <h3 class="mt-4 text-base font-bold text-foreground">{{ $step['title'] }}</h3>
          <p class="mt-1.5 text-xs leading-relaxed text-muted-foreground">{{ $step['desc'] }}</p>
        </div>
      @endforeach
    </div>
  </section>

  {{-- FAQ (Alpine, tanpa plugin tambahan) --}}
  <section class="site-container pb-16 md:pb-20" x-data="{ open: null }">
    <div class="max-w-2xl" data-reveal>
      <h2 class="text-3xl font-black tracking-tight text-foreground sm:text-4xl">
        Pertanyaan yang<br>sering muncul.
      </h2>
    </div>

    <div class="mt-8 divide-y divide-border overflow-hidden rounded-2xl border border-border bg-card" data-reveal>
      @foreach ([
          ['q' => 'Apakah pelatihan benar-benar gratis?', 'a' => 'Program reguler dibiayai APBD dan APBN, sehingga peserta tidak dipungut biaya pelatihan.'],
          ['q' => 'Apa saja syarat untuk mendaftar?', 'a' => 'Buat akun siKarir dengan NIK yang valid, lengkapi profil, lalu ikuti tes tertulis online dan wawancara di workshop BLK.'],
          ['q' => 'Bagaimana cara mengecek keaslian sertifikat?', 'a' => 'Gunakan layanan verifikasi sertifikat yang tersedia di portal siKarir.'],
          ['q' => 'Apakah lowongan kerja hanya untuk alumni BLK?', 'a' => 'Tidak. Bursa kerja terbuka bagi alumni vokasi maupun pencari kerja umum.'],
      ] as $i => $faq)
        <div>
          <button
            type="button"
            @click="open = open === {{ $i }} ? null : {{ $i }}"
            :aria-expanded="open === {{ $i }}"
            class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left text-sm font-bold text-foreground transition hover:bg-muted/50"
          >
            {{ $faq['q'] }}
            <x-lucide-chevron-down
              class="size-4 shrink-0 transition-transform duration-200"
              ::class="open === {{ $i }} ? 'rotate-180' : ''"
            />
          </button>

          <div
            x-show="open === {{ $i }}"
            x-transition.opacity.duration.150ms
            style="display: none;"
          >
            <p class="px-5 pb-4 text-sm leading-relaxed text-muted-foreground">{{ $faq['a'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- CTA --}}
  <section class="site-container py-16 md:py-20" data-reveal>
    <x-ui.card class="relative overflow-hidden border-primary/30 bg-gradient-to-br from-primary via-[#0d4335] to-[#0a2f26] text-primary-foreground">
      <div class="pointer-events-none absolute -right-16 -top-16 size-56 rounded-full bg-sikarir-lime/10 blur-3xl"></div>

      <div class="relative flex flex-col items-start gap-8 md:flex-row md:items-center md:justify-between">
        <div class="max-w-2xl">
          <x-ui.badge class="gap-2 border-primary-foreground/20 bg-primary-foreground/10 text-primary-foreground">
            <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
            Masa depan dimulai dari skill
          </x-ui.badge>

          @guest
            <h2 class="mt-4 text-3xl font-black tracking-tight text-white sm:text-4xl">Siap mulai langkah barumu?</h2>
            <p class="mt-3 text-sm leading-relaxed text-primary-foreground/75">
              Daftar akun siKarir, temukan program yang cocok, dan siapkan diri untuk peluang berikutnya.
            </p>
          @else
            <h2 class="mt-4 text-3xl font-black tracking-tight text-white sm:text-4xl">Lanjutkan langkahmu.</h2>
            <p class="mt-3 text-sm leading-relaxed text-primary-foreground/75">
              Kamu sudah masuk. Buka dashboard untuk melanjutkan proses pendaftaran dan memantau perkembanganmu.
            </p>
          @endguest
        </div>

        @guest
          <x-ui.button href="{{ route('register') }}" size="lg" class="shrink-0 bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            Buat akun siKarir
            <x-lucide-arrow-up-right />
          </x-ui.button>
        @else
          <x-ui.button href="{{ $dashboardUrl }}" size="lg" class="shrink-0 bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            Buka dashboard
            <x-lucide-arrow-up-right />
          </x-ui.button>
        @endguest
      </div>
    </x-ui.card>
  </section>

  <script>
    (function () {
      var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

      // 1) Reveal saat scroll
      var targets = document.querySelectorAll('[data-reveal], [data-reveal-group]');
      document.querySelectorAll('[data-reveal-group]').forEach(function (g) {
        Array.prototype.forEach.call(g.children, function (child, i) {
          child.style.setProperty('--i', Math.min(i, 8));
        });
      });

      if (!('IntersectionObserver' in window)) {
        targets.forEach(function (el) { el.classList.add('is-visible'); });
      } else {
        var io = new IntersectionObserver(function (entries) {
          entries.forEach(function (e) {
            if (e.isIntersecting) {
              e.target.classList.add('is-visible');
              io.unobserve(e.target);
            }
          });
        }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
        targets.forEach(function (el) { io.observe(el); });
      }

      // 2) Progress bar + parallax hero
      var bar = document.getElementById('sk-progress');
      var para = document.querySelector('[data-parallax]');
      var ticking = false;

      function update() {
        var y = window.scrollY || window.pageYOffset;
        var max = document.documentElement.scrollHeight - window.innerHeight;
        if (bar) bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(y / max, 1) : 0) + ')';
        if (para && !reduce && y < 900) {
          para.style.transform = 'translate3d(0,' + (y * 0.18) + 'px,0) scale(1.12)';
        }
        ticking = false;
      }

      window.addEventListener('scroll', function () {
        if (!ticking) { ticking = true; requestAnimationFrame(update); }
      }, { passive: true });
      update();
    })();
  </script>
@endsection
