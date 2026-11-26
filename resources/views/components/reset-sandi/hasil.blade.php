{{-- Sandi sementara hasil reset oleh admin; hanya tampil sekali setelah reset. --}}
@props(['user'])

@if ($user)
  @php($hasil = session('sandi_sementara'))

  @if ($hasil && ($hasil['email'] ?? null) === $user->email)
    <x-ui.alert tone="warning">
      <x-lucide-key-round />
      <x-ui.alert-title>Sandi sementara untuk {{ $user->email }}</x-ui.alert-title>
      <x-ui.alert-description>
        <p>
          Serahkan sandi ini langsung kepada pemilik akun:
          <code class="ml-1 rounded bg-background px-2 py-0.5 font-mono text-base font-bold tracking-wider text-foreground" data-testid="sandi-sementara">{{ $hasil['sandi'] }}</code>
        </p>
        <p class="mt-1">Sandi hanya tampil sekali. Setelah login di aplikasi, pengguna diminta mengganti sandinya.</p>
      </x-ui.alert-description>
    </x-ui.alert>
  @endif
@endif
