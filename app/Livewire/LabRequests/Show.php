<?php

namespace App\Livewire\LabRequests;

use App\Models\LabRequest;
use App\Models\LabResult;
use App\Models\Verification;
use App\Services\QrCodeService;
use Illuminate\Support\Str;
use Livewire\Component;

class Show extends Component
{
    public LabRequest $labRequest;

    // Editable Metadata
    public string $request_number = '';
    public string $sender_doctor = '';
    public string $pathologist_doctor = '';
    public string $printed_by = '';
    public string $notes = '-';

    // Form states for adding test result item
    public string $category = 'IMUNOLOGI/SEROLOGI';
    public string $test_name = '';
    public string $result_value = '';
    public string $reference_value = 'Negatif';
    public string $unit = '';

    public ?string $qrDataUri = null;

    public function mount(LabRequest $labRequest): void
    {
        $this->labRequest = $labRequest->load(['patient', 'results', 'verification.verifier']);
        $this->request_number = $labRequest->request_number ?? '';
        $this->sender_doctor = $labRequest->sender_doctor ?? '';
        $this->pathologist_doctor = $labRequest->pathologist_doctor ?? '';
        $this->printed_by = $labRequest->printed_by ?? '';
        $this->notes = $labRequest->notes ?? '-';

        $this->refreshQrCode();
    }

    public function refreshQrCode(): void
    {
        if ($this->labRequest->verification) {
            $url = route('verify.show', ['qr_token' => $this->labRequest->verification->qr_token]);
            $this->qrDataUri = QrCodeService::generateSvgDataUri($url, 160);
        }
    }

    public function updateMetadata(): void
    {
        $this->labRequest->update([
            'request_number' => $this->request_number,
            'sender_doctor' => $this->sender_doctor,
            'pathologist_doctor' => $this->pathologist_doctor,
            'printed_by' => $this->printed_by,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Informasi sampel & petugas berhasil diperbarui.');
    }

    public function addResultItem(): void
    {
        $this->validate([
            'category' => 'required|string',
            'test_name' => 'required|string|max:255',
            'result_value' => 'required|string|max:255',
            'reference_value' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:100',
        ]);

        LabResult::create([
            'lab_request_id' => $this->labRequest->id,
            'category' => $this->category,
            'test_name' => $this->test_name,
            'result_value' => $this->result_value,
            'reference_value' => $this->reference_value,
            'unit' => $this->unit,
        ]);

        $this->reset(['test_name', 'result_value', 'unit']);
        $this->reference_value = 'Negatif';
        $this->labRequest->load('results');
        session()->flash('item_message', 'Item tes berhasil ditambahkan.');
    }

    public function deleteResultItem(int $id): void
    {
        if ($this->labRequest->status === 'verified') {
            session()->flash('error', 'Dokumen yang telah diverifikasi tidak dapat diubah.');
            return;
        }

        LabResult::where('id', $id)->where('lab_request_id', $this->labRequest->id)->delete();
        $this->labRequest->load('results');
    }

    public function verifyLabRequest(): void
    {
        if ($this->labRequest->results->count() === 0) {
            session()->flash('error', 'Tidak dapat memverifikasi. Minimal harus ada 1 item hasil lab.');
            return;
        }

        if ($this->labRequest->status === 'verified') {
            session()->flash('message', 'Pemeriksaan ini sudah diverifikasi sebelumnya.');
            return;
        }

        $token = Str::uuid()->toString();

        Verification::create([
            'lab_request_id' => $this->labRequest->id,
            'verified_by' => auth()->id() ?? 1,
            'verified_at' => now(),
            'qr_token' => $token,
        ]);

        $this->labRequest->update(['status' => 'verified']);
        $this->labRequest->load(['verification.verifier']);
        $this->refreshQrCode();

        session()->flash('message', 'Dokumen Hasil Lab BERHASIL diverifikasi secara elektronik (TTE)! QR Code verifikasi telah terbit.');
    }

    public function render()
    {
        return view('livewire.lab-requests.show')
            ->layout('layouts.app');
    }
}
