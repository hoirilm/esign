<div class="w-full space-y-6">
    <!-- Header Title & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">Master Data Pasien</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola identitas dan rekam medis pasien laboratorium klinik.</p>
        </div>
        <flux:button variant="primary" icon="plus" wire:click="createPatient" class="!bg-teal-700 hover:!bg-teal-800 text-white font-semibold">
            Tambah Pasien Baru
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
    <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="w-full sm:w-80">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari Nama / No RM / NIK..." icon="magnifying-glass" class="w-full" />
        </div>
    </div>

    <!-- Patients Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 table-fixed">
                <thead class="bg-slate-50/80 text-[11px] uppercase font-bold tracking-wider text-slate-500 border-b border-slate-200/80">
                    <tr>
                        <th class="px-5 py-4 w-[15%]">No. RM</th>
                        <th class="px-5 py-4 w-[28%]">Nama Pasien</th>
                        <th class="px-5 py-4 w-[22%]">NIK / No. Identitas</th>
                        <th class="px-5 py-4 w-[18%]">Tgl Lahir</th>
                        <th class="px-5 py-4 w-[12%]">Jenis Kelamin</th>
                        <th class="px-5 py-4 w-[5%] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                            <td class="px-5 py-4 font-mono font-bold text-teal-700 text-xs truncate">{{ $patient->rm_number }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-900 truncate">{{ $patient->name }}</td>
                            <td class="px-5 py-4 font-mono text-xs text-slate-600 truncate">{{ $patient->identity_number ?? '-' }}</td>
                            <td class="px-5 py-4 text-xs text-slate-600 truncate">
                                {{ $patient->dob ? $patient->dob->format('d/m/Y') : '-' }}
                                @if($patient->dob)
                                    <span class="text-[11px] text-slate-400">({{ $patient->dob->age }} thn)</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $patient->gender === 'Laki-Laki' ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/20' : 'bg-pink-50 text-pink-700 ring-1 ring-pink-600/20' }}">
                                    {{ $patient->gender }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <flux:dropdown position="bottom" align="end">
                                    <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" class="!w-8 !h-8 !p-0 rounded-xl hover:bg-slate-100 text-slate-500 hover:text-slate-900" />
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
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Belum ada data pasien terdaftar. Silakan tambah pasien baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $patients->links() }}
        </div>
    </div>

    <!-- Modal Create / Edit Pasien -->
    <flux:modal wire:model="showModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="font-heading">{{ $editingPatientId ? 'Edit Data Pasien' : 'Tambah Pasien Baru' }}</flux:heading>
            <flux:subheading>Isi formulir identitas pasien klinik di bawah ini.</flux:subheading>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input label="No. Rekam Medis (RM)" wire:model="rm_number" placeholder="004978" />
                <flux:input label="No. Identitas (NIK)" wire:model="identity_number" placeholder="3528084808040002" />
            </div>

            <flux:input label="Nama Lengkap Pasien" wire:model="name" placeholder="ABELATUS SOLEHAH" />
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input type="date" label="Tanggal Lahir" wire:model="dob" />
                <flux:select label="Jenis Kelamin" wire:model="gender">
                    <option value="Perempuan">Perempuan</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                </flux:select>
            </div>

            <flux:input label="Nomor Telepon" wire:model="phone" placeholder="085259670050" />
            <flux:textarea label="Alamat Lengkap" wire:model="address" placeholder="DSN TALAGAH" />
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <flux:button variant="ghost" wire:click="$set('showModal', false)">Batal</flux:button>
            <flux:button variant="primary" wire:click="save" class="!bg-teal-700 hover:!bg-teal-800 text-white font-semibold">Simpan Pasien</flux:button>
        </div>
    </flux:modal>

    <!-- Modal Konfirmasi Hapus Pasien -->
    <flux:modal wire:model="showDeleteModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-600 font-heading">Hapus Data Pasien</flux:heading>
            <flux:subheading>Apakah Anda yakin ingin menghapus data pasien ini? Seluruh riwayat pemeriksaan terkait juga akan terhapus.</flux:subheading>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">Batal</flux:button>
            <flux:button variant="danger" class="!bg-rose-600 hover:!bg-rose-700 text-white font-semibold" wire:click="deletePatient">Ya, Hapus Pasien</flux:button>
        </div>
    </flux:modal>
</div>
