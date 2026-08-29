<?php

use Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Pengaturan Tampilan')] class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Pengaturan Tampilan') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Tampilan')" :subheading="__('Atur preferensi mode tampilan untuk akun Anda')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Terang') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Gelap') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('Sistem (Auto)') }}</flux:radio>
        </flux:radio.group>
    </x-pages::settings.layout>
</section>
