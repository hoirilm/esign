<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-100 dark:bg-zinc-950 text-slate-900 dark:text-zinc-100 antialiased font-sans">
        <div class="relative grid min-h-dvh flex-col items-center justify-center lg:max-w-none lg:grid-cols-2 lg:px-0">
            <!-- Left Hero Section -->
            <div class="relative hidden h-full flex-col p-10 text-white lg:flex bg-gradient-to-br from-teal-800 via-teal-900 to-slate-950 border-e border-teal-700/30 overflow-hidden justify-between">
                <div class="absolute -top-20 -left-20 w-80 h-80 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-emerald-400/15 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-20 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 text-lg font-bold font-heading group" wire:navigate>
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-500/20 border border-teal-400/30 text-teal-300 shadow-md backdrop-blur-md group-hover:scale-105 transition-transform">
                            <x-app-logo-icon class="size-6 text-teal-300" />
                        </span>
                        <div>
                            <span class="tracking-wider uppercase">{{ config('app.name', 'KLINIK') }}</span>
                            <span class="block text-[10px] text-teal-200/80 font-normal font-sans">E-Signature & Laboratorium</span>
                        </div>
                    </a>

                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-950/70 backdrop-blur-md border border-teal-400/30 text-xs font-semibold text-teal-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Sistem Medis Aktif
                    </div>
                </div>

                <div class="relative z-20 my-auto py-12 space-y-4 max-w-lg">
                    <h1 class="text-3xl lg:text-4xl font-extrabold font-heading text-white tracking-tight leading-snug">
                        Autentikasi & Verifikasi Hasil Pemeriksaan Medis
                    </h1>
                    <p class="text-sm text-teal-100/80 leading-relaxed">
                        Integritas dokumen hasil laboratorium dijamin dengan sertifikat tanda tangan elektronik berstandar kriptografis dan QR Code verifikasi instan.
                    </p>
                </div>

                <div class="relative z-20 mt-auto pt-6 border-t border-white/10 flex items-center gap-3 text-xs text-teal-100/70">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Dilindungi Enkripsi SSL & Rekam Medis Terproteksi</span>
                </div>
            </div>

            <!-- Right Content Section -->
            <div class="w-full p-6 sm:p-10 lg:p-16 flex items-center justify-center">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:max-w-md">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-600 text-white shadow-md">
                            <x-app-logo-icon class="size-6 text-white" />
                        </span>
                        <span class="font-bold font-heading text-lg text-slate-900 dark:text-zinc-100">{{ config('app.name', 'KLINIK') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>

