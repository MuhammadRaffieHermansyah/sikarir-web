<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Detail Lowongan</h2>
            <div class="space-x-2">
                <a href="{{ route('lowongan.edit', $lowongan->id) }}" class="px-4 py-2 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600 transition">Edit</a>
                <a href="{{ route('lowongan.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Kembali</a>
            </div>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6 grid grid-cols-2 gap-4">
                <div class="col-span-2"><p class="text-xs text-gray-500 uppercase">Judul</p><p class="mt-1 text-sm font-semibold text-gray-900">{{ $lowongan->judul }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Mitra</p><p class="mt-1 text-sm">{{ $lowongan->mitra->nama_perusahaan ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Lokasi</p><p class="mt-1 text-sm">{{ $lowongan->lokasi ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Gaji</p><p class="mt-1 text-sm">{{ $lowongan->gaji ? 'Rp ' . number_format($lowongan->gaji, 0, ',', '.') : '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Deadline</p><p class="mt-1 text-sm">{{ $lowongan->deadline ? \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') : '-' }}</p></div>
                <div class="col-span-2"><p class="text-xs text-gray-500 uppercase">Deskripsi</p><p class="mt-1 text-sm whitespace-pre-line">{{ $lowongan->deskripsi ?? '-' }}</p></div>
            </div>
        </div>
    </div>
</x-app-layout>
