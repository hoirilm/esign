<x-layouts::auth :title="__('Autentikasi Dua Faktor (2FA)')">
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
            <div
                class="relative w-full h-auto"
                x-cloak
                x-data="{
                    showRecoveryInput: @js($errors->has('recovery_code')),
                    code: '',
                    recovery_code: '',
                    focusOtp() {
                        this.$nextTick(() => this.$refs.otp?.querySelector('input')?.focus());
                    },
                    init() {
                        if (! this.showRecoveryInput) {
                            this.focusOtp();
                        }
                    },
                    toggleInput() {
                        this.showRecoveryInput = !this.showRecoveryInput;

                        this.code = '';
                        this.recovery_code = '';

                        $nextTick(() => {
                            this.showRecoveryInput
                                ? this.$refs.recovery_code?.focus()
                                : this.focusOtp();
                        });
                    },
                }"
            >
                <div x-show="!showRecoveryInput">
                    <x-auth-header
                        :title="__('Kode Autentikasi')"
                        :description="__('Masukkan kode 6 digit dari aplikasi autentikator Anda.')"
                    />
                </div>

                <div x-show="showRecoveryInput">
                    <x-auth-header
                        :title="__('Kode Pemulihan')"
                        :description="__('Konfirmasi akses dengan memasukkan salah satu kode pemulihan darurat Anda.')"
                    />
                </div>

                <form method="POST" action="{{ route('two-factor.login.store') }}">
                    @csrf

                    <div class="space-y-5 text-center">
                        <div x-show="!showRecoveryInput">
                            <div class="flex items-center justify-center my-5" x-ref="otp">
                                <flux:otp
                                    x-model="code"
                                    length="6"
                                    name="code"
                                    label="OTP Code"
                                    label:sr-only
                                    class="mx-auto"
                                 />
                            </div>
                        </div>

                        <div x-show="showRecoveryInput">
                            <div class="my-5">
                                <flux:input
                                    type="text"
                                    name="recovery_code"
                                    x-ref="recovery_code"
                                    x-bind:required="showRecoveryInput"
                                    autocomplete="one-time-code"
                                    placeholder="XXXXX-XXXXX"
                                    x-model="recovery_code"
                                />
                            </div>

                            @error('recovery_code')
                                <flux:text color="red">
                                    {{ $message }}
                                </flux:text>
                            @enderror
                        </div>

                        <flux:button
                            variant="primary"
                            type="submit"
                            class="w-full !bg-gradient-to-r !from-teal-600 !to-teal-500 hover:!from-teal-500 hover:!to-teal-400 !text-white font-bold !border-none shadow-lg shadow-teal-700/25 !rounded-xl active:scale-[0.99] transition-all cursor-pointer"
                        >
                            {{ __('Lanjutkan') }}
                        </flux:button>
                    </div>

                    <div class="mt-5 space-x-0.5 text-xs text-center text-slate-500 dark:text-zinc-400">
                        <span>{{ __('Atau Anda dapat') }}</span>
                        <button type="button" class="inline font-semibold text-teal-600 hover:text-teal-700 dark:text-teal-400 underline cursor-pointer" @click="toggleInput()">
                            <span x-show="!showRecoveryInput">{{ __('masuk dengan kode pemulihan') }}</span>
                            <span x-show="showRecoveryInput">{{ __('masuk dengan kode autentikator') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::auth>


