<x-layouts::app :title="__('Dashboard')">
    <div class="p-6 space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Dashboard Patologi Klinik & TTE
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong> (Role: {{ ucfirst(auth()->user()->role) }}).
            </p>
        </div>

        @php
            $totalPatients = \App\Models\Patient::count();
            $totalRequests = \App\Models\LabRequest::count();
            $verifiedCount = \App\Models\LabRequest::where('status', 'verified')->count();
            $recentRequests = \App\Models\LabRequest::with('patient')->latest()->take(5)->get();
        @endphp

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Total Pasien</div>
                    <div class="text-3xl font-extrabold text-zinc-900 dark:text-zinc-100 mt-1">{{ $totalPatients }}</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Total Pengajuan Lab</div>
                    <div class="text-3xl font-extrabold text-zinc-900 dark:text-zinc-100 mt-1">{{ $totalRequests }}</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-500/10 text-teal-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Terverifikasi (TTE)</div>
                    <div class="text-3xl font-extrabold text-emerald-500 mt-1">{{ $verifiedCount }}</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Recent Lab Requests -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-5 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-zinc-400">Pemeriksaan Terbaru</h3>
                <flux:button variant="ghost" size="sm" icon-trailing="arrow-right" href="{{ route('lab-requests.index') }}" wire:navigate>
                    Lihat Semua
                </flux:button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-800">
                <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-300">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/80 text-xs uppercase font-semibold text-zinc-500 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-800">
                        <tr>
                            <th class="px-4 py-3">No. Lab</th>
                            <th class="px-4 py-3">Pasien</th>
                            <th class="px-4 py-3">Tgl Registrasi</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($recentRequests as $req)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40">
                                <td class="px-4 py-3 font-bold text-teal-600 dark:text-teal-400">{{ $req->lab_number }}</td>
                                <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">{{ $req->patient->name }}</td>
                                <td class="px-4 py-3">{{ $req->request_date->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    @if($req->status === 'verified')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                            VERIFIED (TTE)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                            DRAFT
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <flux:button size="sm" variant="ghost" href="{{ route('lab-requests.show', $req->id) }}" wire:navigate>
                                        Buka Detail
                                    </flux:button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-zinc-400">Belum ada pemeriksaan lab.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
