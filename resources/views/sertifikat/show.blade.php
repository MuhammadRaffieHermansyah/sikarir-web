<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Detail Sertifikat</h2>
            <div class="space-x-2">
                <a href="{{ route('sertifikat.edit', $sertifikat->id) }}" class="px-4 py-2 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600 transition">Edit</a>
                <a href="{{ route('sertifikat.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Kembali</a>
            </div>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6 grid grid-cols-2 gap-4">
                <div><p class="text-xs text-gray-500 uppercase">Peserta</p><p class="mt-1 text-sm font-semibold">{{ $sertifikat->peserta->user->name ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Pelatihan</p><p class="mt-1 text-sm">{{ $sertifikat->jadwal->pelatihan->nama_pelatihan ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Admin</p><p class="mt-1 text-sm">{{ $sertifikat->admin->user->name ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Nomor Sertifikat</p><p class="mt-1 text-sm">{{ $sertifikat->nomor_sertifikat ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Tanggal Terbit</p><p class="mt-1 text-sm">{{ $sertifikat->tanggal_terbit ? \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->format('d M Y') : '-' }}</p></div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">File Sertifikat</p>
                    @if($sertifikat->file_sertifikat)
                        <a href="{{ Storage::url($sertifikat->file_sertifikat) }}" target="_blank" class="mt-1 inline-block text-indigo-600 hover:text-indigo-800 text-sm font-medium">📄 Unduh / Lihat</a>
                    @else
                        <p class="mt-1 text-sm text-gray-400">Belum ada file.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
