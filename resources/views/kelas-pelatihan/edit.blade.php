<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Edit Kelas Pelatihan</h2></x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6">
                <form method="POST" action="{{ route('kelas-pelatihan.update', $kelas->id) }}" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peserta</label>
                        <select name="id_peserta" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            @foreach($pesertas as $p)
                            <option value="{{ $p->id }}" {{ $kelas->id_peserta == $p->id ? 'selected' : '' }}>{{ $p->user->name ?? 'User #'.$p->user_id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Pelatihan</label>
                        <select name="id_jadwal" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            @foreach($jadwals as $j)
                            <option value="{{ $j->id }}" {{ $kelas->id_jadwal == $j->id ? 'selected' : '' }}>
                                {{ $j->pelatihan->nama_pelatihan ?? '-' }} — {{ $j->tanggal_mulai ? \Carbon\Carbon::parse($j->tanggal_mulai)->format('d M Y') : '-' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Perbarui</button>
                        <a href="{{ route('kelas-pelatihan.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
