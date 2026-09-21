<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Daftar Sertifikat</h2>
            <a href="{{ route('sertifikat.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">+ Tambah Sertifikat</a>
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
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Peserta</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pelatihan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No. Sertifikat</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal Terbit</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">File</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($sertifikats as $sertifikat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $sertifikat->peserta->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $sertifikat->jadwal->pelatihan->nama_pelatihan ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $sertifikat->nomor_sertifikat ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $sertifikat->tanggal_terbit ? \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($sertifikat->file_sertifikat)
                                    <a href="{{ Storage::url($sertifikat->file_sertifikat) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm">Lihat File</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('sertifikat.show', $sertifikat->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Detail</a>
                                <a href="{{ route('sertifikat.edit', $sertifikat->id) }}" class="text-yellow-600 hover:text-yellow-800 text-sm">Edit</a>
                                <form method="POST" action="{{ route('sertifikat.destroy', $sertifikat->id) }}" class="inline" onsubmit="return confirm('Hapus sertifikat beserta file?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada sertifikat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t">{{ $sertifikats->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
