<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-50 dark:bg-zinc-950 text-slate-900 dark:text-zinc-100 antialiased font-sans selection:bg-teal-500 selection:text-white">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-600 dark:bg-teal-500 text-white dark:text-slate-950 shadow-md">
                        <x-app-logo-icon class="size-6 fill-current" />
                    </span>
                    <span class="font-extrabold font-heading text-lg text-slate-900 dark:text-zinc-100 tracking-tight">{{ config('app.name', 'KLINIK') }}</span>
                </a>

                <div class="flex flex-col gap-6">
                    <div class="rounded-3xl border border-slate-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-2xl shadow-slate-300/40 dark:shadow-zinc-950/80">
                        <div class="px-8 py-8 sm:px-10 sm:py-10">{{ $slot }}</div>
                    </div>
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

