@extends('layouts.public')

@section('title', 'Tentang BLK - siKarir UPT BLK Jember')

@section('content')
  {{-- HERO --}}
  <section class="relative isolate overflow-hidden bg-primary text-primary-foreground">
    <div class="pointer-events-none absolute -left-24 -top-24 size-96 rounded-full bg-primary-foreground/5 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-24 -right-16 size-96 rounded-full border border-sikarir-lime/20"></div>

    <div class="site-container relative py-16 md:py-20">
      <x-ui.badge class="gap-2 border-primary-foreground/20 bg-primary-foreground/10 text-primary-foreground">
        <x-lucide-building-2 class="text-sikarir-lime" />
        Lembaga vokasi Pemerintah Provinsi Jawa Timur
      </x-ui.badge>

      <h1 class="mt-6 max-w-3xl text-4xl font-black leading-[0.95] tracking-[-0.06em] text-white sm:text-5xl lg:text-6xl">
        Profil &amp; komitmen kejuruan.<br>
        <span class="text-sikarir-lime">UPT BLK Jember.</span>
      </h1>

      <p class="mt-5 max-w-xl text-sm leading-relaxed text-primary-foreground/80 sm:text-base">
        Lembaga Pelatihan Vokasi Pemerintah Provinsi Jawa Timur Pencetak Tenaga Terampil Siap Kerja, Berdaya Saing Global, dan Tersertifikasi
        Nasional BNSP melalui pembiayaan APBD &amp; APBN secara gratis dan transparan.
      </p>

      <div class="mt-8 grid grid-cols-2 gap-4 border-t border-primary-foreground/15 pt-6 sm:grid-cols-4">
        @foreach ([
            ['value' => '12+', 'label' => 'Kejuruan Unggulan'],
            ['value' => '94.8%', 'label' => 'Kelulusan BNSP'],
            ['value' => '180+', 'label' => 'Mitra Industri (DUDI)'],
            ['value' => '31', 'label' => 'Kecamatan MTU Jember'],
        ] as $s)
          <div>
            <p class="text-2xl font-black text-sikarir-lime md:text-3xl">{{ $s['value'] }}</p>
            <p class="mt-0.5 text-[10px] font-medium text-primary-foreground/65 md:text-xs">{{ $s['label'] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- SEJARAH & LANDASAN HUKUM --}}
  <section class="site-container grid items-start gap-8 py-12 md:grid-cols-12 md:py-16">
    <div class="space-y-4 md:col-span-5">
      <div>
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Fondasi Regulasi &amp; Integritas</x-ui.badge>

        <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground">
          Sejarah singkat &amp; landasan hukum
        </h2>
      </div>

      <p class="text-sm leading-relaxed text-muted-foreground">
        Berdiri sebagai garda terdepan penyiapan SDM terampil di Kawasan Tapal Kuda Jawa Timur, UPT BLK Jember mengemban amanat pencetakan
        tenaga produktif, mandiri, dan bermartabat.
      </p>

      <x-ui.card class="flex gap-3 border-primary/25 bg-accent">
        <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-primary text-primary-foreground">
          <x-lucide-book-open-check class="size-5" />
        </span>

        <div class="space-y-1">
          <h4 class="text-xs font-bold text-foreground">Dasar Pembentukan Lembaga</h4>
          <p class="text-[11px] leading-relaxed text-muted-foreground">
            Peraturan Gubernur Jawa Timur Nomor 59 Tahun 2018 tentang Nomenklatur, Susunan Organisasi, Uraian Tugas dan Fungsi serta Tata
            Kerja UPT Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur.
          </p>
        </div>
      </x-ui.card>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 md:col-span-7">
      @foreach ([
          ['icon' => 'building', 'title' => 'Organisasi Publik Mandiri', 'desc' => 'UPT BLK Jember beroperasi di bawah binaan langsung Disnakertrans Jatim. Memiliki wewenang teknis mengelola workshop vokasi, pelatihan boarding/non-boarding, dan uji sertifikasi keahlian.', 'link' => 'Dibiayai APBD Prov. Jatim & APBN RI'],
          ['icon' => 'circle-dollar-sign', 'title' => '100% Bebas Biaya (Gratis)', 'desc' => 'Seluruh peserta pelatihan program reguler tidak dipungut biaya pendaftaran, konsumsi, modul belajar, seragam, hingga biaya uji kompetensi BNSP pertama.', 'link' => 'Transparansi Seleksi Berbasis Merit'],
          ['icon' => 'link-2', 'title' => 'Link & Match DUDI', 'desc' => 'Kurikulum silabus diselaraskan berkala dengan asosiasi profesi dan konsorsium industri manufaktur, bengkel resmi, garmen skala ekspor, serta industri TI agar serapan lulusan maksimal.', 'link' => 'Sinkronisasi Rutin Kurikulum Kerja'],
          ['icon' => 'users', 'title' => 'Layanan Ramah & Inklusif', 'desc' => 'Akses pendaftaran daring melalui platform siKarir dan layanan tatap muka di PTSP Kampus BLK Jember ramah terhadap kelompok disabilitas, perempuan kepala keluarga, serta pemuda pencari kerja.', 'link' => 'Standar Pelayanan Publik Nasional'],
      ] as $item)
        <x-ui.card class="flex flex-col justify-between gap-3 transition hover:border-primary/40">
          <div class="space-y-2">
            <span class="grid size-9 place-items-center rounded-xl bg-accent text-accent-foreground">
              <x-dynamic-component :component="'lucide-'.$item['icon']" class="size-4" />
            </span>

            <h3 class="text-xs font-bold text-foreground">{{ $item['title'] }}</h3>
            <p class="text-[11px] leading-relaxed text-muted-foreground">{{ $item['desc'] }}</p>
          </div>

          <div class="flex items-center gap-1 border-t border-border pt-2 text-[10px] font-bold text-primary">
            <x-lucide-check class="size-3" />
            <span>{{ $item['link'] }}</span>
          </div>
        </x-ui.card>
      @endforeach
    </div>
  </section>

  {{-- VISI & MISI --}}
  <section class="border-y border-border bg-muted/40 py-14">
    <div class="site-container space-y-8">
      <div class="mx-auto max-w-xl space-y-2 text-center">
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Cita-cita &amp; Arah Strategi</x-ui.badge>

        <h2 class="text-2xl font-black tracking-tight text-foreground">Visi &amp; misi kelembagaan</h2>
        <p class="text-sm text-muted-foreground">
          Pedoman langkah UPT BLK Jember dalam mewujudkan kedaulatan ketenagakerjaan di Jawa Timur.
        </p>
      </div>

      <div class="grid items-stretch gap-8 md:grid-cols-12">
        {{-- Visi --}}
        <x-ui.card class="flex flex-col justify-between gap-6 border-primary bg-gradient-to-br from-primary via-[#0c3f31] to-[#0a2b23] p-6 text-primary-foreground md:col-span-5 md:p-8">
          <div class="space-y-4">
            <x-ui.badge class="border-primary-foreground/25 bg-primary-foreground/10 uppercase tracking-wide text-sikarir-lime">
              <x-lucide-compass class="size-3.5" />
              Visi UPT BLK Jember
            </x-ui.badge>

            <h3 class="text-lg font-black leading-snug text-white md:text-xl">
              &ldquo;Terwujudnya Tenaga Kerja yang Kompeten, Berkarakter Industri, Mandiri, dan Berdaya Saing Global.&rdquo;
            </h3>

            <p class="text-xs leading-relaxed text-primary-foreground/75">
              Menjadi pusat unggulan pelatihan vokasi Jawa Timur yang responsif terhadap otomatisasi industri, adaptif terhadap inovasi hijau,
              dan berakar pada etos kedisiplinan Nusantara.
            </p>
          </div>

          <div class="flex items-center gap-2 border-t border-primary-foreground/15 pt-6 text-[11px] font-medium text-sikarir-lime">
            <x-lucide-circle-check-big class="size-4" />
            <span>Terintegrasi dengan Renstra Disnakertrans Jatim 2024-2029</span>
          </div>
        </x-ui.card>

        {{-- Misi --}}
        <div class="space-y-3 md:col-span-7">
          @foreach ([
              ['no' => '01', 'title' => 'Pelatihan Berbasis Standar SKKNI', 'desc' => 'Menyelenggarakan pelatihan vokasi terstruktur yang mengacu secara ketat pada Standar Kompetensi Kerja Nasional Indonesia (SKKNI) dan standar internasional yang diakui.'],
              ['no' => '02', 'title' => 'Kemitraan Strategis DUDI yang Mengikat', 'desc' => 'Memperluas kemitraan strategis dengan Dunia Usaha dan Dunia Industri (DUDI) dalam bentuk program On the Job Training (OJT), transfer instruktur tamu, dan rekrutmen langsung lulusan.'],
              ['no' => '03', 'title' => 'Fasilitasi Uji Kompetensi & Sertifikasi BNSP', 'desc' => 'Menjamin seluruh peserta yang menuntaskan pelatihan difasilitasi mengikuti asesmen kompetensi melalui LSP-P1 UPT BLK Jember untuk memperoleh sertifikasi berlisensi negara (BNSP RI).'],
              ['no' => '04', 'title' => 'Pemberantasan Pengangguran Terbuka di Tapal Kuda', 'desc' => 'Mendorong akselerasi penurunan Tingkat Pengangguran Terbuka (TPT) di Jember, Lumajang, Bondowoso, Situbondo, dan Banyuwangi melalui sinergi Bursa Kerja Khusus (BKK).'],
          ] as $misi)
            <x-ui.card class="flex items-start gap-4 p-4">
              <span class="mt-0.5 grid size-8 shrink-0 place-items-center rounded-xl bg-primary text-xs font-black text-primary-foreground">
                {{ $misi['no'] }}
              </span>

              <div class="space-y-0.5">
                <h4 class="text-xs font-bold text-foreground">{{ $misi['title'] }}</h4>
                <p class="text-[11px] leading-relaxed text-muted-foreground">{{ $misi['desc'] }}</p>
              </div>
            </x-ui.card>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- FASILITAS WORKSHOP --}}
  <section class="site-container space-y-8 py-12">
    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
      <div>
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Infrastruktur &amp; Sarana Belajar</x-ui.badge>

        <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground">
          Fasilitas workshop berstandar industri
        </h2>
        <p class="mt-1.5 max-w-2xl text-sm text-muted-foreground">
          Peralatan praktik mutakhir dan lingkungan kerja simulatif yang merefleksikan kondisi riil di pabrik manufaktur, bengkel resmi, dan
          kantor korporat modern.
        </p>
      </div>

      <x-ui.badge variant="secondary" size="lg" class="shrink-0 rounded-xl">
        <x-lucide-ruler class="text-primary" />
        Kampus Luas 3.8 Hektar
      </x-ui.badge>
    </div>

    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
      @foreach ([
          ['img' => 'https://images.unsplash.com/photo-1727893141025-35d62b3f4a03?q=80&w=1911&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'TEKNIK OTOMOTIF', 'title' => 'Gedung Workshop Otomotif', 'desc' => 'Dilengkapi scanner EFI multiport mutakhir, 4 unit engine stand bensin & diesel, mesin spooring-balancing digital, dan sepeda motor 4 tak terkini.', 'stats' => ['16 Workstation', 'Skema Teknisi R4/R2']],
          ['img' => 'https://images.unsplash.com/photo-1625745750125-5a072e15d1f5?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'TIK & MULTIMEDIA', 'title' => 'Lab TIK', 'desc' => 'Infrastruktur jaringan fiber optik gigabit independen, workstation berspesifikasi grafis kuat, lisensi software desain industri, serta studio podcast dan live streaming.', 'stats' => ['32 PC Unit', 'Junior Web & Desainer']],
          ['img' => 'https://plus.unsplash.com/premium_photo-1677695581626-2a75bdece138?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'GARMEN APPAREL', 'title' => 'Workshop Garmen Apparel', 'desc' => '30+ mesin jahit industri high-speed servo, mesin bordir otomatis komputer 12 kepala, mesin cutting kain vertikal, serta mesin obras standar pabrik garmen ekspor.', 'stats' => ['30+ Sewing Machines', 'Operator Garmen']],
          ['img' => 'https://images.unsplash.com/photo-1748348812466-8e29e1348f73?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'MANUFAKTUR LOGAM', 'title' => 'Workshop Las & CNC', 'desc' => 'Bilik las tertutup dengan sistem blower exhaust asap K3, unit mesin SMAW, GMAW / MIG-MAG, mesin las Argon TIG pipa, dan mesin pemotong plasma CNC.', 'stats' => ['18 Bilik Las K3', 'Plate Welder 3G/4G']],
          ['img' => 'https://images.unsplash.com/photo-1571474039046-42bc4e7f4b98?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'FASILITAS TINGGAL', 'title' => 'Asrama Peserta Pelatihan', 'desc' => 'Kapasitas 120 orang khusus peserta asal luar kecamatan atau luar kabupaten, mencakup kamar ber-AC/kipas higienis, makan 3x sehari bersubsidi, musholla, serta sarana olahraga.', 'stats' => ['Kapasitas 120 Siswa', 'Gratis Biaya Asrama']],
          ['img' => 'https://plus.unsplash.com/premium_photo-1663011474132-42003dd76fe0?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'WORKSHOP BAKERY', 'title' => 'Workshop Bakery', 'desc' => 'program pelatihan vokasi tata boga gratis yang dirancang untuk membekali masyarakat keterampilan praktis di bidang pengolahan makanan.', 'stats' => ['Kapasitas 50 Peserta', 'Junior Baker & Pastry Chef']],
      ] as $f)
        <x-ui.card class="flex flex-col justify-between overflow-hidden p-0 transition hover:border-primary/40 hover:shadow-md">
          <div>
            <div class="relative aspect-[16/9] overflow-hidden bg-muted">
              <img src="{{ $f['img'] }}" class="size-full object-cover" alt="{{ $f['title'] }}" loading="lazy">

              <x-ui.badge variant="solid" tone="neutral" class="absolute left-3 top-3 uppercase tracking-wide backdrop-blur-sm">
                {{ $f['tag'] }}
              </x-ui.badge>
            </div>

            <div class="space-y-2 p-5">
              <h3 class="text-sm font-bold leading-snug text-foreground md:text-base">{{ $f['title'] }}</h3>
              <p class="text-xs leading-relaxed text-muted-foreground">{{ $f['desc'] }}</p>
            </div>
          </div>

          <div class="flex justify-between gap-3 border-t border-border px-5 py-3 text-[10px] font-bold text-muted-foreground">
            <span class="flex items-center gap-1">
              <x-lucide-circle-check-big class="size-3.5 text-primary" />
              {{ $f['stats'][0] }}
            </span>
            <span class="flex items-center gap-1">
              <x-lucide-award class="size-3.5 text-primary" />
              {{ $f['stats'][1] }}
            </span>
          </div>
        </x-ui.card>
      @endforeach
    </div>
  </section>

  {{-- BUDAYA PELATIHAN --}}
  <section class="border-y border-border bg-muted/40 py-12">
    <div class="site-container space-y-8">
      <div>
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Karakter &amp; Etos Kerja</x-ui.badge>

        <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground">
          Budaya pelatihan industri &amp; instruktur unggul
        </h2>
        <p class="mt-1.5 max-w-2xl text-sm text-muted-foreground">
          Tidak hanya mengajarkan hard skills, UPT BLK Jember menanamkan nilai disiplin tinggi, K3, serta etos kerja standar korporasi
          internasional.
        </p>
      </div>

      <div class="grid items-stretch gap-8 md:grid-cols-12">
        <div class="space-y-4 md:col-span-7">
          <div class="grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['icon' => 'graduation-cap', 'title' => 'Instruktur Bersertifikasi', 'desc' => '100% instruktur bersertifikat metodologi pelatihan BNSP & ToT Nasional.'],
                ['icon' => 'shield-alert', 'title' => 'Protokol K3 Ketat', 'desc' => 'Penggunaan APD lengkap (helm, kacamata las, sepatu safety) diwajibkan sejak hari pertama.'],
                ['icon' => 'target', 'title' => 'Pendidikan FMD', 'desc' => 'Fisik, mental, dan disiplin (FMD) bekerjasama dengan TNI di masa orientasi.'],
            ] as $b)
              <x-ui.card class="space-y-2 p-4">
                <span class="grid size-9 place-items-center rounded-xl bg-accent text-accent-foreground">
                  <x-dynamic-component :component="'lucide-'.$b['icon']" class="size-4" />
                </span>

                <h4 class="text-xs font-bold text-foreground">{{ $b['title'] }}</h4>
                <p class="text-[11px] leading-relaxed text-muted-foreground">{{ $b['desc'] }}</p>
              </x-ui.card>
            @endforeach
          </div>

          <x-ui.card class="space-y-3 p-5">
            <h4 class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wide text-primary">
              <x-lucide-check-square class="size-4" />
              Penerapan Konsep 5R (5S) Industri
            </h4>

            <div class="flex flex-wrap gap-2">
              @foreach (['Ringkas / Seiri', 'Rapi / Seiton', 'Resik / Seiso', 'Rawat / Seiketsu', 'Rajin / Shitsuke'] as $r)
                <x-ui.badge variant="outline">{{ $r }}</x-ui.badge>
              @endforeach
            </div>

            <p class="text-xs leading-relaxed text-muted-foreground">
              Setiap sesi dimulai dan diakhiri dengan pembersihan mesin mandiri serta inspeksi alat guna membentuk kebiasaan kerja aman tanpa
              kompromi.
            </p>
          </x-ui.card>
        </div>

        {{-- Amanat Pimpinan --}}
        <x-ui.card class="flex flex-col justify-between gap-4 p-6 md:col-span-5">
          <div class="space-y-4">
            <x-ui.badge variant="secondary" class="uppercase tracking-wide">Amanat Pimpinan UPT</x-ui.badge>

            <div class="flex items-center gap-3">
              <img
                src="{{ asset('images/kepala.jpg') }}"
                class="size-12 shrink-0 rounded-full border border-border object-cover"
                alt="Kepala UPT BLK Jember"
                loading="lazy"
              >

              <div>
                <h4 class="text-xs font-bold text-foreground">Kepala UPT BLK Jember</h4>
                <p class="text-[10px] font-medium text-muted-foreground">Disnakertrans Provinsi Jawa Timur</p>
              </div>
            </div>

            <p class="text-xs italic leading-relaxed text-muted-foreground">
              &ldquo;Kami tidak hanya mengajarkan cara mengoperasikan mesin atau menulis kode, tetapi menempa sikap integritas dan ketangguhan
              mental agar para alumni kami disambut dengan penuh kepercayaan oleh industri nasional.&rdquo;
            </p>
          </div>

          <div class="border-t border-border pt-4 text-[10px] font-medium text-muted-foreground">
            Pelayanan Vokasi Berbasis Good Governance
          </div>
        </x-ui.card>
      </div>
    </div>
  </section>

  {{-- PROGRAM MTU --}}
  <section class="site-container py-12">
    <x-ui.card class="grid items-center gap-8 border-primary bg-gradient-to-br from-primary to-[#0a3b2e] p-6 text-primary-foreground md:grid-cols-12 md:p-8">
      <div class="space-y-4 md:col-span-7">
        <x-ui.badge class="border-primary-foreground/25 bg-primary-foreground/10 uppercase tracking-wide text-sikarir-lime">
          <x-lucide-truck class="size-3.5" />
          Jemput Bola Vokasi Desa
        </x-ui.badge>

        <h2 class="text-2xl font-black leading-tight text-white">
          Program Mobile Training Unit (MTU) Menjangkau 31 Kecamatan
        </h2>

        <p class="text-xs leading-relaxed text-primary-foreground/75">
          Bagi masyarakat di pelosok pedesaan yang terkendala jarak menuju kampus induk di Sumbersari, UPT BLK Jember menghadirkan armada
          Mobile Training Unit (MTU). Truk workshop khusus membawa peralatan praktik lengkap ke balai desa, pondok pesantren, dan komunitas
          warga.
        </p>

        <div class="space-y-1 rounded-xl border border-primary-foreground/15 bg-primary-foreground/10 p-3 text-xs font-medium text-primary-foreground/80 backdrop-blur-md">
          <p class="flex items-center gap-1.5 font-bold text-white">
            <x-lucide-map-pin class="size-4 text-sikarir-lime" />
            Cakupan Wilayah Kabupaten Jember: 31 dari 31 Kecamatan (100%)
          </p>
          <p class="text-[11px] text-primary-foreground/60">
            Jember Selatan (Wuluhan, Puger, Ambulu) • Jember Timur &amp; Utara (Silo, Sukowono, Jelbuk)
          </p>
        </div>

        <div class="flex flex-wrap gap-2 pt-1">
          @foreach (['Servis Sepeda Motor Injeksi', 'Pengolahan Hasil Pertanian / Barista', 'Tata Rias Pengantin & Rambut', 'Instalasi Listrik Penerangan Rumah'] as $chip)
            <x-ui.badge class="border-primary-foreground/25 bg-primary-foreground/10 text-primary-foreground/85">
              {{ $chip }}
            </x-ui.badge>
          @endforeach
        </div>
      </div>

      <div class="relative md:col-span-5">
        <div class="relative min-h-[19rem] overflow-hidden rounded-2xl border border-primary-foreground/20 bg-[#0a2b23] shadow-xl">
          <img src="{{ asset('images/MTU.jpg') }}" class="size-full object-cover" alt="Mobile Training Unit BLK Jember" loading="lazy">

          <div class="absolute inset-x-3 bottom-3 flex flex-col gap-2 rounded-xl bg-card p-3 text-card-foreground shadow-lg sm:flex-row sm:items-center sm:justify-between">
            <div>
              <h4 class="text-xs font-bold text-foreground">Pengajuan Pelatihan MTU Desa</h4>
              <p class="text-[10px] text-muted-foreground">Kepala Desa &amp; Kelompok Pemuda dapat mengajukan permohonan.</p>
            </div>

            <x-ui.button
              href="https://wa.me/#"
              target="_blank"
              rel="noopener"
              size="xs"
              class="shrink-0 bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]"
            >
              Konsultasi MTU
            </x-ui.button>
          </div>
        </div>
      </div>
    </x-ui.card>
  </section>

  {{-- PTSP & LOKASI --}}
  <section class="border-t border-border bg-muted/40 py-12">
    <div class="site-container space-y-8">
      <div>
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Layanan Publik &amp; Aksesibilitas</x-ui.badge>

        <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground">
          Pusat Pelayanan Terpadu Satu Pintu (PTSP) &amp; lokasi
        </h2>
        <p class="mt-1.5 max-w-2xl text-sm text-muted-foreground">
          Kunjungi kampus UPT BLK Jember untuk pendaftaran mandiri, konsultasi sertifikasi BNSP, magang industri, atau informasi program
          pelatihan kejuruan terbaru.
        </p>
      </div>

      <div class="grid items-stretch gap-8 md:grid-cols-2">
        {{-- Info PTSP --}}
        <x-ui.card class="flex flex-col justify-between gap-5">
          <div class="space-y-4">
            <div class="space-y-2">
              <h3 class="flex items-center gap-2 text-sm font-bold text-foreground">
                <x-lucide-clock class="size-4 text-primary" />
                Jam Operasional Pelayanan PTSP
              </h3>

              <div class="space-y-1.5 rounded-xl border border-border bg-muted/40 p-3 text-xs font-medium text-muted-foreground">
                <div class="flex flex-wrap justify-between gap-2">
                  <span>Senin - Kamis</span>
                  <span class="font-bold text-foreground">07.30 - 15.30 WIB (Istirahat 12.00 - 13.00)</span>
                </div>
                <div class="flex flex-wrap justify-between gap-2">
                  <span>Jumat</span>
                  <span class="font-bold text-foreground">07.00 - 14.30 WIB (Istirahat 11.30 - 13.00)</span>
                </div>
                <div class="flex flex-wrap items-center justify-between gap-2 border-t border-border pt-1.5">
                  <span>Sabtu, Minggu &amp; Libur Nasional</span>
                  <x-ui.badge tone="danger">TUTUP FISIK</x-ui.badge>
                </div>
              </div>
            </div>

            <div class="space-y-2">
              <h3 class="flex items-center gap-2 text-sm font-bold text-foreground">
                <x-lucide-phone-call class="size-4 text-primary" />
                Narahubung &amp; Lokasi Resmi
              </h3>

              <div class="space-y-2 text-xs text-muted-foreground">
                <p class="flex items-start gap-2">
                  <x-lucide-map-pin class="mt-0.5 size-4 shrink-0" />
                  <span>Jl. Letjen S. Parman / Jl. Basuki Rahmat No. 58, Krajan Barat, Kec. Sumbersari, Kab. Jember, Jawa Timur 68121</span>
                </p>
                <p class="flex items-center gap-2">
                  <x-lucide-phone class="size-4 shrink-0" />
                  <span>(0331) 487771</span>
                </p>
                <p class="flex items-center gap-2">
                  <x-lucide-message-square class="size-4 shrink-0" />
                  <span>Hotline WA: 0811-3221-505 (Jam Kerja)</span>
                </p>
                <p class="flex items-center gap-2">
                  <x-lucide-mail class="size-4 shrink-0" />
                  <span>blkjember.disnakertrans@jatimprov.go.id</span>
                </p>
              </div>
            </div>
          </div>

          <div class="flex gap-2 pt-2">
            <x-ui.button
              href="https://wa.me/628113221505"
              target="_blank"
              rel="noopener"
              class="flex-1 bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]"
            >
              <x-lucide-message-circle />
              Chat WhatsApp PTSP
            </x-ui.button>

            <x-ui.button href="#" variant="outline" class="flex-1">
              <x-lucide-download />
              Brosur Profil
            </x-ui.button>
          </div>
        </x-ui.card>

        {{-- Peta Lokasi --}}
        <div class="relative min-h-[19rem] overflow-hidden rounded-xl border border-border bg-muted shadow-sm">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.9712984336184!2d113.69429570941301!3d-8.205640491792323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd696eb9d058681%3A0x84fe5d132cd1947!2sUPT%20Balai%20Latihan%20Kerja%20Jember!5e0!3m2!1sid!2sid!4v1790125884843!5m2!1sid!2sid"
            class="h-full min-h-[19rem] w-full border-0"
            allowfullscreen
            loading="lazy"
            referrerpolicy="strict-origin-when-cross-origin"
            title="Peta lokasi UPT BLK Jember"
          ></iframe>

          <div class="absolute bottom-3 left-3 flex items-center gap-2.5 rounded-xl border border-border bg-card/95 p-3 text-xs shadow-md backdrop-blur-md">
            <span class="grid size-9 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-map-pin class="size-5" />
            </span>

            <div>
              <h4 class="font-bold text-foreground">Kampus UPT BLK Jember</h4>
              <p class="text-[10px] font-medium text-muted-foreground">Dekat Bundaran Bangsal &amp; Univ. Jember</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
