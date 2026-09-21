<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Daftarkan Peserta ke Kelas</h2></x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6">
                <form method="POST" action="{{ route('kelas-pelatihan.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peserta <span class="text-red-500">*</span></label>
                        <select name="id_peserta" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">-- Pilih Peserta --</option>
                            @foreach($pesertas as $p)
                            <option value="{{ $p->id }}" {{ old('id_peserta') == $p->id ? 'selected' : '' }}>{{ $p->user->name ?? 'User #'.$p->user_id }}</option>
                            @endforeach
                        </select>
                        @error('id_peserta')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Pelatihan <span class="text-red-500">*</span></label>
                        <select name="id_jadwal" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach($jadwals as $j)
                            <option value="{{ $j->id }}" {{ old('id_jadwal') == $j->id ? 'selected' : '' }}>
                                {{ $j->pelatihan->nama_pelatihan ?? '-' }} — {{ $j->tanggal_mulai ? \Carbon\Carbon::parse($j->tanggal_mulai)->format('d M Y') : '-' }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_jadwal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Daftarkan</button>
                        <a href="{{ route('kelas-pelatihan.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
