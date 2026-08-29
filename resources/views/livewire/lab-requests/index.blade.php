<div class="w-full space-y-6">
    <!-- Header Title & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">Pemeriksaan & Hasil Laboratorium</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Daftar pengajuan pemeriksaan, pengisian hasil uji, serta verifikasi TTE.</p>
        </div>
        <flux:button variant="primary" icon="plus" href="{{ route('lab-requests.create') }}" wire:navigate class="!bg-teal-700 hover:!bg-teal-800 text-white font-semibold">
            Pemeriksaan Baru
        </flux:button>
    </div>

    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="font-medium">{{ session('message') }}</div>
        </div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
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
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 table-fixed">
                <thead class="bg-slate-50/80 text-[11px] uppercase font-bold tracking-wider text-slate-500 border-b border-slate-200/80">
                    <tr>
                        <th class="px-5 py-4 w-[22%]">No. Lab</th>
                        <th class="px-5 py-4 w-[24%]">Pasien</th>
                        <th class="px-5 py-4 w-[18%]">Tgl Registrasi</th>
                        <th class="px-5 py-4 w-[18%]">Dokter Pengirim</th>
                        <th class="px-5 py-4 w-[13%]">Status TTE</th>
                        <th class="px-5 py-4 w-[5%] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($labRequests as $req)
                        <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                            <td class="px-5 py-4 font-mono font-bold text-teal-700 text-xs truncate">{{ $req->lab_number }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-900">
                                <div class="truncate">{{ $req->patient->name }}</div>
                                <div class="text-[11px] font-normal text-slate-400 font-mono">RM: {{ $req->patient->rm_number }}</div>
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-600 truncate">{{ $req->request_date ? $req->request_date->format('d/m/Y H:i') : '-' }} WIB</td>
                            <td class="px-5 py-4 text-xs text-slate-600 truncate">{{ $req->sender_doctor ?? '-' }}</td>
                            <td class="px-5 py-4">
                                @if($req->status === 'verified')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        VERIFIED (TTE)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 ring-1 ring-amber-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        DRAFT
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <flux:dropdown position="bottom" align="end">
                                    <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" class="!w-8 !h-8 !p-0 rounded-xl hover:bg-slate-100 text-slate-500 hover:text-slate-900" />
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
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Belum ada data pemeriksaan lab. Silakan buat registrasi pemeriksaan baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $labRequests->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Lab Request -->
    <flux:modal wire:model="showDeleteModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-600 font-heading">Hapus Pemeriksaan Lab</flux:heading>
            <flux:subheading>Apakah Anda yakin ingin menghapus transaksi pemeriksaan ini beserta seluruh hasil ujinya?</flux:subheading>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">Batal</flux:button>
            <flux:button variant="danger" class="!bg-rose-600 hover:!bg-rose-700 text-white font-semibold" wire:click="deleteLabRequest">Ya, Hapus Pemeriksaan</flux:button>
        </div>
    </flux:modal>
</div>
