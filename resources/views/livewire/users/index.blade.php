<div class="w-full space-y-6">
    <!-- Header Title & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-zinc-100 font-heading">Manajemen Pengguna & Role (RBAC)</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 mt-0.5">Kelola akun dan hak akses otoritas aplikasi (Dokter, Staff Lab, Administrator).</p>
        </div>
        <flux:button variant="primary" icon="user-plus" wire:click="createUser" class="!bg-teal-700 hover:!bg-teal-800 text-white font-semibold shadow-sm">
            Tambah Pengguna Baru
        </flux:button>
    </div>

    <!-- Search Bar -->
    <div class="flex items-center gap-4 bg-white dark:bg-zinc-900 p-4 rounded-2xl border border-slate-200/80 dark:border-zinc-800 shadow-sm dark:shadow-zinc-950/40">
        <div class="w-full sm:w-80">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari Username / Nama / Role..." icon="magnifying-glass" class="w-full" />
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-slate-200/80 dark:border-zinc-800 shadow-md shadow-slate-200/50 dark:shadow-zinc-950/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-zinc-300 table-fixed">
                <thead class="bg-slate-50/80 dark:bg-zinc-800/80 text-[11px] uppercase font-bold tracking-wider text-slate-500 dark:text-zinc-400 border-b border-slate-200/80 dark:border-zinc-800">
                    <tr>
                        <th class="px-4 py-3.5 w-[14%] whitespace-nowrap">Username</th>
                        <th class="px-4 py-3.5 w-[28%] whitespace-nowrap">Nama Pengguna</th>
                        <th class="px-4 py-3.5 w-[35%] whitespace-nowrap">Role / Hak Akses</th>
                        <th class="px-4 py-3.5 w-[15%] whitespace-nowrap">Tgl Terdaftar</th>
                        <th class="px-4 py-3.5 w-[8%] text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-zinc-800">
                    @forelse($users as $usr)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                            <td class="px-4 py-3.5 font-mono font-bold text-teal-700 dark:text-teal-400 text-xs truncate">{{ $usr->username ?? '-' }}</td>
                            <td class="px-4 py-3.5 font-semibold text-slate-900 dark:text-zinc-100 truncate">{{ $usr->name }}</td>
                            <td class="px-4 py-3.5">
                                @if($usr->role === 'doctor')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300 ring-1 ring-emerald-600/30 dark:ring-emerald-500/40 shadow-2xs">
                                        👨‍⚕️ DOKTER (PENANGGUNG JAWAB TTE)
                                    </span>
                                @elseif($usr->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-50 dark:bg-purple-950/50 text-purple-800 dark:text-purple-300 ring-1 ring-purple-600/30 dark:ring-purple-500/40 shadow-2xs">
                                        ⚡ ADMINISTRATOR
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/50 text-blue-800 dark:text-blue-300 ring-1 ring-blue-600/30 dark:ring-blue-500/40 shadow-2xs">
                                        📋 STAFF LAB
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-xs text-slate-500 dark:text-zinc-400 truncate">{{ $usr->created_at ? $usr->created_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="px-4 py-3.5 text-right">
                                <flux:dropdown position="bottom" align="end">
                                    <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" class="!w-8 !h-8 !p-0 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 text-slate-500 dark:text-zinc-400 hover:text-slate-900 dark:hover:text-zinc-100" />
                                    <flux:menu>
                                        <flux:menu.item icon="pencil-square" wire:click="editUser({{ $usr->id }})">
                                            Edit Role & Data
                                        </flux:menu.item>
                                        @if($usr->id !== auth()->id())
                                            <flux:menu.separator />
                                            <flux:menu.item icon="trash" variant="danger" wire:click="confirmDelete({{ $usr->id }})">
                                                Hapus Pengguna
                                            </flux:menu.item>
                                        @endif
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400 dark:text-zinc-500">
                                Belum ada pengguna terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-5 py-4 border-t border-slate-100 dark:border-zinc-800">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Create / Edit User Role -->
    <flux:modal wire:model="showModal" class="space-y-6">
        <div class="border-b border-slate-100 dark:border-zinc-800 pb-4">
            <flux:heading size="lg" class="font-heading">{{ $editingUserId ? 'Edit Data Pengguna' : 'Tambah Pengguna Baru' }}</flux:heading>
            <flux:subheading>{{ $editingUserId ? 'Perbarui kredensial dan role hak akses pengguna di bawah ini.' : 'Atur akun baru dan hak akses pengguna aplikasi di bawah ini.' }}</flux:subheading>
        </div>

        @if(! $editingUserId)
            <div class="p-3.5 rounded-2xl bg-teal-50/80 dark:bg-teal-950/40 border border-teal-200/60 dark:border-teal-800/40 text-teal-800 dark:text-teal-300 text-xs flex items-center gap-2.5 shadow-2xs">
                <svg class="w-4 h-4 text-teal-600 dark:text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Akun pengguna akan diberikan role hak akses (Dokter, Staff Lab, atau Admin) sesuai wewenangnya.</span>
            </div>
        @else
            <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-zinc-800/60 border border-slate-200/80 dark:border-zinc-700/60 text-slate-700 dark:text-zinc-300 text-xs flex items-center gap-2.5 shadow-2xs">
                <svg class="w-4 h-4 text-teal-600 dark:text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Mengubah kredensial & role hak akses untuk akun: <strong class="font-mono text-teal-700 dark:text-teal-400">{{ $username }}</strong>.</span>
            </div>
        @endif

        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input label="Username (untuk Login)" wire:model="username" placeholder="Contoh: dokter_hendra" required />
                <flux:input type="password" label="{{ $editingUserId ? 'Password Baru (Opsional)' : 'Password' }}" wire:model="password" placeholder="••••••••" />
            </div>

            <flux:input label="Nama Lengkap & Gelar" wire:model="name" placeholder="Contoh: dr. Kristin Indriana, Sp.PK" required />
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300">Pilih Role / Hak Akses</label>
                <select wire:model="role" class="w-full rounded-xl border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-slate-900 dark:text-zinc-100 p-2.5 text-sm focus:ring-teal-500 focus:border-teal-500 shadow-xs">
                    <option value="doctor">Dokter (Penanggung Jawab - Otoritas TTE)</option>
                    <option value="staff">Staff Lab (Input Pasien & Hasil Uji)</option>
                    <option value="admin">Administrator (Akses Penuh)</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$set('showModal', false)">Batal</flux:button>
            <flux:button variant="primary" wire:click="save" class="!bg-teal-700 hover:!bg-teal-800 text-white font-semibold shadow-sm">
                {{ $editingUserId ? 'Perbarui Data Pengguna' : 'Simpan Pengguna Baru' }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Modal Konfirmasi Hapus User -->
    <flux:modal wire:model="showDeleteModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-600 dark:text-rose-400 font-heading">Hapus Pengguna</flux:heading>
            <flux:subheading>Apakah Anda yakin ingin menghapus akun pengguna ini?</flux:subheading>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">Batal</flux:button>
            <flux:button variant="danger" class="!bg-rose-600 hover:!bg-rose-700 text-white font-semibold" wire:click="deleteUser">Ya, Hapus Pengguna</flux:button>
        </div>
    </flux:modal>
</div>
