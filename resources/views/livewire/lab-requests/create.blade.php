<div class="w-full space-y-6">
    <div class="flex items-center gap-4">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('lab-requests.index') }}" wire:navigate />
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-zinc-100 font-heading">Registrasi Pemeriksaan Baru</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400">Pilih pasien dan lengkapi rincian permintaan pemeriksaan lab.</p>
        </div>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Section 1: Pasien -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 space-y-4">
            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-zinc-800 pb-3">
                <div class="w-8 h-8 rounded-full bg-teal-100 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300 font-bold flex items-center justify-center text-xs shadow-xs">1</div>
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-zinc-100 font-heading">Identitas Pasien</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Pilih data pasien terdaftar atau daftarkan pasien baru terlebih dahulu.</p>
                </div>
            </div>

            <flux:select label="Pilih Pasien Terdaftar" wire:model="patient_id" required class="w-full">
                <option value="">-- Pilih Pasien --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }} (RM: {{ $patient->rm_number }} | NIK: {{ $patient->identity_number ?? '-' }})</option>
                @endforeach
            </flux:select>
        </div>

        <!-- Section 2: Informasi Pemeriksaan & Nomor Lab -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 space-y-4">
            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-zinc-800 pb-3">
                <div class="w-8 h-8 rounded-full bg-teal-100 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300 font-bold flex items-center justify-center text-xs shadow-xs">2</div>
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-zinc-100 font-heading">Informasi & Nomor Registrasi</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Nomor laboratorium dan nomor pengajuan dibuat otomatis oleh sistem.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input label="Nomor Laboratorium" wire:model="lab_number" required />
                <flux:input label="Nomor Pengajuan (Permintaan)" wire:model="request_number" required />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input type="datetime-local" label="Tanggal / Waktu Registrasi" wire:model="request_date" required />
                <flux:input type="datetime-local" label="Tanggal / Waktu Ambil Sampel" wire:model="specimen_date" required />
            </div>
        </div>

        <!-- Section 3: Dokter & Petugas -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 space-y-4">
            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-zinc-800 pb-3">
                <div class="w-8 h-8 rounded-full bg-teal-100 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300 font-bold flex items-center justify-center text-xs shadow-xs">3</div>
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-zinc-100 font-heading">Dokter & Petugas Lab</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Informasi dokter pengirim dan dokter penanggung jawab patologi klinik.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input label="Dokter Pengirim" wire:model="sender_doctor" placeholder="APS . (Atas Permintaan Sendiri)" required />
                <flux:input label="Penanggung Jawab" wire:model="pathologist_doctor" placeholder="dr. Kristin Indriana" required />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input label="Petugas Cetak / Input" wire:model="printed_by" placeholder="Taufiqurrohman" required />
                <flux:input label="Catatan Tambahan" wire:model="notes" placeholder="Contoh: Puasa 8 jam" />
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-3 pt-2">
            <flux:button variant="ghost" href="{{ route('lab-requests.index') }}" wire:navigate>Batal</flux:button>
            <flux:button variant="primary" type="submit" class="!bg-teal-700 hover:!bg-teal-800 text-white font-bold px-6 shadow-sm">
                Lanjutkan & Input Hasil Uji
            </flux:button>
        </div>
    </form>
</div>
