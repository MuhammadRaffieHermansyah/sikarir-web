{{-- resources/views/layouts/footer.blade.php --}}
<footer class="relative overflow-hidden border-t border-[#0d3529] bg-[#103e32] text-[#c9dbc9]">
    <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full border border-[#d8f36a]/20"></div>
    <div class="pointer-events-none absolute bottom-0 left-[18%] h-36 w-36 rounded-full bg-[#d8f36a]/5 blur-3xl"></div>
    <div class="site-container relative grid gap-10 py-16 text-sm md:grid-cols-4">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="grid h-10 w-10 place-items-center rounded-xl bg-[#d8f36a] text-[#133d30] shadow-lg"><i data-lucide="sparkles" class="h-5 w-5"></i></div>
                <div class="leading-tight">
                    <p class="text-sm font-black tracking-[-.04em] text-white">siKarir</p>
                    <p class="text-[9px] font-bold uppercase tracking-[.14em] text-[#aac3ae]">UPT BLK JEMBER</p>
                </div>
            </div>
            <p class="mb-3 text-xs leading-relaxed text-[#b5cab8]">Unit Pelaksana Teknis Balai Latihan Kerja Jember di bawah naungan Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur.</p>
        </div>

        <div>
            <p class="mb-3 text-[10px] font-black uppercase tracking-[.14em] text-[#d8f36a]">Kantor & Workshop</p>
            <div class="space-y-2 text-xs text-[#b5cab8]">
                <p class="flex items-start gap-2"><i data-lucide="map-pin" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#d8f36a]"></i> Jl. Basuki Rahmat / Jl. Letjen S. Parman No. 58, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121</p>
                <p class="flex items-center gap-2"><i data-lucide="phone" class="h-3.5 w-3.5 shrink-0 text-[#d8f36a]"></i> (0331) 487771</p>
                <p class="flex items-center gap-2"><i data-lucide="message-circle" class="h-3.5 w-3.5 shrink-0 text-[#d8f36a]"></i> WhatsApp: 0811-3221-505</p>
                <p class="flex items-center gap-2"><i data-lucide="mail" class="h-3.5 w-3.5 shrink-0 text-[#d8f36a]"></i> blkjember.disnakertrans@jatimprov.go.id</p>
            </div>
        </div>

        <div>
            <p class="mb-3 text-[10px] font-black uppercase tracking-[.14em] text-[#d8f36a]">Portal Terkait</p>
            <div class="space-y-2 text-xs text-[#b5cab8]">
                <p class="flex items-center gap-2"><i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0 text-[#d8f36a]"></i> Kementerian Ketenagakerjaan RI</p>
                <p class="flex items-center gap-2"><i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0 text-[#d8f36a]"></i> SIAPkerja Kemnaker RI</p>
                <p class="flex items-center gap-2"><i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0 text-[#d8f36a]"></i> Disnakertrans Provinsi Jawa Timur</p>
                <p class="flex items-center gap-2"><i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0 text-[#d8f36a]"></i> Badan Nasional Sertifikasi Profesi (BNSP)</p>
                <p class="flex items-center gap-2"><i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0 text-[#d8f36a]"></i> Sinaker Jawa Timur</p>
            </div>
        </div>

        <div>
            <p class="mb-3 text-[10px] font-black uppercase tracking-[.14em] text-[#d8f36a]">Layanan Publik BLK</p>
            <div class="space-y-2 text-xs text-[#b5cab8]">
                <p>Pelatihan Berbasis Kompetensi (PBK)</p>
                <p>Uji Kompetensi & Sertifikasi BNSP</p>
                <p>Bursa Kerja Khusus & Magang Industri</p>
            </div>
        </div>
    </div>

    <div class="site-container relative flex flex-col justify-between gap-2 border-t border-white/10 py-5 text-xs text-[#93ad98] md:flex-row">
        <p>&copy; {{ date('Y') }} UPT BLK Jember - Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur. Hak Cipta Dilindungi Undang-Undang.</p>
        <div class="flex gap-4">
            <a href="#" class="transition hover:text-[#d8f36a]">Kebijakan Privasi</a>
            <a href="#" class="transition hover:text-[#d8f36a]">Syarat & Ketentuan</a>
            <a href="#" class="transition hover:text-[#d8f36a]">Peta Situs</a>
        </div>
    </div>
</footer>
