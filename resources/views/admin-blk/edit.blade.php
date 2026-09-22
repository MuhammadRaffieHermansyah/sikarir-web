@extends('layouts.app')

@section('title', 'Edit Administrator BLK - ' . ($admin->user->name ?? 'Admin'))

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Admin BLK</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Edit Data #BLK-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Edit Data Administrator BLK</h1>
      <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi akun, penugasan balai, atau alokasi kewenangan personel pengelola.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('admin-blk.show', $admin->id_admin) }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="eye" class="w-4 h-4 text-emerald-700"></i> Lihat Profil
      </a>
      <a href="{{ route('admin-blk.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </div>
  </div>

  <!-- Profile Banner Summary -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-700 to-teal-900 text-white font-black text-lg flex items-center justify-center shadow-sm shrink-0">
          {{ strtoupper(substr($admin->user->name ?? 'A', 0, 2)) }}
        </div>
        <div>
          <div class="flex items-center gap-2 flex-wrap">
            <h2 class="text-base font-bold text-slate-900">{{ $admin->user->name ?? 'Tanpa Nama' }}</h2>
            <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
              ID Admin: #BLK-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}
            </span>
            <span class="bg-indigo-50 text-indigo-700 text-[10px] font-semibold px-2 py-0.5 rounded-full">
              Aktif Bertugas
            </span>
          </div>
          <div class="flex items-center gap-3 text-xs text-slate-500 mt-1 flex-wrap">
            <span class="flex items-center gap-1"><i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i> {{ $admin->user->email ?? '-' }}</span>
            <span class="flex items-center gap-1"><i data-lucide="building-2" class="w-3.5 h-3.5 text-slate-400"></i> BLK Pusat Vokasi</span>
          </div>
        </div>
      </div>

      <div class="text-xs text-slate-400 flex sm:flex-col items-end justify-between gap-1 border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-100">
        <div>Terdaftar: <span class="text-slate-700 font-medium">{{ $admin->created_at ? $admin->created_at->translatedFormat('d M Y') : '-' }}</span></div>
        <div>Pembaruan Terakhir: <span class="text-slate-700 font-medium">{{ $admin->updated_at ? $admin->updated_at->diffForHumans() : '-' }}</span></div>
      </div>
    </div>
  </div>

  <!-- Edit Form Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column (Form) -->
    <div class="lg:col-span-2 space-y-6">
      <form method="POST" action="{{ route('admin-blk.update', $admin->id_admin) }}" class="space-y-6">
        @csrf
        @method('PUT')

        @if($errors->any())
          <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs space-y-1 shadow-sm">
            <div class="font-bold">Mohon perbaiki kesalahan berikut:</div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-4">
              @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
          </div>
        @endif

        <!-- Card: Pilih Akun Pengguna -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
          <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="user-cog" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Pengaturan Akun Pengguna</h3>
              <p class="text-xs text-slate-500">Tentukan tautan akun pengguna untuk administrator ini.</p>
            </div>
          </div>

          <div>
            <label for="id_user" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Akun Pengguna Terkait <span class="text-rose-500">*</span>
            </label>
            <select name="id_user" id="id_user" required class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @foreach($users ?? [] as $user)
                <option value="{{ $user->id }}" {{ (old('id_user', $admin->id_user) == $user->id) ? 'selected' : '' }}>
                  {{ $user->name }} ({{ $user->email }}) - Role: {{ $user->role ?? 'User' }}
                </option>
              @endforeach
            </select>
            @error('id_user')
              <p class="text-rose-600 text-xs mt-1.5 flex items-center gap-1">
                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
              </p>
            @enderror
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Unit Balai Kerja</label>
              <input type="text" value="BLK Pusat Vokasi & Pelatihan Kerja" readonly class="w-full bg-slate-100 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-600 font-medium cursor-not-allowed">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Peran Otoritas</label>
              <input type="text" value="Super Administrator BLK" readonly class="w-full bg-slate-100 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-600 font-medium cursor-not-allowed">
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-2">
          <a href="{{ route('admin-blk.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-50 transition shadow-sm">
            Batalkan
          </a>
          <button type="submit" class="px-6 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center gap-2 transition">
            <i data-lucide="check" class="w-4 h-4"></i>
            <span>Simpan Perubahan</span>
          </button>
        </div>
      </form>
    </div>

    <!-- Right Column: Status & Actions -->
    <div class="space-y-6">
      <!-- Status & Authority Card -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <div class="flex items-center gap-2 text-slate-800 font-bold text-xs pb-3 border-b border-slate-100">
          <i data-lucide="shield-check" class="w-4 h-4 text-emerald-700"></i>
          <span>Status Akses Administrator</span>
        </div>

        <div class="space-y-2.5 text-xs">
          <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-lg">
            <span class="text-slate-600">Status Operasional</span>
            <span class="font-semibold text-emerald-700 flex items-center gap-1">
              <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Aktif
            </span>
          </div>
          <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-lg">
            <span class="text-slate-600">Hak Persetujuan Jurnal</span>
            <span class="font-semibold text-slate-800">Ya (Penuh)</span>
          </div>
          <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-lg">
            <span class="text-slate-600">Hak Terbit Sertifikat</span>
            <span class="font-semibold text-slate-800">Ya (Penuh)</span>
          </div>
        </div>
      </div>

      <!-- Danger Zone: Delete Action -->
      <div class="bg-rose-50/50 border border-rose-200 rounded-xl p-5 space-y-3">
        <div class="flex items-center gap-2 text-rose-800 font-bold text-xs">
          <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
          <span>Hapus Administrator</span>
        </div>
        <p class="text-[11px] text-rose-700 leading-relaxed">
          Tindakan ini akan mencabut hak akses administrator BLK untuk akun pengguna ini. Data pelatihan atau sertifikat yang pernah divalidasi akan tetap tersimpan di riwayat sistem.
        </p>
        <form action="{{ route('admin-blk.destroy', $admin->id_admin) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus administrator ini?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full mt-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Administrator
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection

