<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Edit Sertifikat</h2></x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6">
                <form method="POST" action="{{ route('sertifikat.update', $sertifikat->id) }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Sertifikat</label>
                            <input type="text" name="nomor_sertifikat" value="{{ old('nomor_sertifikat', $sertifikat->nomor_sertifikat) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Terbit</label>
                            <input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', $sertifikat->tanggal_terbit) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">File Sertifikat Baru <span class="text-gray-400 text-xs">(Biarkan kosong jika tidak ingin mengganti)</span></label>
                        @if($sertifikat->file_sertifikat)
                            <p class="text-xs text-gray-500 mb-1">File saat ini: <a href="{{ Storage::url($sertifikat->file_sertifikat) }}" target="_blank" class="text-indigo-600">Lihat file</a></p>
                        @endif
                        <input type="file" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('file_sertifikat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Perbarui</button>
                        <a href="{{ route('sertifikat.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
