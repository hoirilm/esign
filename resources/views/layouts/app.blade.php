<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main container class="p-6 lg:p-8">
        {{ $slot }}
    </flux:main>

    <!-- Floating Toast Notification (Top Right) -->
    <div x-data="{
        show: false,
        type: 'success',
        message: '',
        init() {
            @if(session()->has('message'))
                $nextTick(() => { this.trigger('success', @js(session('message'))); });
            @endif
            @if(session()->has('error'))
                $nextTick(() => { this.trigger('error', @js(session('error'))); });
            @endif
        },
        trigger(type, message) {
            this.type = type;
            this.message = message;
            this.show = true;
            setTimeout(() => { this.show = false; }, 4500);
        }
    }"
    x-on:notify.window="trigger(($event.detail && $event.detail.type) || ($event.detail && $event.detail[0] && $event.detail[0].type) || 'success', ($event.detail && $event.detail.message) || ($event.detail && $event.detail[0] && $event.detail[0].message) || $event.detail)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="-translate-y-4 opacity-0 scale-95"
    x-transition:enter-end="translate-y-0 opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="translate-y-0 opacity-100 scale-100"
    x-transition:leave-end="-translate-y-4 opacity-0 scale-95"
    class="fixed top-6 right-6 z-50 max-w-sm w-full pointer-events-auto"
    style="display: none;"
    >
        <div :class="{
            'bg-slate-900/95 dark:bg-zinc-800/95 text-white border-emerald-500/40 shadow-emerald-950/20': type === 'success',
            'bg-slate-900/95 dark:bg-zinc-800/95 text-white border-rose-500/40 shadow-rose-950/20': type === 'error'
        }" class="p-4 rounded-2xl border shadow-2xl backdrop-blur-xl flex items-center justify-between gap-3 font-medium text-xs sm:text-sm">
            <div class="flex items-center gap-3">
                <template x-if="type === 'success'">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </template>
                <template x-if="type === 'error'">
                    <div class="w-8 h-8 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center shrink-0 border border-rose-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </template>
                <span x-text="message" class="text-slate-100 font-medium"></span>
            </div>
            <button @click="show = false" class="text-slate-400 hover:text-white p-1 transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</x-layouts::app.sidebar>
