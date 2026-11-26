@forelse ($pelatihan as $item)
  @php $jadwal = $item->jadwal_terdekat; @endphp

  <x-ui.card class="flex flex-col justify-between overflow-hidden p-0 transition hover:border-primary/40 hover:shadow-md">
    <div>
      <div class="relative aspect-[16/10] overflow-hidden bg-muted">
        <img
          src="{{ $item->gambar_thumb_url ?? asset('images/hero-image.webp') }}"
          alt="{{ $item->nama_pelatihan }}"
          class="size-full object-cover"
          loading="lazy"
        >

        @if ($jadwal)
          <x-ui.badge variant="solid" tone="success" class="absolute left-3 top-3 backdrop-blur-sm">Pendaftaran Buka</x-ui.badge>
        @else
          <x-ui.badge variant="solid" tone="neutral" class="absolute left-3 top-3 backdrop-blur-sm">Belum Ada Jadwal</x-ui.badge>
        @endif
      </div>

      <div class="space-y-3 p-5">
        <div class="flex items-center justify-between gap-2 text-[10px] font-bold uppercase tracking-wide text-muted-foreground">
          <span class="flex items-center gap-1 text-primary"><x-lucide-users class="size-3.5" />Kuota {{ $item->kuota }} siswa</span>
          <span class="flex items-center gap-1"><x-lucide-calendar class="size-3.5" />{{ $jadwal ? 'Mulai '.$jadwal->tanggal_mulai->translatedFormat('d M Y') : 'Jadwal menyusul' }}</span>
        </div>

        <div class="flex items-start justify-between gap-2">
          <h3 class="line-clamp-1 text-base font-bold leading-snug text-foreground">{{ $item->nama_pelatihan }}</h3>
          @if ($item->durasi)<x-ui.badge variant="secondary" class="shrink-0">{{ $item->durasi->jam }} Jam</x-ui.badge>@endif
        </div>

        <p class="line-clamp-2 text-xs leading-relaxed text-muted-foreground">{{ $item->deskripsi_pelatihan ?: 'Deskripsi program belum ditambahkan.' }}</p>

        @if ($item->durasi)
          <p class="flex items-center gap-1 text-[11px] font-semibold text-muted-foreground"><x-lucide-timer class="size-3.5 text-primary" />Durasi {{ $item->durasi->durasi_label }}</p>
        @endif
      </div>
    </div>

    <div class="flex gap-2 px-5 pb-5">
      <x-ui.button href="{{ route('register') }}" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-smartphone /> Daftar lewat aplikasi
      </x-ui.button>
    </div>
  </x-ui.card>
@empty
  <x-ui.empty class="col-span-full bg-card">
    <x-ui.empty-header>
      <x-ui.empty-media variant="icon"><x-lucide-book-open /></x-ui.empty-media>
      <x-ui.empty-title>Belum ada data pelatihan</x-ui.empty-title>
      <x-ui.empty-description>Belum ada program yang cocok. Coba ubah kata kunci atau status pendaftaran.</x-ui.empty-description>
    </x-ui.empty-header>
  </x-ui.empty>
@endforelse
