<x-layouts::auth :title="__('Lupa Kata Sandi')">
    <div class="w-full max-w-md flex flex-col gap-6">
        <!-- Medical Brand Header -->
        <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 group text-center" wire:navigate>
            <div class="w-12 h-12 rounded-2xl bg-teal-600 dark:bg-teal-500 text-white dark:text-slate-950 shadow-lg shadow-teal-900/20 flex items-center justify-center group-hover:scale-105 transition-transform">
                <x-app-logo-icon class="size-6 fill-current" />
            </div>
            <div>
                <span class="font-extrabold font-heading text-lg text-slate-900 dark:text-zinc-100 tracking-tight">{{ config('app.name', 'KLINIK') }}</span>
                <p class="text-[11px] text-teal-600 dark:text-teal-400 font-medium">E-Signature & Laboratorium Medis</p>
            </div>
        </a>

        <!-- Card Content -->
        <div class="rounded-3xl border border-slate-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 sm:p-8 shadow-2xl shadow-slate-200/50 dark:shadow-zinc-950/80 space-y-6">
            <x-auth-header
                :title="__('Lupa Kata Sandi')"
                :description="__('Masukkan email Anda untuk menerima instruksi pemulihan kata sandi akun.')"
            />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <flux:input
                    name="email"
                    label="Alamat Email Terdaftar"
                    type="email"
                    required
                    autofocus
                    placeholder="nama@email.com"
                    icon="envelope"
                />

                <div class="pt-2">
                    <flux:button
                        variant="primary"
                        type="submit"
                        class="w-full !bg-gradient-to-r !from-teal-600 !to-teal-500 hover:!from-teal-500 hover:!to-teal-400 !text-white font-bold !border-none !py-2.5 !rounded-xl shadow-lg shadow-teal-700/25 active:scale-[0.99] transition-all cursor-pointer"
                        data-test="email-password-reset-link-button"
                    >
                        Kirim Tautan Reset Kata Sandi
                    </flux:button>
                </div>
            </form>

            <div class="text-center text-xs text-slate-500 dark:text-zinc-400 pt-2 border-t border-slate-100 dark:border-zinc-800">
                <span>Sudah ingat kata sandi?</span>
                <flux:link :href="route('login')" class="text-teal-600 dark:text-teal-400 font-semibold ml-1" wire:navigate>
                    Kembali ke Login
                </flux:link>
            </div>
        </div>
    </div>
</x-layouts::auth>



