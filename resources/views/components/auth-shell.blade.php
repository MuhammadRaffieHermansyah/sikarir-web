@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'heroTitle' => 'Sistem Informasi Karir & Vokasi',
    'heroDescription' => 'Portal terpadu pengelolaan pelatihan kerja, presensi peserta, dan penerbitan sertifikat digital.',
    'icon' => 'graduation-cap',
])

<div class="grid grid-cols-1 overflow-hidden rounded-2xl border border-border bg-card shadow-xl shadow-primary/5 lg:grid-cols-12">
    {{-- Branding panel --}}
    <div class="relative flex flex-col justify-between overflow-hidden bg-gradient-to-br from-primary via-[#0d4335] to-[#0a2f26] p-8 text-primary-foreground md:p-10 lg:col-span-5">
        <div class="pointer-events-none absolute -left-24 -top-24 size-64 rounded-full bg-sikarir-lime/15 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-20 size-64 rounded-full bg-emerald-400/10 blur-3xl"></div>

        <a href="{{ url('/') }}" class="relative z-10 flex w-fit items-center gap-3">
            <img src="{{ asset('images/sikarir-logo.png') }}" alt="Logo siKarir BLK Jember" class="size-11 rounded-xl object-contain shadow-lg">
            <span>
                <span class="block text-lg font-black leading-none tracking-wider">SIKARIR</span>
                <span class="mt-1 block text-[10px] font-semibold tracking-[0.18em] text-sikarir-lime">BLK PUSAT VOKASI</span>
            </span>
        </a>

        <div class="relative z-10 my-10 space-y-6">
            <div class="mx-auto grid size-24 place-items-center rounded-3xl border border-white/10 bg-white/5 shadow-2xl backdrop-blur">
                <span class="grid size-16 place-items-center rounded-2xl border border-sikarir-lime/25 bg-sikarir-lime/10">
                    <x-dynamic-component :component="'lucide-'.$icon" class="size-8 text-sikarir-lime" />
                </span>
            </div>

            <div class="space-y-2 text-center">
                <h2 class="text-2xl font-black leading-snug tracking-tight text-white">{{ $heroTitle }}</h2>
                <p class="mx-auto max-w-xs text-xs leading-relaxed text-primary-foreground/70">{{ $heroDescription }}</p>
            </div>
        </div>

        <div class="relative z-10 border-t border-white/10 pt-6 text-center">
            <p class="text-[11px] font-medium text-primary-foreground/55">Balai Latihan Kerja • Kementerian Ketenagakerjaan</p>
        </div>
    </div>

    {{-- Form panel --}}
    <div class="flex flex-col justify-between bg-card p-6 md:p-10 lg:col-span-7">
        <div>
            <div class="mb-7 flex items-center justify-between gap-3">
                @if ($eyebrow)
                    <x-ui.badge variant="secondary" size="sm" class="gap-1.5 uppercase tracking-wide">
                        <span class="size-1.5 rounded-full bg-primary"></span>
                        {{ $eyebrow }}
                    </x-ui.badge>
                @endif

                <span class="text-xs font-semibold text-muted-foreground">v1.0.0</span>
            </div>

            @if ($title)
                <h2 class="text-2xl font-black tracking-tight text-foreground">{{ $title }}</h2>
            @endif

            @if ($description)
                <p class="mt-1 text-xs leading-relaxed text-muted-foreground">{{ $description }}</p>
            @endif

            <div class="mt-6">{{ $slot }}</div>

            @isset($links)
                <div class="mt-6">{{ $links }}</div>
            @endisset
        </div>

        <div class="mt-8 flex items-center gap-3 border-t border-border pt-4">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-primary/10 text-primary">
                <x-lucide-shield-check class="size-4" />
            </span>
            <div>
                <div class="text-[11px] font-bold text-foreground">Helpdesk & Dukungan Sistem</div>
                <div class="text-[10px] text-muted-foreground">Tim Operasional Sistem Informasi Vokasi BLK</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 flex flex-col items-center justify-between gap-2 px-2 text-[11px] text-muted-foreground sm:flex-row">
    <div class="flex items-center gap-1.5">
        <x-lucide-lock class="size-3 text-primary" />
        <span>Koneksi Terenkripsi SSL · SIKARIR BLK</span>
    </div>
    <div class="font-medium">&copy; {{ date('Y') }} SIKARIR Pusat Vokasi</div>
</div>
