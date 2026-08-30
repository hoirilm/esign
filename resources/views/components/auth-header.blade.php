@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center space-y-1">
    <flux:heading size="xl" class="!font-heading !font-extrabold !tracking-tight !text-slate-900 dark:!text-zinc-100">{{ $title }}</flux:heading>
    <flux:subheading class="!text-xs sm:!text-sm !text-slate-500 dark:!text-zinc-400">{{ $description }}</flux:subheading>
</div>

