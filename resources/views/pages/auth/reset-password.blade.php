<x-layouts::auth :title="__('Atur Ulang Kata Sandi')">
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
                :title="__('Atur Ulang Kata Sandi')"
                :description="__('Masukkan kata sandi baru untuk akun Anda di bawah ini.')"
            />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                <!-- Token -->
                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <!-- Email Address -->
                <flux:input
                    name="email"
                    value="{{ request('email') }}"
                    label="Alamat Email"
                    type="email"
                    required
                    autocomplete="email"
                    icon="envelope"
                />

                <!-- Password -->
                <flux:input
                    name="password"
                    label="Kata Sandi Baru"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    icon="lock-closed"
                    viewable
                />

                <!-- Confirm Password -->
                <flux:input
                    name="password_confirmation"
                    label="Konfirmasi Kata Sandi Baru"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi kata sandi baru"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    icon="lock-closed"
                    viewable
                />

                <div class="pt-2">
                    <flux:button
                        type="submit"
                        variant="primary"
                        class="w-full !bg-gradient-to-r !from-teal-600 !to-teal-500 hover:!from-teal-500 hover:!to-teal-400 !text-white font-bold !border-none !py-2.5 !rounded-xl shadow-lg shadow-teal-700/25 active:scale-[0.99] transition-all cursor-pointer"
                        data-test="reset-password-button"
                    >
                        Simpan Kata Sandi Baru
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::auth>



