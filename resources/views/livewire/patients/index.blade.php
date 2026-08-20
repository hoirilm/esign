<div class="p-6 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Manajemen Data Pasien</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Kelola master data pasien laboratorium klinik.</p>
        </div>
        <flux:button variant="primary" icon="plus" wire:click="createPatient">
            Tambah Pasien Baru
        </flux:button>
    </div>

    @if(session()->has('message'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="flex items-center gap-4">
        <div class="w-full sm:w-72">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari Nama / No RM / NIK..." icon="magnifying-glass" />
        </div>
    </div>

    <!-- Patients Table -->
    <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm">
        <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-300">
            <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-xs uppercase font-semibold text-zinc-500 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-700">
                <tr>
                    <th class="px-4 py-3">No. RM</th>
                    <th class="px-4 py-3">Nama Pasien</th>
                    <th class="px-4 py-3">No. Identitas (NIK)</th>
                    <th class="px-4 py-3">Tgl Lahir</th>
                    <th class="px-4 py-3">L/P</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($patients as $patient)
                    <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40">
                        <td class="px-4 py-3 font-semibold text-teal-600 dark:text-teal-400">{{ $patient->rm_number }}</td>
                        <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">{{ $patient->name }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $patient->identity_number ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $patient->dob ? $patient->dob->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ $patient->gender === 'Laki-Laki' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-pink-100 text-pink-700 dark:bg-pink-900/40 dark:text-pink-300' }}">
                                {{ $patient->gender }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-1">
                            <flux:button size="sm" variant="ghost" icon="pencil-square" wire:click="editPatient({{ $patient->id }})">
                                Edit
                            </flux:button>
                            <flux:button size="sm" variant="ghost" icon="trash" class="text-rose-500 hover:text-rose-700" wire:click="confirmDelete({{ $patient->id }})">
                                Hapus
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-zinc-400">
                            Belum ada data pasien terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $patients->links() }}
    </div>

    <!-- Modal Create / Edit Pasien -->
    <flux:modal wire:model="showModal" class="space-y-6">
        <div>
            <flux:heading size="lg">{{ $editingPatientId ? 'Edit Data Pasien' : 'Tambah Pasien Baru' }}</flux:heading>
            <flux:subheading>Isi formulir identitas pasien klinik di bawah ini.</flux:subheading>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <flux:input label="No. Rekam Medis (RM)" wire:model="rm_number" placeholder="004978" />
                <flux:input label="No. Identitas (NIK)" wire:model="identity_number" placeholder="3528084808040002" />
            </div>

            <flux:input label="Nama Lengkap Pasien" wire:model="name" placeholder="ABELATUS SOLEHAH" />
            
            <div class="grid grid-cols-2 gap-4">
                <flux:input type="date" label="Tanggal Lahir" wire:model="dob" />
                <flux:select label="Jenis Kelamin" wire:model="gender">
                    <option value="Perempuan">Perempuan</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                </flux:select>
            </div>

            <flux:input label="Nomor Telepon" wire:model="phone" placeholder="085259670050" />
            <flux:textarea label="Alamat Lengkap" wire:model="address" placeholder="DSN TALAGAH" />
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <flux:button variant="ghost" wire:click="$set('showModal', false)">Batal</flux:button>
            <flux:button variant="primary" wire:click="save">Simpan Pasien</flux:button>
        </div>
    </flux:modal>

    <!-- Modal Konfirmasi Hapus Pasien -->
    <flux:modal wire:model="showDeleteModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-600">Hapus Data Pasien</flux:heading>
            <flux:subheading>Apakah Anda yakin ingin menghapus data pasien ini? Seluruh riwayat pemeriksaan terkait juga akan terhapus.</flux:subheading>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">Batal</flux:button>
            <flux:button variant="danger" class="bg-rose-600 hover:bg-rose-700 text-white" wire:click="deletePatient">Ya, Hapus Pasien</flux:button>
        </div>
    </flux:modal>
</div>
