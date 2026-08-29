<div class="w-full space-y-6">
    <!-- Header Title & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-zinc-100 font-heading">Detail & Hasil Lab #{{ $labRequest->lab_number }}</h1>
                @if($labRequest->status === 'verified')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 ring-1 ring-emerald-600/30 dark:ring-emerald-500/40 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        VERIFIED (TTE SAH)
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-400 ring-1 ring-amber-600/30 dark:ring-amber-500/40 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        STATUS DRAFT
                    </span>
                @endif
            </div>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 mt-1">Lengkapi item hasil pengujian medis dan proses penandatanganan elektronik (TTE).</p>
        </div>

        <div class="flex items-center gap-2">
            <flux:button variant="subtle" icon="arrow-left" href="{{ route('lab-requests.index') }}" wire:navigate>
                Kembali
            </flux:button>
            @if($labRequest->status === 'verified')
                <flux:button variant="primary" icon="arrow-down-tray" href="{{ route('lab-requests.pdf', ['labRequest' => $labRequest->id, 'download' => 1]) }}" target="_blank" class="!bg-emerald-700 hover:!bg-emerald-800 text-white font-semibold shadow-sm">
                    Cetak / Unduh PDF
                </flux:button>
            @endif
        </div>
    </div>

    <!-- Workflow Progress Tracker -->
    <div class="bg-white dark:bg-zinc-900 rounded-3xl p-5 border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50">
        <div class="text-xs font-semibold text-slate-400 dark:text-zinc-500 uppercase tracking-wider mb-4">Progres Alur Pemeriksaan Lab</div>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 relative">
            <!-- Step 1 -->
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-teal-50/80 dark:bg-teal-950/40 border border-teal-200/60 dark:border-teal-800/40 shadow-xs">
                <div class="w-8 h-8 rounded-xl bg-teal-700 text-white flex items-center justify-center text-xs font-bold shrink-0 shadow-xs">1</div>
                <div>
                    <div class="text-xs font-bold text-teal-900 dark:text-teal-200">Registrasi Lab</div>
                    <div class="text-[11px] text-teal-700 dark:text-teal-400 font-mono">{{ $labRequest->request_date->format('d/m H:i') }}</div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="flex items-center gap-3 p-3 rounded-2xl {{ $labRequest->results->count() > 0 ? 'bg-teal-50/80 dark:bg-teal-950/40 border border-teal-200/60 dark:border-teal-800/40 shadow-xs' : 'bg-slate-50 dark:bg-zinc-800/40 border border-slate-200/60 dark:border-zinc-700/50 opacity-60' }}">
                <div class="w-8 h-8 rounded-xl {{ $labRequest->results->count() > 0 ? 'bg-teal-700 text-white' : 'bg-slate-300 dark:bg-zinc-700 text-slate-600 dark:text-zinc-300' }} flex items-center justify-center text-xs font-bold shrink-0 shadow-xs">2</div>
                <div>
                    <div class="text-xs font-bold text-slate-900 dark:text-zinc-100">Input Hasil Uji</div>
                    <div class="text-[11px] text-slate-500 dark:text-zinc-400">{{ $labRequest->results->count() }} item dimasukkan</div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="flex items-center gap-3 p-3 rounded-2xl {{ $labRequest->status === 'verified' ? 'bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-200/60 dark:border-emerald-800/40 shadow-xs' : 'bg-slate-50 dark:bg-zinc-800/40 border border-slate-200/60 dark:border-zinc-700/50 opacity-60' }}">
                <div class="w-8 h-8 rounded-xl {{ $labRequest->status === 'verified' ? 'bg-emerald-600 text-white' : 'bg-slate-300 dark:bg-zinc-700 text-slate-600 dark:text-zinc-300' }} flex items-center justify-center text-xs font-bold shrink-0 shadow-xs">3</div>
                <div>
                    <div class="text-xs font-bold text-slate-900 dark:text-zinc-100">TTE Dokter</div>
                    <div class="text-[11px] text-slate-500 dark:text-zinc-400">{{ $labRequest->status === 'verified' ? 'Ditandatangani' : 'Menunggu TTE' }}</div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="flex items-center gap-3 p-3 rounded-2xl {{ $labRequest->status === 'verified' ? 'bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-200/60 dark:border-emerald-800/40 shadow-xs' : 'bg-slate-50 dark:bg-zinc-800/40 border border-slate-200/60 dark:border-zinc-700/50 opacity-60' }}">
                <div class="w-8 h-8 rounded-xl {{ $labRequest->status === 'verified' ? 'bg-emerald-600 text-white' : 'bg-slate-300 dark:bg-zinc-700 text-slate-600 dark:text-zinc-300' }} flex items-center justify-center text-xs font-bold shrink-0 shadow-xs">4</div>
                <div>
                    <div class="text-xs font-bold text-slate-900 dark:text-zinc-100">Siap Cetak PDF</div>
                    <div class="text-[11px] text-slate-500 dark:text-zinc-400">{{ $labRequest->status === 'verified' ? 'Dokumen Sah' : 'Belum Verifikasi' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid: Info Pasien & Item Hasil Uji -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Info Pasien & Transaksi -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-slate-200/80 dark:border-zinc-800 p-6 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 space-y-4">
                <h3 class="text-base font-bold text-slate-900 dark:text-zinc-100 font-heading border-b border-slate-100 dark:border-zinc-800 pb-3">Informasi Pasien</h3>
                
                <div class="space-y-3 text-sm">
                    <div>
                        <div class="text-xs text-slate-400 dark:text-zinc-500 uppercase font-semibold">Nama Lengkap Pasien</div>
                        <div class="font-bold text-slate-900 dark:text-zinc-100 text-base">{{ $labRequest->patient->name }}</div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <div class="text-xs text-slate-400 dark:text-zinc-500 uppercase font-semibold">No. RM</div>
                            <div class="font-mono font-bold text-teal-700 dark:text-teal-400 text-sm">{{ $labRequest->patient->rm_number }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400 dark:text-zinc-500 uppercase font-semibold">NIK</div>
                            <div class="font-mono text-slate-700 dark:text-zinc-300 text-xs">{{ $labRequest->patient->identity_number ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <div class="text-xs text-slate-400 dark:text-zinc-500 uppercase font-semibold">Tgl Lahir / Umur</div>
                            <div class="text-slate-700 dark:text-zinc-300 text-xs">
                                {{ $labRequest->patient->dob ? $labRequest->patient->dob->format('d/m/Y') : '-' }}
                                @if($labRequest->patient->dob)
                                    <span class="text-slate-400 dark:text-zinc-500">({{ $labRequest->patient->dob->age }} thn)</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400 dark:text-zinc-500 uppercase font-semibold">Jenis Kelamin</div>
                            <div class="text-slate-700 dark:text-zinc-300 text-xs font-semibold">{{ $labRequest->patient->gender }}</div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 dark:border-zinc-800 pt-3">
                        <div class="text-xs text-slate-400 dark:text-zinc-500 uppercase font-semibold">Dokter Pengirim</div>
                        <div class="text-slate-800 dark:text-zinc-200 font-medium text-xs">{{ $labRequest->sender_doctor ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- TTE Verification Card / Action -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-slate-200/80 dark:border-zinc-800 p-6 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 space-y-4">
                <h3 class="text-base font-bold text-slate-900 dark:text-zinc-100 font-heading border-b border-slate-100 dark:border-zinc-800 pb-3">Status E-Signature (TTE)</h3>

                @if($labRequest->status === 'verified')
                    <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/50 shadow-xs space-y-3">
                        <div class="flex items-center gap-3 text-emerald-800 dark:text-emerald-300 font-bold text-sm">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            TTE Verifikasi Berhasil
                        </div>
                        <div class="text-xs text-emerald-900 dark:text-emerald-200 space-y-1.5">
                            <div><strong>Penandatangan:</strong> {{ $labRequest->verification->verifier->name ?? 'Dokter Penanggung Jawab' }}</div>
                            <div><strong>Waktu TTE:</strong> {{ $labRequest->verification?->verified_at ? $labRequest->verification->verified_at->format('d/m/Y H:i:s') : '-' }} WIB</div>
                            <div class="font-mono text-[11px] break-all text-emerald-700 dark:text-emerald-400 pt-1 border-t border-emerald-200/60 dark:border-emerald-800/40 mt-1">
                                <strong>HASH SHA-256:</strong> {{ strtoupper(substr(hash('sha256', ($labRequest->verification?->qr_token ?? '') . $labRequest->id), 0, 32)) }}...
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Dokumen masih berstatus <strong>DRAFT</strong>. Dokter Penanggung Jawab harus melakukan verifikasi TTE agar dokumen sah dan dapat dicetak.</p>

                    @if(auth()->user()->isDoctor())
                        <flux:button variant="primary" icon="shield-check" wire:click="openVerifyModal" class="w-full !bg-emerald-700 hover:!bg-emerald-800 text-white font-bold py-2.5 shadow-sm">
                            Tanda Tangani & Verifikasi (TTE)
                        </flux:button>
                    @else
                        <div class="p-3 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/50 text-amber-800 dark:text-amber-300 text-xs shadow-2xs">
                            Hanya akun ber-role <strong>Dokter</strong> yang dapat melakukan verifikasi TTE.
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Detail Results Table & Add Form -->
        <div class="lg:col-span-2 space-y-6">
            @if($labRequest->status === 'draft')
                <!-- Form Input Parameter Hasil Uji -->
                <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-slate-200/80 dark:border-zinc-800 p-6 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 space-y-4">
                    <h3 class="text-base font-bold text-slate-900 dark:text-zinc-100 font-heading border-b border-slate-100 dark:border-zinc-800 pb-3">Input Parameter Hasil Uji</h3>

                    <form wire:submit="addResult" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-zinc-400 mb-1">Kategori Pemeriksaan</label>
                            <flux:input wire:model="category" placeholder="HEMATOLOGI" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-zinc-400 mb-1">Nama Pemeriksaan / Test Name</label>
                            <flux:input wire:model="test_name" placeholder="Hemoglobin (Hb)" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-zinc-400 mb-1">Nilai Hasil Uji</label>
                            <flux:input wire:model="result_value" placeholder="14.2" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-zinc-400 mb-1">Nilai Rujukan / Normal</label>
                            <flux:input wire:model="reference_value" placeholder="13.0 - 17.0" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-zinc-400 mb-1">Satuan</label>
                            <flux:input wire:model="unit" placeholder="g/dL" />
                        </div>
                        <div class="sm:col-span-2">
                            <flux:button variant="primary" type="submit" icon="plus" class="w-full !bg-teal-700 hover:!bg-teal-800 text-white font-semibold shadow-sm">
                                Tambah Item Hasil Uji
                            </flux:button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Results Table Card -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 overflow-hidden">
                <div class="p-5 border-b border-slate-100 dark:border-zinc-800">
                    <h3 class="text-base font-bold text-slate-900 dark:text-zinc-100 font-heading">Tabel Hasil Pemeriksaan Laboratorium</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Daftar item parameter medis yang akan dicetak pada laporan hasil lab.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-zinc-300 table-fixed">
                        <thead class="bg-slate-50/80 dark:bg-zinc-800/80 text-[11px] uppercase font-bold tracking-wider text-slate-500 dark:text-zinc-400 border-b border-slate-200/80 dark:border-zinc-800">
                            <tr>
                                <th class="px-3 py-3.5 {{ $labRequest->status === 'draft' ? 'w-[18%]' : 'w-[20%]' }} whitespace-nowrap">Kategori</th>
                                <th class="px-3 py-3.5 {{ $labRequest->status === 'draft' ? 'w-[26%]' : 'w-[30%]' }} whitespace-nowrap">Pemeriksaan</th>
                                <th class="px-3 py-3.5 {{ $labRequest->status === 'draft' ? 'w-[15%]' : 'w-[18%]' }} whitespace-nowrap">Hasil</th>
                                <th class="px-3 py-3.5 {{ $labRequest->status === 'draft' ? 'w-[22%]' : 'w-[22%]' }} whitespace-nowrap">Nilai Rujukan</th>
                                <th class="px-3 py-3.5 {{ $labRequest->status === 'draft' ? 'w-[11%]' : 'w-[10%]' }} whitespace-nowrap">Satuan</th>
                                @if($labRequest->status === 'draft')
                                    <th class="px-3 py-3.5 w-[8%] text-right whitespace-nowrap">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-zinc-800">
                            @forelse($labRequest->results as $res)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-3 py-3.5 text-xs text-slate-400 dark:text-zinc-500 uppercase font-semibold truncate">{{ $res->category }}</td>
                                    <td class="px-3 py-3.5 font-medium text-slate-900 dark:text-zinc-100 truncate">{{ $res->test_name }}</td>
                                    <td class="px-3 py-3.5 font-bold truncate {{ Str::contains(strtoupper($res->result_value), ['POSITIF', 'HIGH']) ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-700 dark:text-emerald-400' }}">
                                        {{ $res->result_value }}
                                    </td>
                                    <td class="px-3 py-3.5 text-xs text-slate-500 dark:text-zinc-400 truncate">{{ $res->reference_value ?? '-' }}</td>
                                    <td class="px-3 py-3.5 text-xs text-slate-500 dark:text-zinc-400 truncate">{{ $res->unit ?? '-' }}</td>
                                    @if($labRequest->status === 'draft')
                                        <td class="px-3 py-3.5 text-right">
                                            <flux:dropdown position="bottom" align="end">
                                                <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" class="!w-8 !h-8 !p-0 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 text-slate-500 dark:text-zinc-400 hover:text-slate-900 dark:hover:text-zinc-100" />
                                                <flux:menu>
                                                    <flux:menu.item icon="trash" variant="danger" wire:click="removeResult({{ $res->id }})">
                                                        Hapus Item
                                                    </flux:menu.item>
                                                </flux:menu>
                                            </flux:dropdown>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center text-slate-400 dark:text-zinc-500 text-sm">
                                        Belum ada parameter uji ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi TTE -->
    <flux:modal wire:model="showVerifyModal" class="space-y-6">
        <div class="border-b border-slate-100 dark:border-zinc-800 pb-4">
            <flux:heading size="lg" class="text-emerald-700 dark:text-emerald-400 font-heading">Verifikasi & Tanda Tangan Digital (TTE)</flux:heading>
            <flux:subheading>Konfirmasi penerbitan TTE sah untuk laporan hasil laboratorium medis ini.</flux:subheading>
        </div>

        <div class="p-3.5 rounded-2xl bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-200/60 dark:border-emerald-800/40 text-emerald-900 dark:text-emerald-200 text-xs flex items-center gap-2.5 shadow-2xs">
            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Penandatangan TTE: <strong>{{ auth()->user()->name }}</strong> (Username: <span class="font-mono text-emerald-700 dark:text-emerald-400">{{ auth()->user()->username }}</span>)</span>
        </div>

        <div class="space-y-4">
            <flux:input type="password" label="Masukkan Password Akun Anda" wire:model="verifyPassword" placeholder="Masukkan password Anda untuk konfirmasi TTE..." required />
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$set('showVerifyModal', false)">Batal</flux:button>
            <flux:button variant="primary" wire:click="verifyTte" class="!bg-emerald-700 hover:!bg-emerald-800 text-white font-semibold shadow-sm">
                Tanda Tangani TTE Sekarang
            </flux:button>
        </div>
    </flux:modal>
</div>
