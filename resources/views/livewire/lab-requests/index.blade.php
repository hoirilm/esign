<div class="w-full space-y-6">
    <!-- Header Title & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-zinc-100 font-heading">Pemeriksaan & Hasil Laboratorium</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 mt-0.5">Daftar pengajuan pemeriksaan, pengisian hasil uji, serta verifikasi TTE.</p>
        </div>
        <flux:button variant="primary" icon="plus" href="{{ route('lab-requests.create') }}" wire:navigate class="!bg-teal-700 hover:!bg-teal-800 text-white font-semibold shadow-sm">
            Pemeriksaan Baru
        </flux:button>
    </div>

    <!-- Search & Filter Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-zinc-900 p-4 rounded-2xl border border-slate-200/80 dark:border-zinc-800 shadow-sm dark:shadow-zinc-950/40">
        <div class="w-full sm:w-80">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari No. Lab / Pasien / Dokter..." icon="magnifying-glass" class="w-full" />
        </div>

        <div class="flex items-center gap-2">
            <flux:button size="sm" variant="{{ $statusFilter === '' ? 'primary' : 'subtle' }}" wire:click="$set('statusFilter', '')" class="{{ $statusFilter === '' ? '!bg-teal-700 text-white' : '' }}">
                Semua
            </flux:button>
            <flux:button size="sm" variant="{{ $statusFilter === 'verified' ? 'primary' : 'subtle' }}" wire:click="$set('statusFilter', 'verified')" class="{{ $statusFilter === 'verified' ? '!bg-emerald-700 text-white' : '' }}">
                Verified (TTE)
            </flux:button>
            <flux:button size="sm" variant="{{ $statusFilter === 'draft' ? 'primary' : 'subtle' }}" wire:click="$set('statusFilter', 'draft')" class="{{ $statusFilter === 'draft' ? '!bg-amber-600 text-white' : '' }}">
                Draft
            </flux:button>
        </div>
    </div>

    <!-- Lab Requests Table Card -->
    <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-zinc-300 table-fixed">
                <thead class="bg-slate-50/80 dark:bg-zinc-800/80 text-[11px] uppercase font-bold tracking-wider text-slate-500 dark:text-zinc-400 border-b border-slate-200/80 dark:border-zinc-800">
                    <tr>
                        <th class="px-4 py-3.5 w-[24%] whitespace-nowrap">No. Lab</th>
                        <th class="px-4 py-3.5 w-[24%] whitespace-nowrap">Pasien</th>
                        <th class="px-4 py-3.5 w-[16%] whitespace-nowrap">Tgl Registrasi</th>
                        <th class="px-4 py-3.5 w-[22%] whitespace-nowrap">Dokter Pengirim</th>
                        <th class="px-4 py-3.5 w-[10%] whitespace-nowrap">Status TTE</th>
                        <th class="px-2 py-3.5 w-[4%] text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-zinc-800">
                    @forelse($labRequests as $req)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                            <td class="px-4 py-3.5 font-mono font-bold text-teal-700 dark:text-teal-400 text-xs truncate">{{ $req->lab_number }}</td>
                            <td class="px-4 py-3.5 font-semibold text-slate-900 dark:text-zinc-100">
                                <div class="truncate">{{ $req->patient->name }}</div>
                                <div class="text-[11px] font-normal text-slate-400 dark:text-zinc-500 font-mono">RM: {{ $req->patient->rm_number }}</div>
                            </td>
                            <td class="px-4 py-3.5 text-xs text-slate-600 dark:text-zinc-400 truncate">{{ $req->request_date ? $req->request_date->format('d/m/Y H:i') : '-' }} WIB</td>
                            <td class="px-4 py-3.5 text-xs text-slate-600 dark:text-zinc-400 truncate">{{ $req->sender_doctor ?? '-' }}</td>
                            <td class="px-4 py-3.5">
                                @if($req->status === 'verified')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 ring-1 ring-emerald-600/20 dark:ring-emerald-500/30 shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        VERIFIED (TTE)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-400 ring-1 ring-amber-600/20 dark:ring-amber-500/30 shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        DRAFT
                                    </span>
                                @endif
                            </td>
                            <td class="px-2 py-3.5 text-right">
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
                                        <flux:menu.separator />
                                        <flux:menu.item icon="trash" variant="danger" wire:click="confirmDelete({{ $req->id }})">
                                            Hapus
                                        </flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400 dark:text-zinc-500">
                                <svg class="w-12 h-12 text-slate-300 dark:text-zinc-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Belum ada data pemeriksaan lab. Silakan buat registrasi pemeriksaan baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-5 py-4 border-t border-slate-100 dark:border-zinc-800">
            {{ $labRequests->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Lab Request -->
    <flux:modal wire:model="showDeleteModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-600 dark:text-rose-400 font-heading">Hapus Pemeriksaan Lab</flux:heading>
            <flux:subheading>Apakah Anda yakin ingin menghapus transaksi pemeriksaan ini beserta seluruh hasil ujinya?</flux:subheading>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">Batal</flux:button>
            <flux:button variant="danger" class="!bg-rose-600 hover:!bg-rose-700 text-white font-semibold" wire:click="deleteLabRequest">Ya, Hapus Pemeriksaan</flux:button>
        </div>
    </flux:modal>
</div>
