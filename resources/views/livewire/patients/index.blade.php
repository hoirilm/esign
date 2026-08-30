<div class="w-full space-y-6">
    <!-- Header Title & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-xl shadow-slate-200/50 dark:shadow-zinc-950/50">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-zinc-100 font-heading">Master Data Pasien</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 mt-1">Kelola identitas dan rekam medis pasien laboratorium klinik.</p>
        </div>
        <flux:button variant="primary" icon="plus" wire:click="createPatient" class="!bg-gradient-to-r !from-teal-600 !to-teal-500 hover:!from-teal-500 hover:!to-teal-400 !text-white font-bold !border-none shadow-lg shadow-teal-700/20 !rounded-xl active:scale-[0.99] transition-all cursor-pointer shrink-0">
            Tambah Pasien Baru
        </flux:button>
    </div>

    <!-- Search Bar -->
    <div class="flex items-center gap-4 bg-white dark:bg-zinc-900 p-4 rounded-2xl border border-slate-200/80 dark:border-zinc-800 shadow-sm dark:shadow-zinc-950/40">
        <div class="w-full sm:w-80">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari Nama / No RM / NIK..." icon="magnifying-glass" class="w-full" />
        </div>
    </div>

    <!-- Patients Table Card -->
    <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-zinc-300 table-fixed">
                <thead class="bg-slate-50/80 dark:bg-zinc-800/80 text-[11px] uppercase font-bold tracking-wider text-slate-500 dark:text-zinc-400 border-b border-slate-200/80 dark:border-zinc-800">
                    <tr>
                        <th class="px-4 py-3.5 w-[13%] whitespace-nowrap">No. RM</th>
                        <th class="px-4 py-3.5 w-[27%] whitespace-nowrap">Nama Pasien</th>
                        <th class="px-4 py-3.5 w-[21%] whitespace-nowrap">NIK / No. Identitas</th>
                        <th class="px-4 py-3.5 w-[18%] whitespace-nowrap">Tgl Lahir</th>
                        <th class="px-4 py-3.5 w-[13%] whitespace-nowrap">Jenis Kelamin</th>
                        <th class="px-4 py-3.5 w-[8%] text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-zinc-800">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                            <td class="px-4 py-3.5 font-mono font-bold text-teal-700 dark:text-teal-400 text-xs truncate">{{ $patient->rm_number }}</td>
                            <td class="px-4 py-3.5 font-semibold text-slate-900 dark:text-zinc-100 truncate">{{ $patient->name }}</td>
                            <td class="px-4 py-3.5 font-mono text-xs text-slate-600 dark:text-zinc-400 truncate">{{ $patient->identity_number ?? '-' }}</td>
                            <td class="px-4 py-3.5 text-xs text-slate-600 dark:text-zinc-400 truncate">
                                {{ $patient->dob ? $patient->dob->format('d/m/Y') : '-' }}
                                @if($patient->dob)
                                    <span class="text-[11px] text-slate-400 dark:text-zinc-500">({{ $patient->dob->age }} thn)</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $patient->gender === 'Laki-Laki' ? 'bg-blue-50 dark:bg-blue-950/50 text-blue-700 dark:text-blue-400 ring-1 ring-blue-600/20 dark:ring-blue-500/30 shadow-2xs' : 'bg-pink-50 dark:bg-pink-950/50 text-pink-700 dark:text-pink-400 ring-1 ring-pink-600/20 dark:ring-pink-500/30 shadow-2xs' }}">
                                    {{ $patient->gender }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <flux:dropdown position="bottom" align="end">
                                    <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" class="!w-8 !h-8 !p-0 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 text-slate-500 dark:text-zinc-400 hover:text-slate-900 dark:hover:text-zinc-100" />
                                    <flux:menu>
                                        <flux:menu.item icon="pencil-square" wire:click="editPatient({{ $patient->id }})">
                                            Edit Data Pasien
                                        </flux:menu.item>
                                        <flux:menu.separator />
                                        <flux:menu.item icon="trash" variant="danger" wire:click="confirmDelete({{ $patient->id }})">
                                            Hapus Pasien
                                        </flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400 dark:text-zinc-500">
                                <svg class="w-12 h-12 text-slate-300 dark:text-zinc-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Belum ada data pasien terdaftar. Silakan tambah pasien baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-5 py-4 border-t border-slate-100 dark:border-zinc-800">
            {{ $patients->links() }}
        </div>
    </div>

    <!-- Modal Create / Edit Pasien -->
    <flux:modal wire:model="showModal" class="space-y-6">
        <div class="border-b border-slate-100 dark:border-zinc-800 pb-4">
            <flux:heading size="lg" class="font-heading">{{ $editingPatientId ? 'Edit Data Pasien' : 'Tambah Pasien Baru' }}</flux:heading>
            <flux:subheading>{{ $editingPatientId ? 'Perbarui informasi rekam medis pasien di bawah ini.' : 'Isi formulir rekam medis pasien klinik baru di bawah ini.' }}</flux:subheading>
        </div>

        @if(! $editingPatientId)
            <div class="p-3.5 rounded-2xl bg-teal-50/80 dark:bg-teal-950/40 border border-teal-200/60 dark:border-teal-800/40 text-teal-800 dark:text-teal-300 text-xs flex items-center gap-2.5 shadow-2xs">
                <svg class="w-4 h-4 text-teal-600 dark:text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>No. Rekam Medis (RM) akan dibuat otomatis oleh sistem saat disimpan (contoh: <strong>{{ \App\Livewire\Patients\Index::generateNextRmNumber() }}</strong>).</span>
            </div>
        @else
            <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-zinc-800/60 border border-slate-200/80 dark:border-zinc-700/60 text-slate-700 dark:text-zinc-300 text-xs flex items-center gap-2.5 shadow-2xs">
                <svg class="w-4 h-4 text-teal-600 dark:text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Mengubah rekam medis pasien terdaftar dengan No. RM: <strong class="font-mono text-teal-700 dark:text-teal-400">{{ $rm_number }}</strong>.</span>
            </div>
        @endif

        <div class="space-y-4">
            <flux:input label="Nama Lengkap Pasien" wire:model="name" placeholder="Contoh: Budi Santoso" required />

            <flux:input label="No. Identitas (NIK)" wire:model="identity_number" placeholder="Contoh: 3578012304950001" />
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input type="date" label="Tanggal Lahir" wire:model="dob" />
                <flux:select label="Jenis Kelamin" wire:model="gender">
                    <option value="Perempuan">Perempuan</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                </flux:select>
            </div>

            <flux:input label="Nomor Telepon / WhatsApp" wire:model="phone" placeholder="Contoh: 081234567890" />
            <flux:textarea label="Alamat Lengkap Pasien" wire:model="address" placeholder="Contoh: Jl. Merdeka No. 12, Kel. Menteng, Jakarta Pusat" rows="3" />
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$set('showModal', false)">Batal</flux:button>
            <flux:button variant="primary" wire:click="save" class="!bg-teal-700 hover:!bg-teal-800 text-white font-semibold shadow-sm">
                {{ $editingPatientId ? 'Perbarui Data Pasien' : 'Simpan Pasien Baru' }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Modal Konfirmasi Hapus Pasien -->
    <flux:modal wire:model="showDeleteModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-600 dark:text-rose-400 font-heading">Hapus Data Pasien</flux:heading>
            <flux:subheading>Apakah Anda yakin ingin menghapus data pasien ini? Seluruh riwayat pemeriksaan terkait juga akan terhapus.</flux:subheading>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">Batal</flux:button>
            <flux:button variant="danger" class="!bg-rose-600 hover:!bg-rose-700 text-white font-semibold shadow-sm" wire:click="deletePatient">Ya, Hapus Pasien</flux:button>
        </div>
    </flux:modal>
</div>
