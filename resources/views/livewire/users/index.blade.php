<div class="p-6 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Manajemen Pengguna & Role (RBAC)</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Atur hak akses dan role pengguna (Dokter, Staff Lab, atau Admin).</p>
        </div>
        <flux:button variant="primary" icon="user-plus" wire:click="createUser">
            Tambah Pengguna Baru
        </flux:button>
    </div>

    @if(session()->has('message'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="flex items-center gap-4">
        <div class="w-full sm:w-72">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari Nama / Email / Role..." icon="magnifying-glass" />
        </div>
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm">
        <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-300">
            <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-xs uppercase font-semibold text-zinc-500 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-700">
                <tr>
                    <th class="px-4 py-3">Nama Pengguna</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role / Hak Akses</th>
                    <th class="px-4 py-3">Tgl Terdaftar</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($users as $usr)
                    <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40">
                        <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100 flex items-center gap-3">
                            <flux:avatar :name="$usr->name" :initials="$usr->initials()" size="sm" />
                            <span>{{ $usr->name }}</span>
                        </td>
                        <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">{{ $usr->email }}</td>
                        <td class="px-4 py-3">
                            @if($usr->role === 'doctor')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-600 border border-emerald-500/30 dark:text-emerald-400">
                                    👨‍⚕️ DOKTER (PENANGGUNG JAWAB TTE)
                                </span>
                            @elseif($usr->role === 'admin')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-500/15 text-purple-600 border border-purple-500/30 dark:text-purple-400">
                                    ⚡ ADMINISTRATOR
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-500/15 text-blue-600 border border-blue-500/30 dark:text-blue-400">
                                    📋 STAFF LAB
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-zinc-400">{{ $usr->created_at ? $usr->created_at->format('d/m/Y H:i') : '-' }}</td>
                        <td class="px-4 py-3 text-right space-x-1">
                            <flux:button size="sm" variant="ghost" icon="pencil-square" wire:click="editUser({{ $usr->id }})">
                                Edit Role
                            </flux:button>
                            @if($usr->id !== auth()->id())
                                <flux:button size="sm" variant="ghost" icon="trash" class="text-rose-500 hover:text-rose-700" wire:click="confirmDelete({{ $usr->id }})">
                                    Hapus
                                </flux:button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-zinc-400">
                            Belum ada pengguna terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Modal Create / Edit User Role -->
    <flux:modal wire:model="showModal" class="space-y-6">
        <div>
            <flux:heading size="lg">{{ $editingUserId ? 'Edit Role Pengguna' : 'Tambah Pengguna Baru' }}</flux:heading>
            <flux:subheading>Tentukan role hak akses pengguna aplikasi di bawah ini.</flux:subheading>
        </div>

        <div class="space-y-4">
            <flux:input label="Nama Lengkap" wire:model="name" placeholder="dr. Kristin Indriana" />
            <flux:input type="email" label="Alamat Email" wire:model="email" placeholder="dokter@lab.com" />
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Pilih Role / Hak Akses</label>
                <select wire:model="role" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 p-2.5 text-sm focus:ring-teal-500 focus:border-teal-500">
                    <option value="doctor">Dokter (Penanggung Jawab - Otoritas TTE)</option>
                    <option value="staff">Staff Lab (Input Pasien & Hasil Uji)</option>
                    <option value="admin">Administrator (Akses Penuh)</option>
                </select>
            </div>

            <flux:input type="password" label="{{ $editingUserId ? 'Password Baru (Opsional)' : 'Password' }}" wire:model="password" placeholder="******" />
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$set('showModal', false)">Batal</flux:button>
            <flux:button variant="primary" wire:click="save">Simpan Pengguna</flux:button>
        </div>
    </flux:modal>

    <!-- Modal Konfirmasi Hapus User -->
    <flux:modal wire:model="showDeleteModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-600">Hapus Pengguna</flux:heading>
            <flux:subheading>Apakah Anda yakin ingin menghapus akun pengguna ini?</flux:subheading>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">Batal</flux:button>
            <flux:button variant="danger" class="bg-rose-600 hover:bg-rose-700 text-white" wire:click="deleteUser">Ya, Hapus Pengguna</flux:button>
        </div>
    </flux:modal>
</div>
