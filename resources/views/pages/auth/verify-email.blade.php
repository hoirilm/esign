<x-layouts::auth :title="__('Verifikasi Email')">
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
                :title="__('Verifikasi Alamat Email')"
                :description="__('Silakan verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan ke email Anda.')"
            />

            @if (session('status') == 'verification-link-sent')
                <flux:text class="text-center font-medium !text-emerald-600 dark:!text-emerald-400 text-xs">
                    {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda daftarkan.') }}
                </flux:text>
            @endif

            <div class="flex flex-col items-center justify-between space-y-3 pt-2">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                    @csrf
                    <flux:button type="submit" variant="primary" class="w-full !bg-gradient-to-r !from-teal-600 !to-teal-500 hover:!from-teal-500 hover:!to-teal-400 !text-white font-bold !border-none shadow-lg shadow-teal-700/25 !rounded-xl active:scale-[0.99] transition-all cursor-pointer">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </flux:button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:button variant="ghost" type="submit" class="w-full text-xs text-slate-500 hover:text-slate-700 dark:text-zinc-400 dark:hover:text-zinc-200 cursor-pointer !rounded-xl" data-test="logout-button">
                        {{ __('Keluar dari Akun') }}
                    </flux:button>
                </form>
            </div>
        </div>
    </div>
</x-layouts::auth>


