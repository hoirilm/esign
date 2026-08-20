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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->editingUserId,
            'password' => $this->editingUserId ? 'nullable|min:6' : 'required|min:6',
            'role' => 'required|in:admin,doctor,staff',
        ];
    }

    public function createUser(): void
    {
        $this->ensureAdmin();
        $this->reset(['editingUserId', 'name', 'email', 'password']);
        $this->role = 'staff';
        $this->showModal = true;
    }

    public function editUser(User $user): void
    {
        $this->ensureAdmin();
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
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
            session()->flash('message', 'Pengguna berhasil dihapus.');
        } else {
            session()->flash('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $this->showDeleteModal = false;
        $this->deletingUserId = null;
    }

    public function save(): void
    {
        $this->ensureAdmin();
        $validated = $this->validate();

        if ($this->editingUserId) {
            $user = User::findOrFail($this->editingUserId);
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }
            $user->update($updateData);
            session()->flash('message', 'Role dan data pengguna berhasil diperbarui.');
        } else {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'password' => Hash::make($validated['password']),
            ]);
            session()->flash('message', 'Pengguna baru dengan role ' . strtoupper($validated['role']) . ' berhasil ditambahkan.');
        }

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
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('role', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.users.index', [
            'users' => $users,
        ])->layout('layouts.app');
    }
}
