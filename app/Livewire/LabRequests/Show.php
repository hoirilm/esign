<?php

namespace App\Livewire\LabRequests;

use App\Models\LabRequest;
use App\Models\LabResult;
use App\Models\Verification;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\Hash;
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
    public string $category = 'HEMATOLOGI';
    public string $test_name = '';
    public string $result_value = '';
    public string $reference_value = '';
    public string $unit = '';

    // Modal & Verification state
    public bool $showVerifyModal = false;
    public string $verifyPassword = '';

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
            $plainText = QrCodeService::formatLabRequestPlainText($this->labRequest);
            $this->qrDataUri = QrCodeService::generatePngDataUri($plainText, 180);
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

        $msg = 'Informasi sampel & petugas berhasil diperbarui.';
        session()->flash('message', $msg);
        $this->dispatch('notify', type: 'success', message: $msg);
    }

    public function addResult(): void
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

        $this->reset(['test_name', 'result_value', 'reference_value', 'unit']);
        $this->labRequest->load('results');

        $msg = 'Item hasil tes laboratorium berhasil ditambahkan.';
        session()->flash('message', $msg);
        $this->dispatch('notify', type: 'success', message: $msg);
    }

    public function addResultItem(): void
    {
        $this->addResult();
    }

    public function removeResult(int $id): void
    {
        if ($this->labRequest->status === 'verified') {
            $msg = 'Dokumen yang telah diverifikasi TTE tidak dapat diubah.';
            session()->flash('error', $msg);
            $this->dispatch('notify', type: 'error', message: $msg);
            return;
        }

        LabResult::where('id', $id)->where('lab_request_id', $this->labRequest->id)->delete();
        $this->labRequest->load('results');

        $msg = 'Item hasil uji berhasil dihapus.';
        session()->flash('message', $msg);
        $this->dispatch('notify', type: 'success', message: $msg);
    }

    public function deleteResultItem(int $id): void
    {
        $this->removeResult($id);
    }

    public function openVerifyModal(): void
    {
        if (! auth()->user()->isDoctor()) {
            $msg = 'Hanya akun ber-role Dokter yang dapat melakukan verifikasi TTE.';
            session()->flash('error', $msg);
            $this->dispatch('notify', type: 'error', message: $msg);
            return;
        }

        if ($this->labRequest->results->count() === 0) {
            $msg = 'Tidak dapat memverifikasi. Minimal harus ada 1 item hasil lab.';
            session()->flash('error', $msg);
            $this->dispatch('notify', type: 'error', message: $msg);
            return;
        }

        $this->verifyPassword = '';
        $this->showVerifyModal = true;
    }

    public function verifyTte(): void
    {
        if (! auth()->user()->isDoctor()) {
            $msg = 'Hanya akun ber-role Dokter yang dapat melakukan verifikasi TTE.';
            session()->flash('error', $msg);
            $this->dispatch('notify', type: 'error', message: $msg);
            return;
        }

        if (! Hash::check($this->verifyPassword, auth()->user()->password)) {
            $this->addError('verifyPassword', 'Password yang Anda masukkan salah.');
            return;
        }

        $this->verifyLabRequest();
        $this->showVerifyModal = false;
    }

    public function verifyLabRequest(): void
    {
        if ($this->labRequest->results->count() === 0) {
            $msg = 'Tidak dapat memverifikasi. Minimal harus ada 1 item hasil lab.';
            session()->flash('error', $msg);
            $this->dispatch('notify', type: 'error', message: $msg);
            return;
        }

        if ($this->labRequest->status === 'verified') {
            $msg = 'Pemeriksaan ini sudah diverifikasi sebelumnya.';
            session()->flash('message', $msg);
            $this->dispatch('notify', type: 'success', message: $msg);
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

        $msg = 'Dokumen Hasil Lab BERHASIL diverifikasi secara elektronik (TTE)! QR Code verifikasi telah terbit.';
        session()->flash('message', $msg);
        $this->dispatch('notify', type: 'success', message: $msg);
    }

    public function render()
    {
        return view('livewire.lab-requests.show')
            ->layout('layouts.app');
    }
}
