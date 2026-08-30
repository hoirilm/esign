<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-50 dark:bg-zinc-950 text-slate-900 dark:text-zinc-100 antialiased font-sans selection:bg-teal-500 selection:text-white">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-slate-200/80 bg-white/95 dark:border-zinc-800 dark:bg-zinc-900/95 backdrop-blur-xl shadow-xl shadow-slate-200/30 dark:shadow-zinc-950/40 z-20">
            <flux:sidebar.header class="pb-3 border-b border-slate-100 dark:border-zinc-800">
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('MENU UTAMA')" class="grid pt-3">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="!rounded-xl font-medium">
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="users" :href="route('patients.index')" :current="request()->routeIs('patients.*')" wire:navigate class="!rounded-xl font-medium">
                        {{ __('Data Pasien') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document-text" :href="route('lab-requests.index')" :current="request()->routeIs('lab-requests.*')" wire:navigate class="!rounded-xl font-medium">
                        {{ __('Pemeriksaan Lab') }}
                    </flux:sidebar.item>
                    @if(auth()->user() && auth()->user()->isAdmin())
                        <flux:sidebar.item icon="user-group" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate class="!rounded-xl font-medium">
                            {{ __('Manajemen User (RBAC)') }}
                        </flux:sidebar.item>
                    @endif
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <div class="pt-3 border-t border-slate-100 dark:border-zinc-800">
                <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
            </div>
        </flux:sidebar>

        <!-- Mobile Header Bar -->
        <flux:header class="lg:hidden border-b border-slate-200/80 bg-white/90 dark:border-zinc-800 dark:bg-zinc-900/90 backdrop-blur-xl px-4 py-3 z-20">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <div class="p-2 border-b border-slate-100 dark:border-zinc-800">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-teal-600 text-white font-bold flex items-center justify-center text-xs">
                                {{ auth()->user()->initials() }}
                            </div>
                            <div class="grid flex-1 text-start text-xs leading-tight">
                                <span class="font-bold text-slate-900 dark:text-zinc-100 truncate">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] text-teal-600 font-semibold uppercase">{{ ucfirst(auth()->user()->role) }}</span>
                            </div>
                        </div>
                    </div>

                    <flux:menu.separator />

                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate @click="$el.closest('ui-menu')?.hidePopover?.()">
                        {{ __('Pengaturan') }}
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer text-rose-600 hover:text-rose-700 dark:text-rose-400"
                            data-test="logout-button"
                        >
                            {{ __('Keluar') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>


