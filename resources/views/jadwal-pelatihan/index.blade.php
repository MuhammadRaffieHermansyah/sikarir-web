<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Jadwal Pelatihan</h2>
            <a href="{{ route('jadwal-pelatihan.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">+ Tambah Jadwal</a>
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
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pelatihan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mulai</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Selesai</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($jadwals as $jadwal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $jadwal->pelatihan->nama_pelatihan ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $jadwal->tanggal_mulai ? \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $jadwal->tanggal_selesai ? \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $jadwal->status === 'tersedia' ? 'bg-green-100 text-green-800' : ($jadwal->status === 'penuh' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($jadwal->status ?? '-') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('jadwal-pelatihan.show', $jadwal->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Detail</a>
                                <a href="{{ route('jadwal-pelatihan.edit', $jadwal->id) }}" class="text-yellow-600 hover:text-yellow-800 text-sm">Edit</a>
                                <form method="POST" action="{{ route('jadwal-pelatihan.destroy', $jadwal->id) }}" class="inline" onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada jadwal.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t">{{ $jadwals->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
