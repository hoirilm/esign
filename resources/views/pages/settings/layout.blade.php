<div class="bg-white dark:bg-zinc-900 border border-slate-200/80 dark:border-zinc-800 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 dark:shadow-zinc-950/50">
    <div class="flex items-start max-md:flex-col">
        <div class="me-10 w-full pb-4 md:w-[220px]">
            <flux:navlist aria-label="{{ __('Pengaturan') }}">
                <flux:navlist.item :href="route('profile.edit')" wire:navigate class="!rounded-xl font-medium">{{ __('Profil') }}</flux:navlist.item>
                <flux:navlist.item :href="route('security.edit')" wire:navigate class="!rounded-xl font-medium">{{ __('Keamanan') }}</flux:navlist.item>
                <flux:navlist.item :href="route('appearance.edit')" wire:navigate class="!rounded-xl font-medium">{{ __('Tampilan') }}</flux:navlist.item>
            </flux:navlist>
        </div>

        <flux:separator class="md:hidden" />

        <div class="flex-1 self-stretch max-md:pt-6">
            <flux:heading size="lg" class="!font-heading !font-bold">{{ $heading ?? '' }}</flux:heading>
            <flux:subheading class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400">{{ $subheading ?? '' }}</flux:subheading>

            <div class="mt-5 w-full max-w-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

