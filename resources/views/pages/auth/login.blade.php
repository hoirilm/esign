<x-layouts::auth :title="__('Masuk ke Sistem')">
    <div class="w-full max-w-5xl mx-auto my-auto grid grid-cols-1 lg:grid-cols-12 bg-white dark:bg-zinc-900 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-2xl shadow-slate-300/40 dark:shadow-zinc-950/80 overflow-hidden">
        <!-- Left Column: Medical & E-Signature Hero Showcase -->
        <div class="lg:col-span-5 bg-gradient-to-br from-teal-800 via-teal-900 to-slate-950 p-8 lg:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <!-- Ambient Glow Elements -->
            <div class="absolute -top-12 -left-12 w-64 h-64 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -right-16 w-72 h-72 bg-emerald-400/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <!-- Subtle Grid Accent -->
            <div class="absolute inset-0 bg-[radial-gradient(#2dd4bf_1px,transparent_1px)] [background-size:16px_16px] opacity-10 pointer-events-none"></div>

            <div class="relative z-10 space-y-6">
                <!-- Brand Header -->
                <div class="flex items-center justify-between gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group" wire:navigate>
                        <div class="w-11 h-11 rounded-2xl bg-teal-500/20 border border-teal-400/30 text-teal-300 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform backdrop-blur-md">
                            <x-app-logo-icon class="size-6 text-teal-300" />
                        </div>
                        <div>
                            <div class="text-base font-extrabold font-heading tracking-wider uppercase text-white">
                                {{ config('app.name', 'KLINIK') }}
                            </div>
                            <div class="text-[10px] text-teal-200/80 font-medium tracking-wide">
                                E-Signature & Laboratorium
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Live Status Pill -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-950/70 backdrop-blur-md border border-teal-400/30 text-xs font-semibold text-teal-200 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Sistem E-Signature Medis Aktif
                </div>

                <!-- Hero Copy -->
                <div class="space-y-2">
                    <h2 class="text-2xl lg:text-3xl font-extrabold font-heading text-white tracking-tight leading-snug">
                        Hasil Laboratorium Sah & Terverifikasi Digital
                    </h2>
                    <p class="text-xs sm:text-sm text-teal-100/80 leading-relaxed">
                        Sistem terintegrasi untuk penerbitan laporan hasil laboratorium patologi klinik dengan tanda tangan elektronik aman berbasis QR Code kriptografis.
                    </p>
                </div>

                <!-- Feature Highlights -->
                <div class="space-y-3 pt-2">
                    <div class="flex items-center gap-3 text-xs text-teal-100/90 bg-white/5 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <div class="w-7 h-7 rounded-lg bg-teal-500/20 text-teal-300 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <span><strong>TTE Sah & Anti-Manipulasi</strong> dengan QR Code terenkripsi</span>
                    </div>

                    <div class="flex items-center gap-3 text-xs text-teal-100/90 bg-white/5 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <div class="w-7 h-7 rounded-lg bg-teal-500/20 text-teal-300 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                        <span><strong>Manajemen Hasil Lab Lengkap</strong> (Hematologi, Serologi, dll)</span>
                    </div>

                    <div class="flex items-center gap-3 text-xs text-teal-100/90 bg-white/5 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <div class="w-7 h-7 rounded-lg bg-teal-500/20 text-teal-300 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <span><strong>Hak Akses Medis (RBAC)</strong> & Autentikasi Biometrik Passkey</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Trust Badge -->
            <div class="relative z-10 mt-8 pt-6 border-t border-white/10 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center shrink-0 border border-teal-400/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-[11px] leading-tight text-teal-100/70">
                    Sistem mematuhi standar privasi data rekam medis & verifikasi keabsahan dokumen elektronik.
                </div>
            </div>
        </div>

        <!-- Right Column: Interactive Login Form -->
        <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-between gap-6">
            <!-- Mobile Brand Header (Visible only on mobile/tablet) -->
            <div class="flex items-center gap-3 lg:hidden pb-4 border-b border-slate-100 dark:border-zinc-800">
                <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center shadow-md">
                    <x-app-logo-icon class="size-6 text-white" />
                </div>
                <div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-zinc-100">{{ config('app.name', 'KLINIK') }}</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Portal Sistem E-Signature Medis</p>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Form Heading -->
                <div class="space-y-1">
                    <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-zinc-100 tracking-tight">
                        Masuk ke Akun
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400">
                        Masukkan username dan kata sandi Anda untuk mengakses portal laboratorium.
                    </p>
                </div>

                <!-- Session Status Alerts -->
                <x-auth-session-status class="text-center" :status="session('status')" />


                <!-- Passkey Verification Support -->
                <x-passkey-verify />

                <!-- Main Login Form -->
                <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                    @csrf

                    <!-- Username Input -->
                    <flux:input
                        name="username"
                        label="Username"
                        :value="old('username')"
                        type="text"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Masukkan username"
                        icon="user"
                    />

                    <!-- Password Input -->
                    <div class="relative space-y-1">
                        <flux:input
                            id="password-field"
                            name="password"
                            label="Kata Sandi"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan kata sandi"
                            icon="lock-closed"
                            viewable
                        />

                        @if (Route::has('password.request'))
                            <div class="flex justify-end pt-1">
                                <flux:link class="text-xs text-teal-600 dark:text-teal-400 hover:underline font-medium" :href="route('password.request')" wire:navigate>
                                    Lupa kata sandi?
                                </flux:link>
                            </div>
                        @endif
                    </div>

                    <!-- Remember Me -->
                    <div class="pt-1">
                        <flux:checkbox name="remember" label="Ingat sesi saya di perangkat ini" :checked="old('remember')" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <flux:button
                            variant="primary"
                            type="submit"
                            icon-trailing="arrow-right"
                            class="w-full !bg-gradient-to-r !from-teal-600 !to-teal-500 hover:!from-teal-500 hover:!to-teal-400 !text-white font-bold !border-none !py-2.5 !rounded-xl shadow-lg shadow-teal-700/25 active:scale-[0.99] transition-all cursor-pointer"
                            data-test="login-button"
                        >
                            {{ __('Masuk ke Sistem') }}
                        </flux:button>
                    </div>
                </form>

                @if (Route::has('register'))
                    <div class="text-center text-xs text-slate-500 dark:text-zinc-400">
                        <span>Belum memiliki akun terdaftar?</span>
                        <flux:link :href="route('register')" class="text-teal-600 dark:text-teal-400 font-semibold ml-1" wire:navigate>
                            Daftar di sini
                        </flux:link>
                    </div>
                @endif
            </div>

            <!-- Security Footer -->
            <div class="pt-4 border-t border-slate-100 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400 dark:text-zinc-500">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Enkripsi SSL & Sertifikat TTE Digital</span>
                </div>
                <div>&copy; {{ date('Y') }} {{ config('app.name', 'KLINIK') }}</div>
            </div>
        </div>
    </div>
</x-layouts::auth>

