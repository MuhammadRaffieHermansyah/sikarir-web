{{-- resources/views/layouts/footer.blade.php --}}
<footer class="bg-slate-900 text-slate-300 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-6 py-14 grid md:grid-cols-4 gap-8 text-sm">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-800 text-white flex items-center justify-center font-black text-sm">S</div>
                <div class="leading-tight">
                    <p class="font-black text-white text-sm">siKarir</p>
                    <p class="text-[10px] text-slate-400">UPT BLK JEMBER</p>
                </div>
            </div>
            <p class="text-xs text-slate-400 leading-relaxed mb-3">Unit Pelaksana Teknis Balai Latihan Kerja Jember di bawah naungan Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur.</p>
            <p class="text-xs font-bold text-emerald-400 flex items-center gap-1.5">
                <i data-lucide="badge-check" class="w-3.5 h-3.5"></i> LSP P1 BLK Jember Terlisensi BNSP
            </p>
        </div>

        <div>
            <p class="text-white font-bold text-xs uppercase tracking-wider mb-3">Kantor & Workshop</p>
            <div class="space-y-2 text-xs text-slate-400">
                <p class="flex items-start gap-2"><i data-lucide="map-pin" class="w-3.5 h-3.5 mt-0.5 shrink-0 text-emerald-500"></i> Jl. Basuki Rahmat / Jl. Letjen S. Parman No. 58, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121</p>
                <p class="flex items-center gap-2"><i data-lucide="phone" class="w-3.5 h-3.5 shrink-0 text-emerald-500"></i> (0331) 487771</p>
                <p class="flex items-center gap-2"><i data-lucide="message-circle" class="w-3.5 h-3.5 shrink-0 text-emerald-500"></i> WhatsApp: 0811-3221-505</p>
                <p class="flex items-center gap-2"><i data-lucide="mail" class="w-3.5 h-3.5 shrink-0 text-emerald-500"></i> blkjember.disnakertrans@jatimprov.go.id</p>
            </div>
        </div>

        <div>
            <p class="text-white font-bold text-xs uppercase tracking-wider mb-3">Portal Terkait</p>
            <div class="space-y-2 text-xs text-slate-400">
                <p class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 shrink-0 text-emerald-500"></i> Kementerian Ketenagakerjaan RI</p>
                <p class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 shrink-0 text-emerald-500"></i> SIAPkerja Kemnaker RI</p>
                <p class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 shrink-0 text-emerald-500"></i> Disnakertrans Provinsi Jawa Timur</p>
                <p class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 shrink-0 text-emerald-500"></i> Badan Nasional Sertifikasi Profesi (BNSP)</p>
                <p class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 shrink-0 text-emerald-500"></i> Sinaker Jawa Timur</p>
            </div>
        </div>

        <div>
            <p class="text-white font-bold text-xs uppercase tracking-wider mb-3">Layanan Publik BLK</p>
            <div class="space-y-2 text-xs text-slate-400">
                <p>Pelatihan Berbasis Kompetensi (PBK)</p>
                <p>Uji Kompetensi & Sertifikasi BNSP</p>
                <p>Bursa Kerja Khusus & Magang Industri</p>
                <p>Layanan Pengaduan & Informasi SP4N LAPOR</p>
                <p>Standar Pelayanan & Maklumat BLK</p>
            </div>
        </div>
    </div>

    <div class="border-t border-slate-800 text-xs py-5 max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between text-slate-500 gap-2">
        <p>&copy; {{ date('Y') }} UPT BLK Jember - Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur. Hak Cipta Dilindungi Undang-Undang.</p>
        <div class="flex gap-4">
            <a href="#" class="hover:text-emerald-400 transition">Kebijakan Privasi</a>
            <a href="#" class="hover:text-emerald-400 transition">Syarat & Ketentuan</a>
            <a href="#" class="hover:text-emerald-400 transition">Peta Situs</a>
        </div>
    </div>
</footer>
