<div class="p-6 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Pemeriksaan & Hasil Lab</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Daftar registrasi pemeriksaan laboratorium patologi klinik.</p>
        </div>
        <flux:button variant="primary" icon="plus" href="{{ route('lab-requests.create') }}" wire:navigate>
            Pemeriksaan Baru
        </flux:button>
    </div>

    @if(session()->has('message'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="flex flex-col sm:flex-row items-center gap-4">
        <div class="w-full sm:w-72">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari No. Lab / Pasien / RM..." icon="magnifying-glass" />
        </div>
        <div class="w-full sm:w-48">
            <flux:select wire:model.live="statusFilter">
                <option value="">Semua Status</option>
                <option value="draft">Draft</option>
                <option value="verified">Verified (TTE)</option>
            </flux:select>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm">
        <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-300">
            <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-xs uppercase font-semibold text-zinc-500 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-700">
                <tr>
                    <th class="px-4 py-3">No. Lab</th>
                    <th class="px-4 py-3">Pasien</th>
                    <th class="px-4 py-3">Tgl Registrasi</th>
                    <th class="px-4 py-3">Dokter Pengirim</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($labRequests as $req)
                    <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40">
                        <td class="px-4 py-3 font-bold text-teal-600 dark:text-teal-400">{{ $req->lab_number }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $req->patient->name }}</div>
                            <div class="text-xs text-zinc-400">RM: {{ $req->patient->rm_number }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $req->request_date->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">{{ $req->sender_doctor ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($req->status === 'verified')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 border border-emerald-500/30 dark:text-emerald-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    VERIFIED (TTE)
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-600 border border-amber-500/30 dark:text-amber-400">
                                    DRAFT
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-1">
                            <flux:button size="sm" variant="ghost" icon="eye" href="{{ route('lab-requests.show', $req->id) }}" wire:navigate>
                                Detail
                            </flux:button>
                            @if($req->status === 'verified')
                                <flux:button size="sm" variant="subtle" icon="arrow-down-tray" href="{{ route('lab-requests.pdf', ['labRequest' => $req->id, 'download' => 1]) }}" target="_blank">
                                    PDF
                                </flux:button>
                            @endif
                            <flux:button size="sm" variant="ghost" icon="trash" class="text-rose-500 hover:text-rose-700" wire:click="confirmDelete({{ $req->id }})">
                                Hapus
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-zinc-400">
                            Belum ada pemeriksaan lab tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $labRequests->links() }}
    </div>

    <!-- Modal Konfirmasi Hapus Lab Request -->
    <flux:modal wire:model="showDeleteModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-600">Hapus Pemeriksaan Lab</flux:heading>
            <flux:subheading>Apakah Anda yakin ingin menghapus data pemeriksaan laboratorium ini? Seluruh item hasil uji dan status verifikasi TTE terkait akan terhapus.</flux:subheading>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">Batal</flux:button>
            <flux:button variant="danger" class="bg-rose-600 hover:bg-rose-700 text-white" wire:click="deleteLabRequest">Ya, Hapus Pemeriksaan</flux:button>
        </div>
    </flux:modal>
</div>
