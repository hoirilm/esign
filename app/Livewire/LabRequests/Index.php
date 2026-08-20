<?php

namespace App\Livewire\LabRequests;

use App\Models\LabRequest;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    public bool $showDeleteModal = false;
    public ?int $deletingLabRequestId = null;

    public function confirmDelete(int $id): void
    {
        $this->deletingLabRequestId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteLabRequest(): void
    {
        if ($this->deletingLabRequestId) {
            $req = LabRequest::findOrFail($this->deletingLabRequestId);
            $req->delete();
            session()->flash('message', 'Pemeriksaan laboratorium berhasil dihapus.');
        }

        $this->showDeleteModal = false;
        $this->deletingLabRequestId = null;
    }

    public function render()
    {
        $labRequests = LabRequest::with(['patient', 'verification.verifier'])
            ->when($this->search, function ($query) {
                $query->where('lab_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('patient', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('rm_number', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.lab-requests.index', [
            'labRequests' => $labRequests,
        ])->layout('layouts.app');
    }
}
