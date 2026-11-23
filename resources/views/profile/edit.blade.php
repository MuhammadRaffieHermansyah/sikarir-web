@extends('layouts.app')

@section('title', 'Profil Akun - SiKarir')

@section('content')
  @php
    $isMitra = $user->role === 'mitra';
    $isMitraVerified = $isMitra && $user->mitra?->is_verified;
  @endphp

  <x-ui.page-header
    title="Profil Akun"
    description="Kelola informasi pribadi, keamanan kata sandi, dan status akun Anda."
  >
    <x-slot:actions>
      @if ($isMitra && $isMitraVerified)
        <x-ui.badge tone="success" class="gap-1.5">
          <x-lucide-badge-check class="size-3.5 text-blue-500" />
          Mitra Terverifikasi
        </x-ui.badge>
      @elseif ($isMitra)
        <x-ui.badge tone="warning" class="gap-1.5">
          <x-lucide-clock-3 class="size-3.5" />
          Menunggu Verifikasi Mitra
        </x-ui.badge>
      @elseif ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && $user->hasVerifiedEmail())
        <x-ui.badge tone="success" class="gap-1.5">
          <x-lucide-badge-check class="size-3.5" />
          Email Terverifikasi
        </x-ui.badge>
      @else
        <x-ui.badge tone="warning" class="gap-1.5">
          <x-lucide-triangle-alert class="size-3.5" />
          Email Belum Terverifikasi
        </x-ui.badge>
      @endif
    </x-slot:actions>
  </x-ui.page-header>

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
      @include('profile.partials.update-profile-information-form')
      @include('profile.partials.update-password-form')
    </div>

    <div class="space-y-6">
      <x-ui.card>
        <div class="flex items-center gap-4">
          <x-ui.avatar class="size-14">
            <x-ui.avatar-fallback class="bg-primary/10 text-lg font-bold text-primary">
              {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
            </x-ui.avatar-fallback>
          </x-ui.avatar>

          <div class="min-w-0">
            <div class="truncate text-sm font-bold text-foreground">{{ $user->name }}</div>
            <div class="truncate text-xs text-muted-foreground">{{ $user->email }}</div>
          </div>
        </div>

        <x-ui.separator class="my-4" />

        <div class="mt-4 space-y-2">
          <div class="flex items-center justify-between gap-3 text-xs">
            <span class="text-muted-foreground">Peran Akun</span>
            <x-ui.badge variant="secondary" size="sm">
              {{ match ($user->role) {
                  'admin_blk' => 'Admin BLK',
                  'mitra' => 'Mitra DU/DI',
                  default => 'Pengguna',
              } }}
            </x-ui.badge>
          </div>
          <div class="flex items-center justify-between gap-3 text-xs">
            <span class="text-muted-foreground">{{ $isMitra ? 'Status Mitra' : 'Status Email' }}</span>
            <span class="font-semibold text-foreground">
              {{ $isMitra ? ($isMitraVerified ? 'Terverifikasi' : 'Menunggu Verifikasi') : ($user->hasVerifiedEmail() ? 'Terverifikasi' : 'Belum Terverifikasi') }}
            </span>
          </div>
          <div class="flex items-center justify-between gap-3 text-xs">
            <span class="text-muted-foreground">Terdaftar Sejak</span>
            <span class="font-semibold text-foreground">
              {{ $user->created_at?->translatedFormat('d M Y') ?? '—' }}
            </span>
          </div>
        </div>
      </x-ui.card>

      @include('profile.partials.delete-user-form')
    </div>
  </div>
@endsection
