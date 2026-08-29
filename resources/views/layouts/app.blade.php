<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main class="w-full lg:w-[75%] lg:max-w-7xl mx-auto !p-6 lg:!py-8">
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
