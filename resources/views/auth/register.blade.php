<x-guest-layout>
    <!-- Main Card (2 Columns Layout) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-12">
        
        <!-- LEFT COLUMN: Minimalist Vector & Branding SIKARIR -->
        <div class="lg:col-span-5 bg-gradient-to-br from-emerald-900 via-teal-950 to-slate-900 text-white p-8 md:p-10 flex flex-col justify-between relative overflow-hidden">
            <!-- Background Accent Circles -->
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Brand -->
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-10 h-10 bg-white/10 backdrop-blur border border-white/20 text-white rounded-xl font-black flex items-center justify-center text-xs shadow-inner shrink-0">
                    <i data-lucide="layers" class="w-5 h-5 text-emerald-400"></i>
                </div>
                <div>
                    <h1 class="font-black text-lg leading-none tracking-wider text-white">SIKARIR</h1>
                    <p class="text-[10px] text-emerald-300 font-medium tracking-wide mt-0.5">BLK PUSAT VOKASI</p>
                </div>
            </div>

            <!-- Center Vector & Hero Text -->
            <div class="relative z-10 my-8 space-y-6">
                <!-- Abstract Vector Graphic -->
                <div class="w-24 h-24 mx-auto rounded-3xl bg-gradient-to-tr from-emerald-500/20 to-teal-400/10 border border-emerald-400/20 backdrop-blur-md flex items-center justify-center shadow-2xl shadow-emerald-950">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center">
                        <i data-lucide="user-plus" class="w-9 h-9 text-emerald-300"></i>
                    </div>
                </div>

                <div class="text-center space-y-2">
                    <h2 class="text-2xl font-black tracking-tight text-white leading-snug">
                        Bergabung Bersama Kami
                    </h2>
                    <p class="text-xs text-emerald-100/70 leading-relaxed max-w-xs mx-auto">
                        Buat akun baru untuk mengakses pendaftaran pelatihan vokasi, sertifikasi kompetensi, dan peluang karir.
                    </p>
                </div>
            </div>

            <!-- Bottom Footer Text -->
            <div class="relative z-10 pt-6 border-t border-white/10 text-center">
                <p class="text-[11px] text-emerald-200/60 font-medium">
                    Balai Latihan Kerja • Kementerian Ketenagakerjaan
                </p>
            </div>
        </div>

        <!-- RIGHT COLUMN: Form Register SIKARIR -->
        <div class="lg:col-span-7 p-6 md:p-10 flex flex-col justify-between bg-white">
            
            <div>
                <!-- Top Header Form -->
                <div class="flex items-center justify-between mb-8">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        REGISTRASI AKUN BARU
                    </span>
                    <span class="text-xs font-semibold text-slate-400">
                        v1.0.0
                    </span>
                </div>

                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Akun SIKARIR</h2>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Lengkapi data diri Anda di bawah ini untuk membuat akun pengguna baru.
                </p>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                    @csrf

                    <!-- Name Field -->
                    <div class="space-y-1.5">
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </div>
                            <input id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="name" 
                                   placeholder="Masukkan nama lengkap" 
                                   class="w-full bg-slate-50 border @error('name') border-rose-500 @else border-slate-200 @enderror rounded-xl pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                        </div>
                        @error('name')
                            <p class="text-[10px] text-rose-500 font-medium mt-0.5 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Alamat Email <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="username" 
                                   placeholder="nama@email.com" 
                                   class="w-full bg-slate-50 border @error('email') border-rose-500 @else border-slate-200 @enderror rounded-xl pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                        </div>
                        @error('email')
                            <p class="text-[10px] text-rose-500 font-medium mt-0.5 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Kata Sandi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </div>
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password" 
                                   placeholder="Buat kata sandi minimal 8 karakter" 
                                   class="w-full bg-slate-50 border @error('password') border-rose-500 @else border-slate-200 @enderror rounded-xl pl-10 pr-10 py-2.5 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                            <button type="button" onclick="togglePassword('password', 'eyeIcon1')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
                                <i data-lucide="eye" id="eyeIcon1" class="w-4 h-4"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-[10px] text-rose-500 font-medium mt-0.5 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </div>
                            <input id="password_confirmation" 
                                   type="password" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password" 
                                   placeholder="Ulangi kata sandi Anda" 
                                   class="w-full bg-slate-50 border @error('password_confirmation') border-rose-500 @else border-slate-200 @enderror rounded-xl pl-10 pr-10 py-2.5 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                            <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
                                <i data-lucide="eye" id="eyeIcon2" class="w-4 h-4"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-[10px] text-rose-500 font-medium mt-0.5 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full py-3 px-4 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center justify-center gap-2 group cursor-pointer">
                            <span>Daftar Sekarang</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </form>

                <!-- Login Link Box -->
                <div class="mt-6 p-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-center text-xs text-slate-600 font-medium">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-bold text-emerald-800 hover:underline inline-flex items-center gap-0.5">
                        Masuk Sekarang <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            <!-- Helpdesk Box Bottom -->
            <div class="mt-8 pt-4 border-t border-slate-100 flex items-center gap-2">
                <div class="p-2 bg-emerald-100 text-emerald-800 rounded-lg shrink-0">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                </div>
                <div>
                    <div class="font-bold text-slate-800 text-[11px]">Helpdesk & Dukungan Sistem</div>
                    <div class="text-[10px] text-slate-400">Tim Operasional Sistem Informasi Vokasi BLK</div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Footer Bar -->
    <div class="mt-4 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 gap-2 px-2">
        <div class="flex items-center gap-1">
            <i data-lucide="lock" class="w-3 h-3 text-emerald-600"></i>
            <span>Koneksi Terenkripsi SSL - SIKARIR BLK</span>
        </div>
        <div class="font-medium">
            &copy; {{ date('Y') }} SIKARIR Pusat Vokasi
        </div>
    </div>

    <!-- Toggle Password Script -->
    <script>
        function togglePassword(inputId, iconId) {
            const pwdInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                pwdInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</x-guest-layout>