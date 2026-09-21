<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Detail Kelas Pelatihan</h2>
            <a href="{{ route('kelas-pelatihan.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Kembali</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6 grid grid-cols-2 gap-4">
                <div><p class="text-xs text-gray-500 uppercase">Peserta</p><p class="mt-1 text-sm font-semibold">{{ $kelas->peserta->user->name ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Email</p><p class="mt-1 text-sm">{{ $kelas->peserta->user->email ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Pelatihan</p><p class="mt-1 text-sm">{{ $kelas->jadwal->pelatihan->nama_pelatihan ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Jadwal Mulai</p><p class="mt-1 text-sm">{{ $kelas->jadwal && $kelas->jadwal->tanggal_mulai ? \Carbon\Carbon::parse($kelas->jadwal->tanggal_mulai)->format('d M Y') : '-' }}</p></div>
            </div>
        </div>
    </div>
</x-app-layout>
