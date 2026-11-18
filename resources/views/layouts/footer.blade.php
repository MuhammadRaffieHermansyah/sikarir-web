{{-- resources/views/layouts/footer.blade.php --}}
<footer class="relative overflow-hidden border-t border-primary/40 bg-primary text-primary-foreground">
    <div class="pointer-events-none absolute -right-20 -top-20 size-72 rounded-full border border-sikarir-lime/20"></div>
    <div class="pointer-events-none absolute bottom-0 left-[18%] size-36 rounded-full bg-sikarir-lime/5 blur-3xl"></div>

    <div class="site-container relative grid gap-10 py-16 text-sm md:grid-cols-4">
        <div>
            <div class="mb-3 flex items-center gap-2">
                <div class="grid size-10 place-items-center rounded-xl bg-sikarir-lime text-sikarir-ink shadow-lg">
                    <i data-lucide="sparkles" class="size-5"></i>
                </div>
                <div class="leading-tight">
                    <p class="text-sm font-black tracking-[-.04em] text-white">siKarir</p>
                    <p class="text-[9px] font-bold uppercase tracking-[.14em] text-white/60">UPT BLK JEMBER</p>
                </div>
            </div>
            <p class="mb-3 text-xs leading-relaxed text-white/70">Unit Pelaksana Teknis Balai Latihan Kerja Jember di bawah naungan Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur.</p>
        </div>

        <div>
            <p class="mb-3 text-[10px] font-black uppercase tracking-[.14em] text-sikarir-lime">Kantor & Workshop</p>
            <div class="space-y-2 text-xs text-white/70">
                <p class="flex items-start gap-2"><i data-lucide="map-pin" class="mt-0.5 size-3.5 shrink-0 text-sikarir-lime"></i> Jl. Basuki Rahmat / Jl. Letjen S. Parman No. 58, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121</p>
                <p class="flex items-center gap-2"><i data-lucide="phone" class="size-3.5 shrink-0 text-sikarir-lime"></i> (0331) 487771</p>
                <p class="flex items-center gap-2"><i data-lucide="message-circle" class="size-3.5 shrink-0 text-sikarir-lime"></i> WhatsApp: 0811-3221-505</p>
                <p class="flex items-center gap-2"><i data-lucide="mail" class="size-3.5 shrink-0 text-sikarir-lime"></i> blkjember.disnakertrans@jatimprov.go.id</p>
            </div>
        </div>

        <div>
            <p class="mb-3 text-[10px] font-black uppercase tracking-[.14em] text-sikarir-lime">Portal Terkait</p>
            <div class="space-y-2 text-xs text-white/70">
                <p class="flex items-center gap-2"><i data-lucide="arrow-up-right" class="size-3.5 shrink-0 text-sikarir-lime"></i> Kementerian Ketenagakerjaan RI</p>
                <p class="flex items-center gap-2"><i data-lucide="arrow-up-right" class="size-3.5 shrink-0 text-sikarir-lime"></i> SIAPkerja Kemnaker RI</p>
                <p class="flex items-center gap-2"><i data-lucide="arrow-up-right" class="size-3.5 shrink-0 text-sikarir-lime"></i> Disnakertrans Provinsi Jawa Timur</p>
                <p class="flex items-center gap-2"><i data-lucide="arrow-up-right" class="size-3.5 shrink-0 text-sikarir-lime"></i> Badan Nasional Sertifikasi Profesi (BNSP)</p>
                <p class="flex items-center gap-2"><i data-lucide="arrow-up-right" class="size-3.5 shrink-0 text-sikarir-lime"></i> Sinaker Jawa Timur</p>
            </div>
        </div>

        <div>
            <p class="mb-3 text-[10px] font-black uppercase tracking-[.14em] text-sikarir-lime">Layanan Publik BLK</p>
            <div class="space-y-2 text-xs text-white/70">
                <p>Pelatihan Berbasis Kompetensi (PBK)</p>
                <p>Uji Kompetensi & Sertifikasi BNSP</p>
                <p>Bursa Kerja Khusus & Magang Industri</p>
            </div>
        </div>
    </div>

    <div class="site-container relative flex flex-col justify-between gap-2 border-t border-white/10 py-5 text-xs text-white/60 md:flex-row">
        <p>&copy; {{ date('Y') }} UPT BLK Jember - Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur. Hak Cipta Dilindungi Undang-Undang.</p>
        <div class="flex gap-4">
            <a href="#" class="transition hover:text-sikarir-lime">Kebijakan Privasi</a>
            <a href="#" class="transition hover:text-sikarir-lime">Syarat & Ketentuan</a>
            <a href="#" class="transition hover:text-sikarir-lime">Peta Situs</a>
        </div>
    </div>
</footer>
