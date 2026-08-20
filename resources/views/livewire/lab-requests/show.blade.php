<div class="p-6 space-y-6">
    <!-- Header Navigation & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <flux:button variant="ghost" icon="arrow-left" href="{{ route('lab-requests.index') }}" wire:navigate />
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                        Pemeriksaan {{ $labRequest->lab_number }}
                    </h1>
                    @if($labRequest->status === 'verified')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-600 border border-emerald-500/30 dark:text-emerald-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            VERIFIED (TTE)
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/15 text-amber-600 border border-amber-500/30 dark:text-amber-400">
                            DRAFT
                        </span>
                    @endif
                </div>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Pasien: <strong class="text-zinc-800 dark:text-zinc-200">{{ $labRequest->patient->name }}</strong> (RM: {{ $labRequest->patient->rm_number }} | NIK: {{ $labRequest->patient->identity_number ?? '-' }})
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if($labRequest->status === 'verified')
                <flux:button variant="primary" icon="arrow-down-tray" href="{{ route('lab-requests.pdf', ['labRequest' => $labRequest->id, 'download' => 1]) }}" target="_blank">
                    Cetak / Unduh PDF
                </flux:button>
                <flux:button variant="subtle" icon="eye" href="{{ route('lab-requests.pdf', $labRequest->id) }}" target="_blank">
                    Preview PDF
                </flux:button>
            @endif
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session()->has('message'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>{{ session('message') }}</div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Details & Results -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Patient & Request Details Card -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-zinc-400">Informasi Sampel & Petugas</h3>
                    @if($labRequest->status !== 'verified')
                        <button wire:click="updateMetadata" class="text-xs font-semibold text-teal-600 hover:text-teal-500 dark:text-teal-400">
                            Simpan Perubahan Metadata
                        </button>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <flux:input label="No. Permintaan (Req. Number)" wire:model="request_number" :disabled="$labRequest->status === 'verified'" />
                    <flux:input label="Dokter Pengirim (Sender)" wire:model="sender_doctor" :disabled="$labRequest->status === 'verified'" />
                    <flux:input label="Penanggung Jawab (Pathologist)" wire:model="pathologist_doctor" :disabled="$labRequest->status === 'verified'" />
                    <flux:input label="Dicetak oleh (Printed By)" wire:model="printed_by" :disabled="$labRequest->status === 'verified'" />
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs pt-2 border-t border-zinc-100 dark:border-zinc-800">
                    <div>
                        <div class="text-zinc-400">Tgl Registrasi</div>
                        <div class="font-medium text-zinc-800 dark:text-zinc-200">{{ $labRequest->request_date ? $labRequest->request_date->format('d/m/Y H:i') : '-' }} WIB</div>
                    </div>
                    <div>
                        <div class="text-zinc-400">Tgl Spesimen</div>
                        <div class="font-medium text-zinc-800 dark:text-zinc-200">{{ $labRequest->specimen_date ? $labRequest->specimen_date->format('d/m/Y H:i') : '-' }} WIB</div>
                    </div>
                    <div>
                        <div class="text-zinc-400">Tgl Selesai / Cetak</div>
                        <div class="font-medium text-zinc-800 dark:text-zinc-200">{{ $labRequest->finished_date ? $labRequest->finished_date->format('d/m/Y H:i') : '-' }} WIB</div>
                    </div>
                </div>

                <flux:input label="Catatan Laboratorium" wire:model="notes" :disabled="$labRequest->status === 'verified'" />
            </div>

            <!-- Lab Results Items Table -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-zinc-400">Parameter & Hasil Uji Laboratorium</h3>
                    <span class="text-xs text-zinc-400">{{ $labRequest->results->count() }} Item Terdaftar</span>
                </div>

                <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-300">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/80 text-xs uppercase font-semibold text-zinc-500 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-800">
                            <tr>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Nama Pemeriksaan</th>
                                <th class="px-4 py-3">Hasil</th>
                                <th class="px-4 py-3">Nilai Rujukan</th>
                                <th class="px-4 py-3">Satuan</th>
                                @if($labRequest->status !== 'verified')
                                    <th class="px-4 py-3 text-right">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @forelse($labRequest->results as $res)
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40">
                                    <td class="px-4 py-3 text-xs text-teal-600 font-semibold dark:text-teal-400">{{ $res->category }}</td>
                                    <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">{{ $res->test_name }}</td>
                                    <td class="px-4 py-3 font-bold {{ Str::contains(strtoupper($res->result_value), ['POSITIF', 'HIGH']) ? 'text-rose-500' : 'text-emerald-500' }}">
                                        {{ $res->result_value }}
                                    </td>
                                    <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">{{ $res->reference_value ?? 'Negatif' }}</td>
                                    <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">{{ $res->unit ?? '-' }}</td>
                                    @if($labRequest->status !== 'verified')
                                        <td class="px-4 py-3 text-right">
                                            <button wire:click="deleteResultItem({{ $res->id }})" class="text-rose-500 hover:text-rose-700 text-xs font-semibold">Hapus</button>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-zinc-400">
                                        Belum ada data parameter hasil uji. Silakan tambahkan melalui form di bawah.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Add New Item Form (Only when Draft) -->
                @if($labRequest->status !== 'verified')
                    <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 space-y-4">
                        <h4 class="text-xs font-semibold uppercase text-zinc-400">Tambah Parameter Hasil Uji Baru</h4>
                        @if(session()->has('item_message'))
                            <div class="text-xs text-emerald-500 font-medium">{{ session('item_message') }}</div>
                        @endif
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                            <flux:input label="Kategori" wire:model="category" placeholder="IMUNOLOGI/SEROLOGI" />
                            <flux:input label="Nama Pemeriksaan" wire:model="test_name" placeholder="- Salmonella Typhi O" />
                            <flux:input label="Hasil" wire:model="result_value" placeholder="POSITIF 1/80" />
                            <flux:input label="Nilai Rujukan" wire:model="reference_value" placeholder="Negatif" />
                            <flux:input label="Satuan" wire:model="unit" placeholder="" />
                        </div>
                        <div class="flex justify-end">
                            <flux:button size="sm" variant="primary" icon="plus" wire:click="addResultItem">
                                Tambah Item
                            </flux:button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right 1 Col: E-Signature Card & QR Status -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-5 shadow-sm space-y-4 text-center">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-zinc-400">Status Tanda Tangan Elektronik</h3>

                @if($labRequest->verification)
                    <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 space-y-3">
                        <div class="inline-flex items-center justify-center p-2 bg-white rounded-xl shadow">
                            @if($qrDataUri)
                                <img src="{{ $qrDataUri }}" class="w-36 h-36" alt="QR Code Verification">
                            @endif
                        </div>
                        
                        <div>
                            <div class="text-xs text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider">TTE Valid & Terverifikasi</div>
                            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mt-1">
                                {{ $labRequest->verification->verifier->name }}
                            </div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ $labRequest->verification->verified_at->format('d M Y, H:i:s') }} WIB
                            </div>
                        </div>

                        <div class="pt-2 border-t border-emerald-500/20">
                            <a href="{{ route('verify.show', $labRequest->verification->qr_token) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-teal-600 hover:text-teal-500 dark:text-teal-400 underline">
                                <span>Buka Halaman Scan Publik</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="p-6 rounded-2xl bg-zinc-100 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 text-center space-y-3">
                        <div class="w-12 h-12 rounded-full bg-amber-500/20 text-amber-500 flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Belum Diverifikasi</div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            Dokumen masih dalam status Draft. Verifikasi oleh Penanggung Jawab diperlukan untuk menerbitkan Tanda Tangan Elektronik & QR Code.
                        </p>
                        <flux:button variant="primary" icon="check-badge" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white" wire:click="verifyLabRequest">
                            Verifikasi & Terbitkan TTE
                        </flux:button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
