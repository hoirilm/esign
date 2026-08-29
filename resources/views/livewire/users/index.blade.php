<div class="w-full space-y-6">
    <!-- Header Title & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">Manajemen Pengguna & Role (RBAC)</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola akun dan hak akses otoritas aplikasi (Dokter, Staff Lab, Administrator).</p>
        </div>
        <flux:button variant="primary" icon="user-plus" wire:click="createUser" class="!bg-teal-700 hover:!bg-teal-800 text-white font-semibold">
            Tambah Pengguna Baru
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

    @if(session()->has('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search Bar -->
    <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="w-full sm:w-80">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari Username / Nama / Role..." icon="magnifying-glass" class="w-full" />
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 table-fixed">
                <thead class="bg-slate-50/80 text-[11px] uppercase font-bold tracking-wider text-slate-500 border-b border-slate-200/80">
                    <tr>
                        <th class="px-5 py-4 w-[22%]">Username</th>
                        <th class="px-5 py-4 w-[32%]">Nama Pengguna</th>
                        <th class="px-5 py-4 w-[23%]">Role / Hak Akses</th>
                        <th class="px-5 py-4 w-[18%]">Tgl Terdaftar</th>
                        <th class="px-5 py-4 w-[5%] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $usr)
                        <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                            <td class="px-5 py-4 font-mono font-bold text-teal-700 text-xs truncate">{{ $usr->username ?? '-' }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-900 truncate">{{ $usr->name }}</td>
                            <td class="px-5 py-4">
                                @if($usr->role === 'doctor')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 ring-1 ring-emerald-600/30">
                                        👨‍⚕️ DOKTER (PENANGGUNG JAWAB TTE)
                                    </span>
                                @elseif($usr->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-800 ring-1 ring-purple-600/30">
                                        ⚡ ADMINISTRATOR
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-800 ring-1 ring-blue-600/30">
                                        📋 STAFF LAB
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-500 truncate">{{ $usr->created_at ? $usr->created_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="px-5 py-4 text-right">
                                <flux:dropdown position="bottom" align="end">
                                    <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" class="!w-8 !h-8 !p-0 rounded-xl hover:bg-slate-100 text-slate-500 hover:text-slate-900" />
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
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                Belum ada pengguna terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Create / Edit User Role -->
    <flux:modal wire:model="showModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="font-heading">{{ $editingUserId ? 'Edit Data & Role Pengguna' : 'Tambah Pengguna Baru' }}</flux:heading>
            <flux:subheading>Atur kredensial dan role hak akses pengguna aplikasi.</flux:subheading>
        </div>

        <div class="space-y-4">
            <flux:input label="Username (untuk Login)" wire:model="username" placeholder="admin" required />
            <flux:input label="Nama Lengkap" wire:model="name" placeholder="dr. Kristin Indriana" required />
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-slate-700">Pilih Role / Hak Akses</label>
                <select wire:model="role" class="w-full rounded-xl border-slate-300 bg-white text-slate-900 p-2.5 text-sm focus:ring-teal-500 focus:border-teal-500 shadow-xs">
                    <option value="doctor">Dokter (Penanggung Jawab - Otoritas TTE)</option>
                    <option value="staff">Staff Lab (Input Pasien & Hasil Uji)</option>
                    <option value="admin">Administrator (Akses Penuh)</option>
                </select>
            </div>

            <flux:input type="password" label="{{ $editingUserId ? 'Password Baru (Opsional)' : 'Password' }}" wire:model="password" placeholder="******" />
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <flux:button variant="ghost" wire:click="$set('showModal', false)">Batal</flux:button>
            <flux:button variant="primary" wire:click="save" class="!bg-teal-700 hover:!bg-teal-800 text-white font-semibold">Simpan Pengguna</flux:button>
        </div>
    </flux:modal>

    <!-- Modal Konfirmasi Hapus User -->
    <flux:modal wire:model="showDeleteModal" class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-600 font-heading">Hapus Pengguna</flux:heading>
            <flux:subheading>Apakah Anda yakin ingin menghapus akun pengguna ini?</flux:subheading>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">Batal</flux:button>
            <flux:button variant="danger" class="!bg-rose-600 hover:!bg-rose-700 text-white font-semibold" wire:click="deleteUser">Ya, Hapus Pengguna</flux:button>
        </div>
    </flux:modal>
</div>
