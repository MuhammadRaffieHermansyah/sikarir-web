{{-- resources/views/layouts/footer.blade.php --}}
<footer class="relative isolate overflow-hidden border-t border-sikarir-lime/20 bg-gradient-to-br from-primary via-[#0c3f31] to-[#0a2b23] text-primary-foreground">
    <div class="pointer-events-none absolute -right-20 -top-20 size-72 rounded-full border border-sikarir-lime/20"></div>
    <div class="pointer-events-none absolute -bottom-24 right-[6%] size-32 rounded-full border border-sikarir-lime/30"></div>
    <div class="pointer-events-none absolute bottom-0 left-[18%] size-36 rounded-full bg-sikarir-lime/5 blur-3xl"></div>

    <div class="site-container relative grid gap-10 py-16 text-sm md:grid-cols-4">
    <div>
        <a href="{{ url('/') }}" class="mb-3 flex items-center gap-2">
            <div class="grid size-10 place-items-center rounded-xl bg-sikarir-lime text-sikarir-ink shadow-lg">
                <i data-lucide="sparkles" class="size-5"></i>
            </div>
            <div class="leading-tight">
                <p class="text-sm font-black tracking-[-.04em] text-white">siKarir</p>
                <p class="text-[9px] font-bold uppercase tracking-[.14em] text-white/60">UPT BLK JEMBER</p>
            </div>
        </a>
        <p class="mb-3 text-xs leading-relaxed text-white/70">Unit Pelaksana Teknis Balai Latihan Kerja Jember di bawah naungan Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur.</p>
    </div>

        <div>
            <p class="mb-3 text-[10px] font-black uppercase tracking-[.14em] text-sikarir-lime">Kantor &amp; Workshop</p>
            <div class="space-y-2 text-xs text-white/70">
                <p class="flex items-start gap-2"><i data-lucide="map-pin" class="mt-0.5 size-3.5 shrink-0 text-sikarir-lime"></i> {{ config('blk.address') }}</p>
                <p class="flex items-center gap-2"><i data-lucide="phone" class="size-3.5 shrink-0 text-sikarir-lime"></i> {{ config('blk.phone') }}</p>
                <a href="https://wa.me/{{ config('blk.wa') }}" target="_blank" rel="noopener" class="flex items-center gap-2 transition hover:text-sikarir-lime"><i data-lucide="message-circle" class="size-3.5 shrink-0 text-sikarir-lime"></i> WhatsApp: {{ config('blk.wa_label') }}</a>
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ config('blk.email') }}"
                    target="_blank" rel="noopener"
                    class="flex items-center gap-2 transition hover:text-sikarir-lime">
                        <i data-lucide="mail" class="size-3.5 shrink-0 text-sikarir-lime"></i> {{ config('blk.email') }}
                </a>
            </div>
        </div>

        <div>
            <p class="mb-3 text-[10px] font-black uppercase tracking-[.14em] text-sikarir-lime">Portal Terkait</p>
            <div class="space-y-2 text-xs text-white/70">
                @foreach ([
                    ['label' => 'Kementerian Ketenagakerjaan RI', 'url' => 'https://kemnaker.go.id'],
                    ['label' => 'SIAPkerja Kemnaker RI', 'url' => 'https://siapkerja.kemnaker.go.id'],
                    ['label' => 'Disnakertrans Provinsi Jawa Timur', 'url' => 'https://disnakertrans.jatimprov.go.id'],
                    ['label' => 'Badan Nasional Sertifikasi Profesi (BNSP)', 'url' => 'https://bnsp.go.id'],
                    ['label' => 'Sinaker Jawa Timur', 'url' => 'https://sinaker.disnakertrans.jatimprov.go.id/'],
                ] as $p)
                    @if ($p['url'])
                        <a href="{{ $p['url'] }}" target="_blank" rel="noopener" class="flex items-center gap-2 transition hover:text-sikarir-lime">
                            <i data-lucide="arrow-up-right" class="size-3.5 shrink-0 text-sikarir-lime"></i> {{ $p['label'] }}
                        </a>
                    @else
                        <p class="flex items-center gap-2">
                            <i data-lucide="arrow-up-right" class="size-3.5 shrink-0 text-sikarir-lime"></i> {{ $p['label'] }}
                        </p>
                    @endif
                @endforeach
            </div>
        </div>

        <div>
            <p class="mb-3 text-[10px] font-black uppercase tracking-[.14em] text-sikarir-lime">Layanan Publik BLK</p>
            <div class="space-y-2 text-xs text-white/70">
                <p>Pelatihan Berbasis Kompetensi (PBK)</p>
                <p>Uji Kompetensi &amp; Sertifikasi BNSP</p>
                <p>Konsultasi Pelatihan</p>
                <p>Mobile Training Unit (MTU)</p>
            </div>
        </div>
    </div>

    <div class="site-container relative border-t border-white/10 py-5 text-xs text-white/60">
        <p>&copy; {{ date('Y') }} siKarir &ndash; Platform informasi pelatihan UPT BLK Jember, Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur.</p>
    </div>
</footer>
