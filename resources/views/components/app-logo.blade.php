@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand :name="config('app.name', 'KLINIK')" {{ $attributes }} class="!font-heading !font-extrabold tracking-wider">
        <x-slot name="logo" class="flex aspect-square size-9 items-center justify-center rounded-xl bg-teal-600 text-white dark:bg-teal-500 dark:text-slate-950 shadow-md shadow-teal-900/10">
            <x-app-logo-icon class="size-5 fill-current" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="config('app.name', 'KLINIK')" {{ $attributes }} class="!font-heading !font-extrabold tracking-wider">
        <x-slot name="logo" class="flex aspect-square size-9 items-center justify-center rounded-xl bg-teal-600 text-white dark:bg-teal-500 dark:text-slate-950 shadow-md shadow-teal-900/10">
            <x-app-logo-icon class="size-5 fill-current" />
        </x-slot>
    </flux:brand>
@endif

