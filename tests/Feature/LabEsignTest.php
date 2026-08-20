<?php

use App\Models\LabRequest;
use App\Models\LabResult;
use App\Models\Patient;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Support\Str;

test('authenticated user can view patients and lab requests list', function () {
    $user = User::factory()->create(['role' => 'staff']);

    $response = $this->actingAs($user)->get(route('patients.index'));
    $response->assertOk();

    $response = $this->actingAs($user)->get(route('lab-requests.index'));
    $response->assertOk();
});

test('doctor can verify lab request and issue electronic signature qr token', function () {
    $doctor = User::factory()->create(['role' => 'doctor', 'name' => 'dr. Budi PK']);
    $patient = Patient::create([
        'rm_number' => 'RM-999',
        'name' => 'Budi Test',
        'gender' => 'L',
    ]);
    $labReq = LabRequest::create([
        'patient_id' => $patient->id,
        'lab_number' => 'LAB-TEST-001',
        'request_date' => now(),
        'status' => 'draft',
    ]);
    LabResult::create([
        'lab_request_id' => $labReq->id,
        'category' => 'Serologi',
        'test_name' => 'Widal O',
        'result_value' => 'POSITIF 1/160',
    ]);

    // Perform verification directly or via component
    $token = Str::uuid()->toString();
    $verification = Verification::create([
        'lab_request_id' => $labReq->id,
        'verified_by' => $doctor->id,
        'verified_at' => now(),
        'qr_token' => $token,
    ]);

    $labReq->update(['status' => 'verified']);

    expect($labReq->fresh()->status)->toBe('verified');
    expect($verification->verifier->name)->toBe('dr. Budi PK');

    // Test Public QR Verification Page (no auth needed)
    $response = $this->get(route('verify.show', $token));
    $response->assertOk();
    $response->assertSee('DOKUMEN TERVERIFIKASI SAH');
    $response->assertSee('dr. Budi PK');
    $response->assertSee('LAB-TEST-001');

    // Test PDF Generation Endpoint
    $pdfResponse = $this->actingAs($doctor)->get(route('lab-requests.pdf', $labReq->id));
    $pdfResponse->assertOk();
    $pdfResponse->assertHeader('content-type', 'application/pdf');
});

test('invalid qr token shows document not found page', function () {
    $response = $this->get(route('verify.show', 'invalid-fake-token-123'));
    $response->assertOk();
    $response->assertSee('Dokumen Tidak Ditemukan');
});
