<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Kelas Pelatihan</h2>
            <a href="{{ route('kelas-pelatihan.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">+ Daftarkan Peserta</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg">{{ $errors->first() }}</div>@endif
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Peserta</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pelatihan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jadwal</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($kelas as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->peserta->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->jadwal->pelatihan->nama_pelatihan ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->jadwal && $item->jadwal->tanggal_mulai ? \Carbon\Carbon::parse($item->jadwal->tanggal_mulai)->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('kelas-pelatihan.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Detail</a>
                                <form method="POST" action="{{ route('kelas-pelatihan.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada pendaftaran kelas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t">{{ $kelas->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
