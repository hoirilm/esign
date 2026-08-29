<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $showModal = false;
    public bool $showDeleteModal = false;

    public ?int $editingUserId = null;
    public ?int $deletingUserId = null;

    public string $username = '';
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'staff';

    public function mount(): void
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Akses Ditolak: Hanya Administrator yang berhak mengakses Manajemen User & Role.');
        }
    }

    protected function rules(): array
    {
        return [
            'username' => 'required|string|alpha_dash|unique:users,username,' . $this->editingUserId,
            'name' => 'required|string|max:255',
            'password' => $this->editingUserId ? 'nullable|min:4' : 'required|min:4',
            'role' => 'required|in:admin,doctor,staff',
        ];
    }

    public function createUser(): void
    {
        $this->ensureAdmin();
        $this->reset(['editingUserId', 'username', 'name', 'email', 'password']);
        $this->role = 'staff';
        $this->showModal = true;
    }

    public function editUser(User $user): void
    {
        $this->ensureAdmin();
        $this->editingUserId = $user->id;
        $this->username = $user->username ?? '';
        $this->name = $user->name;
        $this->email = $user->email ?? ($user->username . '@lab.com');
        $this->password = '';
        $this->role = $user->role ?? 'staff';
        $this->showModal = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->ensureAdmin();
        $this->deletingUserId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteUser(): void
    {
        $this->ensureAdmin();
        if ($this->deletingUserId && $this->deletingUserId !== auth()->id()) {
            User::findOrFail($this->deletingUserId)->delete();
            $msg = 'Pengguna berhasil dihapus.';
            session()->flash('message', $msg);
            $this->dispatch('notify', type: 'success', message: $msg);
        } else {
            $msg = 'Tidak dapat menghapus akun Anda sendiri.';
            session()->flash('error', $msg);
            $this->dispatch('notify', type: 'error', message: $msg);
        }

        $this->showDeleteModal = false;
        $this->deletingUserId = null;
    }

    public function save(): void
    {
        $this->ensureAdmin();
        $validated = $this->validate();
        $generatedEmail = strtolower($validated['username']) . '@lab.com';

        if ($this->editingUserId) {
            $user = User::findOrFail($this->editingUserId);
            $updateData = [
                'username' => $validated['username'],
                'name' => $validated['name'],
                'email' => $generatedEmail,
                'role' => $validated['role'],
            ];
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }
            $user->update($updateData);
            $msg = 'Role dan data pengguna berhasil diperbarui.';
        } else {
            User::create([
                'username' => $validated['username'],
                'name' => $validated['name'],
                'email' => $generatedEmail,
                'role' => $validated['role'],
                'password' => Hash::make($validated['password']),
            ]);
            $msg = 'Pengguna baru dengan role ' . strtoupper($validated['role']) . ' berhasil ditambahkan.';
        }

        session()->flash('message', $msg);
        $this->dispatch('notify', type: 'success', message: $msg);

        $this->showModal = false;
    }

    private function ensureAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Akses Ditolak: Hanya Administrator yang berhak mengubah role.');
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('username', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('role', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.users.index', [
            'users' => $users,
        ])->layout('layouts.app');
    }
}
