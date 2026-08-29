<x-layouts::app :title="__('Dashboard')">
    <div class="w-full space-y-6">
        <!-- Top Header Hero -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-6 bg-gradient-to-r from-teal-700 via-teal-800 to-slate-900 dark:from-teal-900 dark:via-slate-900 dark:to-zinc-950 rounded-3xl text-white shadow-xl shadow-teal-900/15 dark:shadow-zinc-950/60 border border-teal-600/20 dark:border-zinc-800 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 space-y-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-teal-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Sistem E-Signature Medis Aktif
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight font-heading">
                    Selamat Datang, {{ auth()->user()->name }}
                </h1>
                <p class="text-xs sm:text-sm text-teal-100/80">
                    Role: <strong class="text-white">{{ ucfirst(auth()->user()->role) }}</strong> &bull; {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            
            <div class="relative z-10 flex flex-wrap items-center gap-3 shrink-0">
                <flux:button variant="primary" icon="plus" class="!bg-teal-500 hover:!bg-teal-400 !text-slate-950 font-bold border-none shadow-md" href="{{ route('lab-requests.create') }}" wire:navigate>
                    Pemeriksaan Baru
                </flux:button>
                <flux:button variant="subtle" icon="users" class="!bg-white/10 hover:!bg-white/20 !text-white !border-white/20" href="{{ route('patients.index') }}" wire:navigate>
                    Data Pasien
                </flux:button>
            </div>
        </div>

        @php
            $totalPatients = \App\Models\Patient::count();
            $totalRequests = \App\Models\LabRequest::count();
            $verifiedCount = \App\Models\LabRequest::where('status', 'verified')->count();
            $draftCount = \App\Models\LabRequest::where('status', 'draft')->count();
            $recentRequests = \App\Models\LabRequest::with('patient')->latest()->take(5)->get();
        @endphp

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Card 1: Total Pasien -->
            <div class="bg-white dark:bg-zinc-900 border border-slate-200/80 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm dark:shadow-zinc-950/40 hover:shadow-md hover:shadow-slate-200/60 dark:hover:shadow-zinc-950/60 transition-all duration-200 flex items-center justify-between group">
                <div class="space-y-1">
                    <div class="text-xs font-semibold text-slate-400 dark:text-zinc-500 uppercase tracking-wider">Total Pasien</div>
                    <div class="text-3xl font-extrabold text-slate-900 dark:text-zinc-100 font-heading tracking-tight">{{ number_format($totalPatients) }}</div>
                    <div class="text-[11px] text-slate-500 dark:text-zinc-400 font-medium">Terdaftar di database</div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-800/40 shadow-xs flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 2: Total Pengajuan Lab -->
            <div class="bg-white dark:bg-zinc-900 border border-slate-200/80 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm dark:shadow-zinc-950/40 hover:shadow-md hover:shadow-slate-200/60 dark:hover:shadow-zinc-950/60 transition-all duration-200 flex items-center justify-between group">
                <div class="space-y-1">
                    <div class="text-xs font-semibold text-slate-400 dark:text-zinc-500 uppercase tracking-wider">Total Pengajuan</div>
                    <div class="text-3xl font-extrabold text-slate-900 dark:text-zinc-100 font-heading tracking-tight">{{ number_format($totalRequests) }}</div>
                    <div class="text-[11px] text-teal-600 dark:text-teal-400 font-medium">Pemeriksaan laboratorium</div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-950/40 text-teal-600 dark:text-teal-400 border border-teal-100 dark:border-teal-800/40 shadow-xs flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 3: Terverifikasi (TTE) -->
            <div class="bg-white dark:bg-zinc-900 border border-slate-200/80 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm dark:shadow-zinc-950/40 hover:shadow-md hover:shadow-slate-200/60 dark:hover:shadow-zinc-950/60 transition-all duration-200 flex items-center justify-between group">
                <div class="space-y-1">
                    <div class="text-xs font-semibold text-slate-400 dark:text-zinc-500 uppercase tracking-wider">Terverifikasi (TTE)</div>
                    <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 font-heading tracking-tight">{{ number_format($verifiedCount) }}</div>
                    <div class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">Dokumen TTE sah</div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/40 shadow-xs flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 4: Status Draft -->
            <div class="bg-white dark:bg-zinc-900 border border-slate-200/80 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm dark:shadow-zinc-950/40 hover:shadow-md hover:shadow-slate-200/60 dark:hover:shadow-zinc-950/60 transition-all duration-200 flex items-center justify-between group">
                <div class="space-y-1">
                    <div class="text-xs font-semibold text-slate-400 dark:text-zinc-500 uppercase tracking-wider">Status Draft</div>
                    <div class="text-3xl font-extrabold text-amber-600 dark:text-amber-400 font-heading tracking-tight">{{ number_format($draftCount) }}</div>
                    <div class="text-[11px] text-amber-600 dark:text-amber-400 font-medium">Menunggu verifikasi</div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-800/40 shadow-xs flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Recent Lab Requests Table Card -->
        <div class="bg-white dark:bg-zinc-900 border border-slate-200/80 dark:border-zinc-800/80 rounded-3xl p-6 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-zinc-800 pb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-zinc-100 font-heading">Pemeriksaan Laboratorium Terbaru</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">5 transaksi pemeriksaan terakhir yang dicatat ke sistem.</p>
                </div>
                <flux:button variant="ghost" size="sm" icon-trailing="arrow-right" href="{{ route('lab-requests.index') }}" wire:navigate class="text-teal-700 dark:text-teal-400 hover:text-teal-800 dark:hover:text-teal-300 font-semibold">
                    Lihat Semua
                </flux:button>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-100 dark:border-zinc-800 shadow-2xs">
                <table class="w-full text-left text-sm text-slate-600 dark:text-zinc-300 table-fixed">
                    <thead class="bg-slate-50/80 dark:bg-zinc-800/80 text-[11px] uppercase font-bold tracking-wider text-slate-500 dark:text-zinc-400 border-b border-slate-100 dark:border-zinc-800">
                        <tr>
                            <th class="px-5 py-3.5 w-[25%]">No. Lab</th>
                            <th class="px-5 py-3.5 w-[32%]">Nama Pasien</th>
                            <th class="px-5 py-3.5 w-[22%]">Tgl Registrasi</th>
                            <th class="px-5 py-3.5 w-[16%]">Status TTE</th>
                            <th class="px-5 py-3.5 w-[5%] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-zinc-800">
                        @forelse($recentRequests as $req)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                                <td class="px-5 py-4 font-mono font-bold text-teal-700 dark:text-teal-400 text-xs truncate">{{ $req->lab_number }}</td>
                                <td class="px-5 py-4 font-medium text-slate-900 dark:text-zinc-100">
                                    <div class="truncate">{{ $req->patient->name }}</div>
                                    <div class="text-[11px] font-normal text-slate-400 dark:text-zinc-500 font-mono">RM: {{ $req->patient->rm_number }}</div>
                                </td>
                                <td class="px-5 py-4 text-xs text-slate-500 dark:text-zinc-400 truncate">{{ $req->request_date->format('d/m/Y H:i') }} WIB</td>
                                <td class="px-5 py-4">
                                    @if($req->status === 'verified')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 ring-1 ring-emerald-600/20 dark:ring-emerald-500/30 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            VERIFIED
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-400 ring-1 ring-amber-600/20 dark:ring-amber-500/30 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            DRAFT
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <flux:dropdown position="bottom" align="end">
                                        <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" class="!w-8 !h-8 !p-0 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 text-slate-500 dark:text-zinc-400 hover:text-slate-900 dark:hover:text-zinc-100" />
                                        <flux:menu>
                                            <flux:menu.item icon="eye" href="{{ route('lab-requests.show', $req->id) }}" wire:navigate>
                                                Detail / Hasil Uji
                                            </flux:menu.item>
                                            @if($req->status === 'verified')
                                                <flux:menu.item icon="arrow-down-tray" href="{{ route('lab-requests.pdf', ['labRequest' => $req->id, 'download' => 1]) }}" target="_blank">
                                                    Cetak / Unduh PDF
                                                </flux:menu.item>
                                            @endif
                                        </flux:menu>
                                    </flux:dropdown>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-slate-400 dark:text-zinc-500 text-sm">
                                    Belum ada data pemeriksaan lab.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
