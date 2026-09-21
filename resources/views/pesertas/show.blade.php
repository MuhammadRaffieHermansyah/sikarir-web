<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Detail Peserta</h2>
            <div class="space-x-2">
                <a href="{{ route('pesertas.edit', $peserta->id) }}" class="px-4 py-2 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600 transition">Edit</a>
                <a href="{{ route('pesertas.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Kembali</a>
            </div>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><p class="text-xs text-gray-500 uppercase">Nama</p><p class="mt-1 text-sm font-semibold">{{ $peserta->user->name ?? '-' }}</p></div>
                    <div><p class="text-xs text-gray-500 uppercase">Email</p><p class="mt-1 text-sm">{{ $peserta->user->email ?? '-' }}</p></div>
                    <div><p class="text-xs text-gray-500 uppercase">NIK</p><p class="mt-1 text-sm">{{ $peserta->nik ?? '-' }}</p></div>
                    <div><p class="text-xs text-gray-500 uppercase">Pendidikan Terakhir</p><p class="mt-1 text-sm">{{ $peserta->pendidikan_terakhir ?? '-' }}</p></div>
                    <div class="col-span-2"><p class="text-xs text-gray-500 uppercase">Alamat</p><p class="mt-1 text-sm">{{ $peserta->alamat ?? '-' }}</p></div>
                    <div class="col-span-2"><p class="text-xs text-gray-500 uppercase">Keahlian</p><p class="mt-1 text-sm">{{ $peserta->keahlian ?? '-' }}</p></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
