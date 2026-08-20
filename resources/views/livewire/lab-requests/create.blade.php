<div class="max-w-3xl mx-auto p-6 space-y-6">
    <div class="flex items-center gap-4">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('lab-requests.index') }}" wire:navigate />
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Registrasi Pemeriksaan Lab Baru</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Pilih pasien dan isi data lengkap pengajuan laboratorium.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-6 shadow-sm space-y-5">
        <div class="space-y-1">
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Pilih Pasien Terdaftar</label>
            <select wire:model="patient_id" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 p-2.5 text-sm focus:ring-teal-500 focus:border-teal-500">
                <option value="">-- Pilih Pasien --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }} (RM: {{ $patient->rm_number }} | NIK: {{ $patient->identity_number ?? '-' }})</option>
                @endforeach
            </select>
            @error('patient_id') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <flux:input label="Nomor Laboratorium (No. Lab)" wire:model="lab_number" />
            <flux:input label="Nomor Permintaan (No. Permintaan)" wire:model="request_number" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <flux:input type="datetime-local" label="Tgl/Jam Registrasi & Permintaan" wire:model="request_date" />
            <flux:input type="datetime-local" label="Tgl/Jam Spesimen" wire:model="specimen_date" />
            <flux:input type="datetime-local" label="Tgl/Jam Selesai / Cetak" wire:model="finished_date" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <flux:input label="Dokter Pengirim / Perujuk" wire:model="sender_doctor" placeholder="APS . (Atas Permintaan Sendiri)" />
            <flux:input label="Penanggung Jawab / Clinical Pathologist" wire:model="pathologist_doctor" placeholder="dr. Kristin Indriana" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <flux:input label="Dicetak oleh (Petugas)" wire:model="printed_by" placeholder="Taufiqurrohman" />
            <flux:input label="Catatan Laboratorium" wire:model="notes" placeholder="-" />
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button variant="ghost" href="{{ route('lab-requests.index') }}" wire:navigate>Batal</flux:button>
            <flux:button variant="primary" wire:click="save">Lanjutkan Ke Input Hasil</flux:button>
        </div>
    </div>
</div>
