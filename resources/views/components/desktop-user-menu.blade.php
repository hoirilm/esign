<flux:dropdown position="top" align="start" class="w-full">
    <flux:profile
        :name="auth()->user()->name"
        :initials="auth()->user()->initials()"
        icon-trailing="chevrons-up-down"
        data-test="sidebar-menu-button"
        class="w-full !rounded-2xl !p-2 !bg-slate-50 dark:!bg-zinc-800/80 !border !border-slate-200/80 dark:!border-zinc-800 hover:!border-teal-500/40 hover:!bg-slate-100 dark:hover:!bg-zinc-800 transition-all cursor-pointer"
    />

    <flux:menu class="w-64">
        <div class="p-2.5 border-b border-slate-100 dark:border-zinc-800">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-teal-600 text-white font-bold flex items-center justify-center text-xs font-heading">
                    {{ auth()->user()->initials() }}
                </div>
                <div class="grid flex-1 text-start text-xs leading-tight">
                    <span class="font-bold text-slate-900 dark:text-zinc-100 truncate">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-teal-600 dark:text-teal-400 font-mono font-semibold">{{ auth()->user()->username }} ({{ ucfirst(auth()->user()->role) }})</span>
                </div>
            </div>
        </div>

        <div class="py-1">
            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate @click="$el.closest('ui-menu')?.hidePopover?.()">
                {{ __('Pengaturan Akun') }}
            </flux:menu.item>
        </div>

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


