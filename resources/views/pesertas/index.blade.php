<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Peserta</h2>
            <a href="{{ route('pesertas.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">+ Tambah Peserta</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">{{ session('success') }}</div>@endif
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIK</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pendidikan</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($pesertas as $peserta)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $peserta->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $peserta->nik ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $peserta->pendidikan_terakhir ?? '-' }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('pesertas.show', $peserta->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Detail</a>
                                <a href="{{ route('pesertas.edit', $peserta->id) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">Edit</a>
                                <form method="POST" action="{{ route('pesertas.destroy', $peserta->id) }}" class="inline" onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada data peserta.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t">{{ $pesertas->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
