<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Detail Absensi</h2>
            <a href="{{ route('absen.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Kembali</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6 grid grid-cols-2 gap-4">
                <div><p class="text-xs text-gray-500 uppercase">Peserta</p><p class="mt-1 text-sm font-semibold">{{ $absen->peserta->user->name ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Jadwal</p><p class="mt-1 text-sm">{{ $absen->jadwal->pelatihan->nama_pelatihan ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Tanggal</p><p class="mt-1 text-sm">{{ $absen->tanggal ? \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') : '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Status</p>
                    <p class="mt-1"><span class="px-2 py-1 rounded-full text-xs font-medium {{ $absen->status === 'hadir' ? 'bg-green-100 text-green-800' : ($absen->status === 'izin' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($absen->status ?? '-') }}</span></p>
                </div>
                <div class="col-span-2"><p class="text-xs text-gray-500 uppercase">Keterangan</p><p class="mt-1 text-sm">{{ $absen->keterangan ?? '-' }}</p></div>
            </div>
        </div>
    </div>
</x-app-layout>
