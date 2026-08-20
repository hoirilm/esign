<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $editingPatientId = null;
    public ?int $deletingPatientId = null;

    public string $rm_number = '';
    public string $name = '';
    public ?string $identity_number = null;
    public ?string $dob = null;
    public string $gender = 'Perempuan';
    public ?string $address = null;
    public ?string $phone = null;

    protected function rules(): array
    {
        return [
            'rm_number' => 'required|string|unique:patients,rm_number,' . $this->editingPatientId,
            'name' => 'required|string|max:255',
            'identity_number' => 'nullable|string|max:100',
            'dob' => 'nullable|date',
            'gender' => 'required|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
        ];
    }

    public function createPatient(): void
    {
        $this->reset(['editingPatientId', 'name', 'identity_number', 'dob', 'address', 'phone']);
        $this->rm_number = '00' . str_pad((string) (Patient::count() + 1), 4, '0', STR_PAD_LEFT);
        $this->gender = 'Perempuan';
        $this->showModal = true;
    }

    public function editPatient(Patient $patient): void
    {
        $this->editingPatientId = $patient->id;
        $this->rm_number = $patient->rm_number;
        $this->name = $patient->name;
        $this->identity_number = $patient->identity_number;
        $this->dob = $patient->dob ? $patient->dob->format('Y-m-d') : null;
        $this->gender = $patient->gender;
        $this->address = $patient->address;
        $this->phone = $patient->phone;
        $this->showModal = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingPatientId = $id;
        $this->showDeleteModal = true;
    }

    public function deletePatient(): void
    {
        if ($this->deletingPatientId) {
            $patient = Patient::findOrFail($this->deletingPatientId);
            $patient->delete();
            session()->flash('message', 'Data pasien berhasil dihapus.');
        }

        $this->showDeleteModal = false;
        $this->deletingPatientId = null;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->editingPatientId) {
            $patient = Patient::findOrFail($this->editingPatientId);
            $patient->update($validated);
            session()->flash('message', 'Data pasien berhasil diperbarui.');
        } else {
            Patient::create($validated);
            session()->flash('message', 'Pasien baru berhasil ditambahkan.');
        }

        $this->showModal = false;
    }

    public function render()
    {
        $patients = Patient::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('rm_number', 'like', '%' . $this->search . '%')
                    ->orWhere('identity_number', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.patients.index', [
            'patients' => $patients,
        ])->layout('layouts.app');
    }
}
