<?php

namespace App\Livewire\LabRequests;

use App\Models\LabRequest;
use App\Models\Patient;
use Livewire\Component;

class Create extends Component
{
    public ?int $patient_id = null;
    public string $lab_number = '';
    public string $request_number = '';
    public string $request_date = '';
    public string $specimen_date = '';
    public string $finished_date = '';
    public string $sender_doctor = '';
    public string $pathologist_doctor = '';
    public string $printed_by = '';
    public string $notes = '-';

    public function mount(): void
    {
        $this->lab_number = '00' . str_pad((string) (LabRequest::count() + 1), 4, '0', STR_PAD_LEFT) . '/RME/WKPMK/V/2026';
        $this->request_number = '00' . str_pad((string) (LabRequest::count() + 1), 4, '0', STR_PAD_LEFT) . '/RME/WKPMK/V/2026';
        $this->request_date = now()->format('Y-m-d\TH:i');
        $this->specimen_date = now()->format('Y-m-d\TH:i');
        $this->finished_date = now()->addMinutes(16)->format('Y-m-d\TH:i');
        $this->sender_doctor = 'APS . (Atas Permintaan Sendiri)';
        $this->pathologist_doctor = 'dr. Kristin Indriana';
        $this->printed_by = auth()->user()->name ?? 'Taufiqurrohman';
    }

    protected function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'lab_number' => 'required|string|unique:lab_requests,lab_number',
            'request_number' => 'nullable|string',
            'request_date' => 'required|date',
            'specimen_date' => 'nullable|date',
            'finished_date' => 'nullable|date',
            'sender_doctor' => 'nullable|string|max:255',
            'pathologist_doctor' => 'nullable|string|max:255',
            'printed_by' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $labRequest = LabRequest::create(array_merge($validated, [
            'status' => 'draft',
        ]));

        session()->flash('message', 'Pemeriksaan laboratorium berhasil dibuat. Silakan input item hasil lab.');

        return redirect()->route('lab-requests.show', $labRequest->id);
    }

    public function render()
    {
        $patients = Patient::orderBy('name')->get();

        return view('livewire.lab-requests.create', [
            'patients' => $patients,
        ])->layout('layouts.app');
    }
}
