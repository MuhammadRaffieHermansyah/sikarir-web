{{-- Tombol admin untuk mereset sandi peserta/instruktur/mitra. --}}
@props(['user'])

@if ($user)
  <form
    action="{{ route('users.reset-password', $user) }}"
    method="POST"
    class="inline"
    data-confirm-title="Reset sandi akun ini?"
    data-confirm-eyebrow="Atur ulang sandi"
    data-confirm-button="Ya, reset sandi"
    onsubmit="return confirm('Reset sandi akun {{ $user->email }}? Sandi lama tidak berlaku lagi dan pengguna akan keluar dari aplikasi.')"
  >
    @csrf
    @method('PATCH')
    <x-ui.button type="submit" variant="outline">
      <x-lucide-key-round />
      Reset Sandi
    </x-ui.button>
  </form>
@endif
