<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Detail Admin BLK</h2>
            <div class="space-x-2">
                <a href="{{ route('admin-blk.edit', $admin->id) }}" class="px-4 py-2 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600 transition">Edit</a>
                <a href="{{ route('admin-blk.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Kembali</a>
            </div>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6 grid grid-cols-2 gap-4">
                <div><p class="text-xs text-gray-500 uppercase">Nama</p><p class="mt-1 text-sm font-semibold">{{ $admin->user->name ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Email</p><p class="mt-1 text-sm">{{ $admin->user->email ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">NIP</p><p class="mt-1 text-sm">{{ $admin->nip ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 uppercase">Jabatan</p><p class="mt-1 text-sm">{{ $admin->jabatan ?? '-' }}</p></div>
            </div>
        </div>
    </div>
</x-app-layout>
