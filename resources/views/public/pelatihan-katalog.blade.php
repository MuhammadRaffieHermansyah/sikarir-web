@extends('layouts.public')

@section('title', 'Katalog Pelatihan Vokasi - siKarir UPT BLK Jember')

@section('content')
  {{-- HERO --}}
  <section class="relative isolate overflow-hidden bg-primary text-primary-foreground">
    <img
      src="{{ asset('images/hero-image.webp') }}"
      alt=""
      class="absolute inset-0 size-full object-cover object-center opacity-30"
    >
    <div class="absolute inset-0 bg-gradient-to-r from-[#04281f]/95 via-[#04281f]/88 to-[#04281f]/30"></div>
    <div class="pointer-events-none absolute -bottom-24 right-[6%] size-32 rounded-full border border-sikarir-lime/40"></div>

    <div class="site-container relative py-16 md:py-20">
      <x-ui.badge class="gap-2 border-primary-foreground/20 bg-primary-foreground/10 text-primary-foreground">
        <x-lucide-shield-check class="text-sikarir-lime" />
        Pendidikan vokasi terakreditasi Kemnaker RI &amp; BNSP
      </x-ui.badge>

      <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_20rem] lg:items-end">
        <div>
          <h1 class="max-w-3xl text-4xl font-black leading-[0.95] tracking-[-0.06em] text-white sm:text-5xl lg:text-6xl">
            Katalog program.<br>
            <span class="text-sikarir-lime">Pelatihan kerja &amp; vokasi.</span>
          </h1>

          <p class="mt-5 max-w-2xl text-sm leading-relaxed text-primary-foreground/80 sm:text-base">
            Tingkatkan keahlian kerja nyata Anda tanpa biaya. Seluruh program pelatihan vokasi di UPT Balai Latihan Kerja Jember didanai
            <span class="font-bold text-sikarir-lime">100% Gratis</span> melalui pembiayaan APBD Provinsi Jawa Timur dan APBN Kemnaker RI.
          </p>
        </div>

        <x-ui.card class="hidden border-primary-foreground/15 bg-primary-foreground/10 p-5 text-primary-foreground backdrop-blur-md lg:block">
          <div class="flex items-center justify-between gap-3 border-b border-primary-foreground/15 pb-3">
            <span class="flex items-center gap-2 text-sm font-bold text-white">
              <x-lucide-wallet class="text-sikarir-lime" />
              Alokasi anggaran
            </span>
            <x-ui.badge class="border-primary-foreground/25 bg-primary-foreground/10 text-sikarir-lime">DIPA 2026</x-ui.badge>
          </div>

          <p class="mt-3 text-xs leading-relaxed text-primary-foreground/75">
            Penyelenggaraan pelatihan berbasis Unit Kompetensi SKKNI dengan penjaminan mutu Lembaga Sertifikasi Profesi Pihak Pertama (LSP-P1).
          </p>
        </x-ui.card>
      </div>
    </div>
  </section>

  {{-- STAT STRIP --}}
  <section class="site-container relative z-10 -mt-8 mb-8">
    <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
      @foreach ([
          ['icon' => 'cpu', 'value' => (string) \App\Models\DaftarPelatihan::count(), 'label' => 'Kejuruan aktif'],
          ['icon' => 'users', 'value' => (string) \App\Models\JadwalPelatihan::where('status', 'berlangsung')->count(), 'label' => 'Batch berjalan'],
          ['icon' => 'circle-dollar-sign', 'value' => '100%', 'label' => 'Gratis bebas biaya'],
          ['icon' => 'award', 'value' => 'BNSP', 'label' => 'Sertifikasi resmi'],
      ] as $stat)
        <x-ui.stat
          :icon="$stat['icon']"
          :value="$stat['value']"
          :label="$stat['label']"
          class="gap-2.5 p-4 shadow-sm"
        />
      @endforeach
    </div>
  </section>


  <div class="site-container space-y-8 py-10 md:py-14">
    {{-- SEARCH & FILTER --}}
    <x-ui.card>
      <form id="katalog-filter" method="GET" action="{{ route('pelatihan.katalog') }}" data-results-url="{{ route('pelatihan.katalog.hasil') }}" class="grid gap-3 md:grid-cols-12">
        <div class="md:col-span-8">
          <x-ui.field>
            <x-ui.field-label for="katalog-q" class="sr-only">Cari pelatihan</x-ui.field-label>
            <x-ui.input
              id="katalog-q"
              name="q"
              type="search"
              :value="request('q')"
              placeholder="Ketik kejuruan, keterampilan (cth: Sepeda Motor, Web, Las, Barista)..."
            >
              <x-slot:leading>
                <x-lucide-search />
              </x-slot:leading>
            </x-ui.input>
          </x-ui.field>
        </div>

        <div class="flex gap-2 md:col-span-4">
          <div class="min-w-0 flex-1">
            <x-ui.field>
              <x-ui.field-label for="katalog-status" class="sr-only">Status pendaftaran</x-ui.field-label>
              <x-ui.select name="status" id="katalog-status" native class="w-full">
                <option value="">Semua Status</option>
                <option value="buka" @selected(request('status') === 'buka')>Pendaftaran Buka</option>
                <option value="tutup" @selected(request('status') === 'tutup')>Tidak Ada Jadwal Buka</option>
              </x-ui.select>
            </x-ui.field>
          </div>

          <x-ui.button href="{{ route('pelatihan.katalog') }}" variant="outline" aria-label="Reset filter" title="Reset filter">
            <x-lucide-rotate-ccw />
          </x-ui.button>
        </div>
      </form>

    </x-ui.card>

    {{-- RESULT COUNTER --}}
    <div class="flex flex-wrap items-center justify-between gap-2 px-1 text-xs font-medium text-muted-foreground">
      <p class="flex items-center gap-1.5 font-bold text-foreground">
        <x-lucide-book-open class="size-4 text-primary" />
        Menampilkan
        <span id="katalog-count">{{ $pelatihan->count() }}</span>
        Program Pelatihan Terbaru
      </p>

      <span class="flex items-center gap-1.5 font-bold text-primary">
        <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
        Terverifikasi DIPA 2026
      </span>
    </div>

    {{-- GRID PELATIHAN --}}
    <div id="katalog-grid" class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
      @include('public.partials.pelatihan-grid', ['pelatihan' => $pelatihan])
    </div>
  </div>

  {{-- HAK & FASILITAS PESERTA --}}
  <section class="border-y border-border bg-muted/40 py-14">
    <div class="site-container text-center">
      <x-ui.badge variant="secondary" class="uppercase tracking-wide">Hak &amp; Fasilitas Peserta</x-ui.badge>

      <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground md:text-3xl">
        Apa saja yang didapatkan siswa pelatihan?
      </h2>
      <p class="mx-auto mt-2 max-w-lg text-sm text-muted-foreground">
        Sarana digunakan sesuai program, jadwal, dan ketentuan penyelenggaraan yang berlaku.
      </p>

      <div class="mt-10 grid gap-4 text-left md:grid-cols-3 lg:grid-cols-5">
        @foreach ([
            ['icon' => 'school', 'title' => 'Ruang Kelas', 'desc' => 'Ruang pembelajaran tersedia untuk pelaksanaan materi teori sesuai jadwal pelatihan.'],
            ['icon' => 'wrench', 'title' => 'Workshop & Peralatan', 'desc' => 'Workshop dan peralatan praktik tersedia sesuai kejuruan yang diselenggarakan.'],
            ['icon' => 'book-open', 'title' => 'Perpustakaan', 'desc' => 'Peserta dapat memanfaatkan sumber belajar yang tersedia di lingkungan balai.'],
            ['icon' => 'briefcase-business', 'title' => 'Kios SIAPkerja', 'desc' => 'Tersedia titik layanan untuk mengakses informasi layanan ketenagakerjaan SIAPkerja.'],
            ['icon' => 'bed-double', 'title' => 'Asrama', 'desc' => 'Tersedia di balai; penggunaan dan ketersediaannya mengikuti ketentuan setiap program.'],
        ] as $f)
          <x-ui.card class="transition hover:border-primary/40">
            <span class="grid size-10 place-items-center rounded-xl bg-accent text-accent-foreground">
              <x-dynamic-component :component="'lucide-'.$f['icon']" class="size-5" />
            </span>

            <h3 class="mt-3 text-sm font-bold text-foreground">{{ $f['title'] }}</h3>
            <p class="mt-1.5 text-xs leading-relaxed text-muted-foreground">{{ $f['desc'] }}</p>
          </x-ui.card>
        @endforeach
      </div>
    </div>
  </section>

  {{-- SYARAT & JADWAL --}}
  <section class="site-container grid gap-10 py-14 md:grid-cols-2">
    {{-- Syarat --}}
    <div class="space-y-6">
      <div>
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Pedoman Pendaftaran</x-ui.badge>

        <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground">
          Syarat calon peserta &amp; kelengkapan berkas
        </h2>
        <p class="mt-1.5 text-sm text-muted-foreground">
          Ikuti informasi pada program dan jadwal yang sedang dibuka. Persyaratan administrasi dapat berbeda menurut kejuruan dan sumber pembiayaannya.
        </p>
      </div>

      <div class="grid gap-3 text-xs md:grid-cols-2">
        @foreach ([
            ['title' => 'Pilih program yang dibuka', 'desc' => 'Periksa status pendaftaran, tanggal, dan kuota pada katalog pelatihan.'],
            ['title' => 'Daftar lewat aplikasi', 'desc' => 'Pendaftaran program dilakukan di aplikasi siKarir dengan akun peserta.'],
            ['title' => 'Lengkapi data sesuai pengumuman', 'desc' => 'Siapkan berkas hanya sesuai syarat yang dicantumkan untuk program pilihan.'],
            ['title' => 'Ikuti tahapan seleksi', 'desc' => 'Seleksi atau verifikasi hanya dilakukan jika tercantum pada pengumuman program.'],
            ['title' => 'Pantau pengumuman', 'desc' => 'Jadwal dan hasil seleksi mengikuti informasi resmi dari penyelenggara.'],
            ['title' => 'Konfirmasi bila perlu', 'desc' => 'Hubungi UPT BLK Jember sebelum datang atau mengirim berkas tambahan.'],
        ] as $syarat)
          <div class="flex gap-2.5 rounded-xl border border-border bg-card p-3 shadow-xs">
            <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
            <div>
              <h4 class="text-xs font-bold text-foreground">{{ $syarat['title'] }}</h4>
              <p class="mt-0.5 text-[11px] leading-relaxed text-muted-foreground">{{ $syarat['desc'] }}</p>
            </div>
          </div>
        @endforeach
      </div>

      <div class="pt-2">
        <h3 class="mb-3 flex items-center gap-1.5 text-xs font-bold uppercase tracking-wide text-primary">
          <x-lucide-circle-arrow-right class="size-4" />
          4 Langkah Mudah Pendaftaran
        </h3>

        <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
          @foreach ([
              ['no' => '1', 'title' => 'Pilih Program', 'desc' => 'Pilih program dengan jadwal pendaftaran terbuka.'],
              ['no' => '2', 'title' => 'Pasang Aplikasi', 'desc' => 'Daftar atau masuk di aplikasi siKarir.'],
              ['no' => '3', 'title' => 'Daftar Program', 'desc' => 'Pilih program di aplikasi dan lengkapi data yang diminta.'],
              ['no' => '4', 'title' => 'Pantau Status', 'desc' => 'Ikuti pengumuman dari penyelenggara program.'],
          ] as $step)
            <div class="space-y-1 rounded-xl border border-border bg-muted/40 p-3">
              <div class="grid size-6 place-items-center rounded-full bg-primary text-[11px] font-black text-primary-foreground">
                {{ $step['no'] }}
              </div>
              <h4 class="text-xs font-bold text-foreground">{{ $step['title'] }}</h4>
              <p class="text-[10px] leading-relaxed text-muted-foreground">{{ $step['desc'] }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Jadwal Gelombang --}}
    <div class="space-y-6">
      <div>
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Kalender Pelatihan</x-ui.badge>

        <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground">Jadwal gelombang pelatihan</h2>
        <p class="mt-1.5 text-sm text-muted-foreground">
          Jadwal berikut diambil langsung dari program pelatihan yang telah dipublikasikan.
        </p>
      </div>

      <div class="space-y-3">
        @forelse ($kalenderPelatihan as $jadwalKalender)
          <x-ui.card class="p-4">
            <div class="flex items-center justify-between gap-3">
              <h3 class="flex items-center gap-1.5 text-sm font-bold text-foreground">
                <x-lucide-calendar class="size-4 text-primary" />
                {{ $jadwalKalender->pelatihan?->nama_pelatihan ?? 'Program pelatihan' }}
              </h3>

              @if ($jadwalKalender->status === 'tersedia')
                <x-ui.badge variant="solid" tone="success">Pendaftaran Buka</x-ui.badge>
              @else
                <x-ui.badge variant="soft" tone="neutral">{{ \Illuminate\Support\Str::headline($jadwalKalender->status) }}</x-ui.badge>
              @endif
            </div>

            <div class="mt-3 space-y-1 rounded-xl border border-border bg-muted/40 p-3 text-xs font-medium text-muted-foreground">
              <p class="flex justify-between gap-3"><span>Pelaksanaan:</span> <span class="font-bold text-foreground">{{ $jadwalKalender->tanggal_mulai->translatedFormat('d M Y') }} – {{ $jadwalKalender->tanggal_selesai->translatedFormat('d M Y') }}</span></p>
              @if ($jadwalKalender->jam_mulai && $jadwalKalender->jam_selesai)
                <p class="flex justify-between gap-3"><span>Jam:</span> <span class="font-bold text-foreground">{{ \Carbon\Carbon::parse($jadwalKalender->jam_mulai)->format('H.i') }} – {{ \Carbon\Carbon::parse($jadwalKalender->jam_selesai)->format('H.i') }}</span></p>
              @endif
              @if ($jadwalKalender->ruanganWorkshop)
                <p class="flex justify-between gap-3"><span>Lokasi:</span> <span class="font-bold text-foreground">{{ $jadwalKalender->ruanganWorkshop->nama_ruangan }}</span></p>
              @endif
            </div>
          </x-ui.card>
        @empty
          <x-ui.empty class="bg-card">
            <x-ui.empty-header>
              <x-ui.empty-media variant="icon"><x-lucide-calendar-x /></x-ui.empty-media>
              <x-ui.empty-title>Belum ada jadwal mendatang</x-ui.empty-title>
              <x-ui.empty-description>Jadwal pelatihan akan tampil di sini setelah dipublikasikan.</x-ui.empty-description>
            </x-ui.empty-header>
          </x-ui.empty>
        @endforelse
      </div>

    </div>
  </section>

  {{-- FAQ --}}
  <section class="border-t border-border bg-muted/40 py-14">
    <div class="site-container max-w-3xl space-y-8 text-center">
      <div>
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Pusat Bantuan &amp; Informasi</x-ui.badge>

        <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground md:text-3xl">Pertanyaan umum (FAQ)</h2>
        <p class="mt-2 text-sm text-muted-foreground">
          Segala hal yang sering ditanyakan calon siswa seputar seleksi dan proses pelatihan di BLK Jember.
        </p>
      </div>

      <div class="space-y-3 text-left">
        @foreach ([
            'Bagaimana cara mengetahui program yang sedang dibuka?' => 'Gunakan filter status “Pendaftaran Buka” pada katalog. Status mengikuti jadwal pelatihan yang dipublikasikan.',
            'Apakah syarat setiap program sama?' => 'Tidak selalu. Persyaratan administrasi, kualifikasi, dan tahapan seleksi mengikuti pengumuman pada program yang dipilih.',
            'Kapan jadwal pelatihan diperbarui?' => 'Kalender pada halaman ini menampilkan jadwal mendatang yang sudah dicatat oleh penyelenggara.',
            'Apakah semua peserta memperoleh fasilitas yang sama?' => 'Tidak. Sarana dan fasilitas yang digunakan menyesuaikan kejuruan, jadwal, serta ketentuan program.',
            'Apakah peserta akan memperoleh sertifikat?' => 'Ketentuan sertifikat mengikuti kelulusan dan aturan program pelatihan yang diikuti. Konfirmasikan pada pengumuman program bila diperlukan.',
        ] as $q => $a)
          <details class="group rounded-xl border border-border bg-card p-4 shadow-xs">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-3 text-xs font-bold text-foreground">
              <span>{{ $q }}</span>
              <x-lucide-chevron-down class="size-4 shrink-0 text-muted-foreground transition-transform group-open:rotate-180" />
            </summary>

            <p class="mt-2.5 border-t border-border pt-2.5 text-xs leading-relaxed text-muted-foreground">
              {{ $a }}
            </p>
          </details>
        @endforeach
      </div>

      <x-ui.card class="flex flex-col gap-4 border-primary/30 bg-accent text-left sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
          <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary text-primary-foreground">
            <x-lucide-message-square class="size-5" />
          </span>

          <div>
            <h4 class="text-xs font-bold text-foreground">Masih memiliki pertanyaan lain?</h4>
            <p class="mt-0.5 text-[11px] text-muted-foreground">
              Konsultasikan minat kejuruan Anda bersama konselor vokasi kami setiap hari kerja.
            </p>
          </div>
        </div>

        <x-ui.button
          href="https://wa.me/{{ config('blk.wa') }}"
          target="_blank"
          rel="noopener"
          class="shrink-0 bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]"
        >
          <x-lucide-message-circle />
          WhatsApp
        </x-ui.button>
      </x-ui.card>
    </div>
  </section>

  <script>
    (() => {
      const form = document.getElementById('katalog-filter');
      const input = document.getElementById('katalog-q');
      const status = document.getElementById('katalog-status');
      const grid = document.getElementById('katalog-grid');
      const count = document.getElementById('katalog-count');
      if (!form || !input || !status || !grid || !count) return;

      let debounceTimer;
      let controller;
      const updateResults = async () => {
        controller?.abort();
        controller = new AbortController();
        const params = new URLSearchParams(new FormData(form));
        const url = new URL(form.dataset.resultsUrl, window.location.origin);
        url.search = params.toString();
        grid.setAttribute('aria-busy', 'true');

        try {
          const response = await fetch(url, { headers: { Accept: 'application/json' }, signal: controller.signal });
          if (!response.ok) throw new Error('Gagal memuat hasil pelatihan.');
          const result = await response.json();
          grid.innerHTML = result.html;
          count.textContent = result.count;
          window.history.replaceState({}, '', `${form.action}${params.toString() ? `?${params}` : ''}`);
        } catch (error) {
          if (error.name !== 'AbortError') console.error(error);
        } finally {
          grid.removeAttribute('aria-busy');
        }
      };

      input.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(updateResults, 350);
      });
      status.addEventListener('change', updateResults);
      form.addEventListener('submit', (event) => { event.preventDefault(); updateResults(); });
    })();
  </script>
@endsection
