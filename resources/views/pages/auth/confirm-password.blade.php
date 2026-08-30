<x-layouts::auth :title="__('Konfirmasi Kata Sandi')">
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
                :title="__('Konfirmasi Kata Sandi')"
                :description="__('Ini adalah area aman aplikasi. Silakan konfirmasi kata sandi Anda sebelum melanjutkan.')"
            />

            <x-auth-session-status class="text-center" :status="session('status')" />

            <x-passkey-verify
                options-route="passkey.confirm-options"
                submit-route="passkey.confirm"
                :label="__('Konfirmasi dengan Passkey')"
                :loading-label="__('Memverifikasi...')"
                :separator="__('ATAU DENGAN KATA SANDI')"
            />

            <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
                @csrf

                <flux:input
                    name="password"
                    :label="__('Kata Sandi')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Masukkan kata sandi')"
                    viewable
                />

                <flux:button variant="primary" type="submit" class="w-full !bg-gradient-to-r !from-teal-600 !to-teal-500 hover:!from-teal-500 hover:!to-teal-400 !text-white font-bold !border-none shadow-lg shadow-teal-700/25 !rounded-xl active:scale-[0.99] transition-all cursor-pointer" data-test="confirm-password-button">
                    {{ __('Konfirmasi') }}
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts::auth>


