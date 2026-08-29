<div class="w-full space-y-6">
    <!-- Header Navigation & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-4">
            <flux:button variant="ghost" icon="arrow-left" href="{{ route('lab-requests.index') }}" wire:navigate />
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">
                        Pemeriksaan {{ $labRequest->lab_number }}
                    </h1>
                    @if($labRequest->status === 'verified')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/30">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            VERIFIED (TTE)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 ring-1 ring-amber-600/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            DRAFT
                        </span>
                    @endif
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Pasien: <strong class="text-slate-800">{{ $labRequest->patient->name }}</strong> (RM: {{ $labRequest->patient->rm_number }} | NIK: {{ $labRequest->patient->identity_number ?? '-' }})
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if($labRequest->status === 'verified')
                <flux:button variant="primary" icon="arrow-down-tray" href="{{ route('lab-requests.pdf', ['labRequest' => $labRequest->id, 'download' => 1]) }}" target="_blank" class="!bg-teal-700 hover:!bg-teal-800 text-white font-semibold">
                    Cetak / Unduh PDF
                </flux:button>
                <flux:button variant="subtle" icon="eye" href="{{ route('lab-requests.pdf', $labRequest->id) }}" target="_blank">
                    Preview PDF
                </flux:button>
            @endif
        </div>
    </div>

    <!-- Workflow Progress Stepper UX -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
            <!-- Step 1 -->
            <div class="flex flex-col items-center space-y-1">
                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-xs">
                    ✓
                </div>
                <div class="text-xs font-bold text-slate-900">1. Registrasi Sampel</div>
                <div class="text-[11px] text-slate-400">Tercatat di sistem</div>
            </div>

            <!-- Step 2 -->
            <div class="flex flex-col items-center space-y-1">
                <div class="w-8 h-8 rounded-full {{ count($labRequest->results) > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} font-bold flex items-center justify-center text-xs">
                    {{ count($labRequest->results) > 0 ? '✓' : '2' }}
                </div>
                <div class="text-xs font-bold text-slate-900">2. Hasil Uji Lab</div>
                <div class="text-[11px] text-slate-400">{{ count($labRequest->results) }} item terisi</div>
            </div>

            <!-- Step 3 -->
            <div class="flex flex-col items-center space-y-1">
                <div class="w-8 h-8 rounded-full {{ $labRequest->status === 'verified' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }} font-bold flex items-center justify-center text-xs">
                    {{ $labRequest->status === 'verified' ? '✓' : '3' }}
                </div>
                <div class="text-xs font-bold text-slate-900">3. Verifikasi TTE Dokter</div>
                <div class="text-[11px] text-slate-400">{{ $labRequest->status === 'verified' ? 'Sah & Valid' : 'Menunggu Otoritas' }}</div>
            </div>

            <!-- Step 4 -->
            <div class="flex flex-col items-center space-y-1">
                <div class="w-8 h-8 rounded-full {{ $labRequest->status === 'verified' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }} font-bold flex items-center justify-center text-xs">
                    {{ $labRequest->status === 'verified' ? '✓' : '4' }}
                </div>
                <div class="text-xs font-bold text-slate-900">4. QR Code & Cetak PDF</div>
                <div class="text-[11px] text-slate-400">{{ $labRequest->status === 'verified' ? 'Siap Diterbitkan' : 'Terkunci' }}</div>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="font-medium">{{ session('message') }}</div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Grid Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Columns: Request Meta & Item Results -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Metadata Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-slate-900 font-heading">Rincian Dokumen Pemeriksaan</h3>
                    <span class="text-xs font-mono text-slate-400">Req #: {{ $labRequest->request_number }}</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                    <div>
                        <span class="text-slate-400 block text-xs">Dokter Pengirim:</span>
                        <strong class="text-slate-800">{{ $labRequest->sender_doctor }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-xs">Penanggung Jawab:</span>
                        <strong class="text-emerald-700 font-semibold">{{ $labRequest->pathologist_doctor }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-xs">Tanggal Registrasi:</span>
                        <span class="text-slate-700 font-medium">{{ $labRequest->request_date->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-xs">Petugas Input / Cetak:</span>
                        <span class="text-slate-700 font-medium">{{ $labRequest->printed_by }}</span>
                    </div>
                </div>
            </div>

            <!-- Add Result Item Form (If Status Draft) -->
            @if($labRequest->status === 'draft')
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
                    <h3 class="text-base font-bold text-slate-900 font-heading">Tambah Item Hasil Uji Lab</h3>

                    <form wire:submit.prevent="addResult" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                        <div class="sm:col-span-3">
                            <flux:input label="Kategori" wire:model="category" placeholder="IMUNOLOGI/SEROLOGI" required />
                        </div>
                        <div class="sm:col-span-3">
                            <flux:input label="Nama Parameter Uji" wire:model="test_name" placeholder="Salmonella Typhi O" required />
                        </div>
                        <div class="sm:col-span-2">
                            <flux:input label="Hasil" wire:model="result_value" placeholder="POSITIF 1/80" required />
                        </div>
                        <div class="sm:col-span-2">
                            <flux:input label="Nilai Rujukan" wire:model="reference_value" placeholder="Negatif" />
                        </div>
                        <div class="sm:col-span-2">
                            <flux:button variant="primary" type="submit" icon="plus" class="w-full !bg-teal-700 hover:!bg-teal-800 text-white font-semibold">
                                Tambah
                            </flux:button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Results Table Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900 font-heading">Tabel Hasil Pemeriksaan Laboratorium</h3>
                    <p class="text-xs text-slate-500">Daftar item parameter medis yang akan dicetak pada laporan hasil lab.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 table-fixed">
                        <thead class="bg-slate-50/80 text-[11px] uppercase font-bold tracking-wider text-slate-500 border-b border-slate-200/80">
                            <tr>
                                <th class="px-5 py-3.5 w-[24%]">Kategori</th>
                                <th class="px-5 py-3.5 w-[32%]">Pemeriksaan</th>
                                <th class="px-5 py-3.5 w-[20%]">Hasil</th>
                                <th class="px-5 py-3.5 w-[12%]">Nilai Rujukan</th>
                                <th class="px-5 py-3.5 w-[7%]">Satuan</th>
                                @if($labRequest->status === 'draft')
                                    <th class="px-5 py-3.5 w-[5%] text-right">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($labRequest->results as $res)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-5 py-3.5 text-xs text-slate-400 uppercase font-semibold truncate">{{ $res->category }}</td>
                                    <td class="px-5 py-3.5 font-medium text-slate-900 truncate">{{ $res->test_name }}</td>
                                    <td class="px-5 py-3.5 font-bold truncate {{ Str::contains(strtoupper($res->result_value), ['POSITIF', 'HIGH']) ? 'text-rose-600' : 'text-emerald-700' }}">
                                        {{ $res->result_value }}
                                    </td>
                                    <td class="px-5 py-3.5 text-xs text-slate-500 truncate">{{ $res->reference_value ?? '-' }}</td>
                                    <td class="px-5 py-3.5 text-xs text-slate-500 truncate">{{ $res->unit ?? '-' }}</td>
                                    @if($labRequest->status === 'draft')
                                        <td class="px-5 py-3.5 text-right">
                                            <flux:dropdown position="bottom" align="end">
                                                <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" class="!w-8 !h-8 !p-0 rounded-xl hover:bg-slate-100 text-slate-500 hover:text-slate-900" />
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
                                    <td colspan="6" class="px-5 py-8 text-center text-slate-400 text-sm">
                                        Belum ada parameter uji ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right 1 Column: Status TTE & QR Verification Card -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-5 sticky top-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-slate-900 font-heading">Status Tanda Tangan Elektronik</h3>
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>

                @if($labRequest->verification)
                    <div class="p-5 rounded-2xl bg-emerald-50/80 border border-emerald-200 space-y-4 text-center">
                        <div class="inline-flex items-center justify-center p-3 bg-white rounded-2xl shadow-sm border border-emerald-100 mx-auto">
                            @if($qrDataUri)
                                <img src="{{ $qrDataUri }}" class="w-40 h-40" alt="QR Code Verification">
                            @endif
                        </div>
                        
                        <div>
                            <div class="text-[11px] text-emerald-700 font-bold uppercase tracking-wider">TTE Valid & Terverifikasi</div>
                            <div class="text-base font-bold text-slate-900 mt-1 font-heading">
                                {{ $labRequest->verification->verifier->name }}
                            </div>
                            <div class="text-xs text-slate-500 mt-0.5">
                                {{ $labRequest->verification->verified_at->format('d M Y, H:i:s') }} WIB
                            </div>
                        </div>

                        <div class="pt-3 border-t border-emerald-200/60">
                            <a href="{{ route('verify.show', $labRequest->verification->qr_token) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-teal-700 hover:text-teal-800 underline">
                                <span>Buka Halaman Scan Publik</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 border border-amber-200 flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-800 font-heading">Status Masih Draft</div>
                            <p class="text-xs text-slate-500 mt-1">
                                Dokumen ini memerlukan verifikasi dari Dokter Penanggung Jawab untuk menerbitkan Tanda Tangan Elektronik & QR Code sah.
                            </p>
                        </div>

                        <flux:button variant="primary" icon="check-badge" class="w-full !bg-emerald-700 hover:!bg-emerald-800 text-white font-bold py-2.5" wire:click="verifyLabRequest">
                            Verifikasi & Terbitkan TTE
                        </flux:button>
                    </div>
                @endif

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs text-slate-500 space-y-2">
                    <div class="font-bold text-slate-700 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Landasan Hukum TTE
                    </div>
                    <p class="text-[11px] leading-relaxed">
                        Sesuai Pasal 11 UU No. 11/2008 tentang ITE, Tanda Tangan Elektronik pada hasil pemeriksaan medis ini diakui secara legal dan sah secara hukum.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
