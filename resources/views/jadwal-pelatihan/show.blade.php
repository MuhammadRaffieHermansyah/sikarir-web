<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Detail Jadwal Pelatihan</h2>
            <div class="space-x-2">
                <a href="{{ route('jadwal-pelatihan.edit', $jadwal->id) }}" class="px-4 py-2 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600 transition">Edit</a>
                <a href="{{ route('jadwal-pelatihan.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Kembali</a>
            </div>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6 grid grid-cols-2 gap-4">
                <div class="col-span-2"><p class="text-xs text-gray-500 uppercase">Pelatihan</p><p class="mt-1 text-sm font-semibold">{{ $jadwal->pelatihan->nama_pelatihan ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Tanggal Mulai</p><p class="mt-1 text-sm">{{ $jadwal->tanggal_mulai ? \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') : '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Tanggal Selesai</p><p class="mt-1 text-sm">{{ $jadwal->tanggal_selesai ? \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') : '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Lokasi</p><p class="mt-1 text-sm">{{ $jadwal->lokasi ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Status</p><p class="mt-1"><span class="px-2 py-1 rounded-full text-xs font-medium {{ $jadwal->status === 'tersedia' ? 'bg-green-100 text-green-800' : ($jadwal->status === 'penuh' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">{{ ucfirst($jadwal->status ?? '-') }}</span></p></div>
            </div>
        </div>
    </div>
</x-app-layout>
