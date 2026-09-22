@extends('layouts.app')

@section('title', 'Dashboard Ringkasan Eksekutif & Admin BLK')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <span>Beranda</span> &gt; <span class="text-slate-600 font-medium">Dashboard Ringkasan</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Ringkasan Eksekutif & Operasional Balai</h1>
      <p class="text-xs text-slate-500 mt-0.5">Pantau aktivitas pelatihan vokasi, progres magang industri, verifikasi sertifikasi, dan manajemen administrator BLK.</p>
    </div>

    <div class="flex flex-wrap items-center gap-2 self-start md:self-auto">
      <select class="bg-white border border-slate-200 text-xs px-3 py-2 rounded-lg font-medium shadow-sm focus:outline-none text-slate-700">
        <option>Gelombang II - TA 2024/2025</option>
        <option>Gelombang I - TA 2024/2025</option>
      </select>
      <select class="bg-white border border-slate-200 text-xs px-3 py-2 rounded-lg font-medium shadow-sm focus:outline-none text-slate-700">
        <option>Semua Balai (BLK Regional)</option>
        <option>BLK Pusat Vokasi</option>
      </select>

      <a href="{{ route('admin-blk.create') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah Admin BLK
      </a>
    </div>
  </div>

  <!-- Session Alerts -->
  @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
      <div class="flex items-center gap-2.5">
        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
          <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-700"></i>
        </div>
        <span class="font-medium">{{ session('success') }}</span>
      </div>
      <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
        <i data-lucide="x" class="w-4 h-4"></i>
      </button>
    </div>
  @endif

  <!-- Component: Stat Cards -->
  <x-stat-cards />

  <!-- Component: Chart Section -->
  <x-chart-section />

  <!-- Management Section: Admin BLK Personnel Table -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <div class="flex items-center gap-2">
          <div class="p-1.5 bg-emerald-50 text-emerald-700 rounded-lg">
            <i data-lucide="shield-check" class="w-4 h-4"></i>
          </div>
          <h2 class="font-bold text-slate-800 text-sm">Daftar Administrator BLK</h2>
          <span class="bg-emerald-100 text-emerald-800 text-[11px] font-semibold px-2 py-0.5 rounded-full">
            {{ isset($admins) ? $admins->total() : 0 }} Pengelola
          </span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Daftar personel dan staf yang memiliki hak otoritas manajemen operasional BLK.</p>
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('admin-blk.create') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm transition">
          <i data-lucide="plus" class="w-3.5 h-3.5"></i>
          <span>Tambah Admin</span>
        </a>
      </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead>
          <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-[11px] uppercase tracking-wider">
            <th class="px-5 py-3 font-semibold">Administrator</th>
            <th class="px-5 py-3 font-semibold">Email & Kontak</th>
            <th class="px-5 py-3 font-semibold">Peran / Otoritas</th>
            <th class="px-5 py-3 font-semibold text-center">Tanggung Jawab</th>
            <th class="px-5 py-3 font-semibold">Terdaftar Sejak</th>
            <th class="px-5 py-3 font-semibold text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($admins ?? [] as $admin)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="px-5 py-3.5">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-600 to-teal-800 text-white font-bold flex items-center justify-center text-xs shadow-sm shrink-0">
                    {{ strtoupper(substr($admin->user->name ?? 'A', 0, 2)) }}
                  </div>
                  <div>
                    <a href="{{ route('admin-blk.show', $admin->id_admin) }}" class="font-bold text-slate-800 hover:text-emerald-700 transition">
                      {{ $admin->user->name ?? 'Tanpa Nama' }}
                    </a>
                    <div class="text-[10px] text-slate-400 flex items-center gap-1">
                      <span>ID Admin: #BLK-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}</span>
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-medium text-slate-800 flex items-center gap-1.5">
                  <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i>
                  <span>{{ $admin->user->email ?? '-' }}</span>
                </div>
                <div class="text-[10px] text-slate-400 mt-0.5">
                  Role Akun: <span class="capitalize font-medium text-slate-600">{{ $admin->user->role ?? 'admin_blk' }}</span>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200/80 px-2.5 py-1 rounded-full text-[11px] font-semibold">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                  Super Admin Balai
                </span>
              </td>
              <td class="px-5 py-3.5 text-center">
                <div class="inline-flex items-center gap-2 text-slate-600">
                  <span class="inline-flex items-center gap-1 bg-slate-100 px-2 py-0.5 rounded text-[10px] font-medium" title="Program Pelatihan">
                    <i data-lucide="book-open" class="w-3 h-3 text-slate-500"></i> {{ count($admin->pelatihan ?? []) }}
                  </span>
                  <span class="inline-flex items-center gap-1 bg-slate-100 px-2 py-0.5 rounded text-[10px] font-medium" title="Lowongan Diposting">
                    <i data-lucide="briefcase" class="w-3 h-3 text-slate-500"></i> {{ count($admin->lowongan ?? []) }}
                  </span>
                  <span class="inline-flex items-center gap-1 bg-slate-100 px-2 py-0.5 rounded text-[10px] font-medium" title="Sertifikat">
                    <i data-lucide="award" class="w-3 h-3 text-slate-500"></i> {{ count($admin->sertifikat ?? []) }}
                  </span>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-medium text-slate-800">{{ $admin->created_at ? $admin->created_at->translatedFormat('d M Y') : '-' }}</div>
                <div class="text-[10px] text-slate-400">{{ $admin->created_at ? $admin->created_at->diffForHumans() : '' }}</div>
              </td>
              <td class="px-5 py-3.5 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a href="{{ route('admin-blk.show', $admin->id_admin) }}" class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition" title="Lihat Profil">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('admin-blk.edit', $admin->id_admin) }}" class="p-1.5 text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition" title="Edit Data">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('admin-blk.destroy', $admin->id_admin) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus administrator ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Hapus Administrator">
                      <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-5 py-10 text-center text-slate-400">
                <div class="flex flex-col items-center justify-center gap-2">
                  <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                    <i data-lucide="users" class="w-6 h-6"></i>
                  </div>
                  <p class="text-xs font-medium text-slate-600">Belum ada data Administrator BLK</p>
                  <a href="{{ route('admin-blk.create') }}" class="text-xs text-emerald-700 hover:underline font-semibold flex items-center gap-1">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambahkan Admin Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($admins) && $admins->hasPages())
      <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
        {{ $admins->links() }}
      </div>
    @endif
  </div>

  <!-- Grid Section: Table & Side Widgets -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
      <!-- Component: Approval Table -->
      <x-approval-table />
    </div>

    <div class="space-y-6">
      <!-- Component: Quick Actions -->
      <x-quick-actions />

      <!-- Component: Agenda Section -->
      <x-agenda-section />
    </div>
  </div>
@endsection