<?php

namespace Database\Seeders;

use App\Models\LabRequest;
use App\Models\LabResult;
use App\Models\Patient;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Users (Admin username: admin, password: admin)
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@lab.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        $doctor = User::firstOrCreate(
            ['username' => 'dokter'],
            [
                'name' => 'dr. Kristin Indriana',
                'email' => 'dokter@lab.com',
                'password' => Hash::make('password'),
                'role' => 'doctor',
            ]
        );

        $staff = User::firstOrCreate(
            ['username' => 'petugas'],
            [
                'name' => 'Taufiqurrohman',
                'email' => 'petugas@lab.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        // 2. Patient (Sample data matching image)
        $patient = Patient::create([
            'rm_number' => '004978',
            'name' => 'ABELATUS SOLEHAH',
            'identity_number' => '3528084808040002',
            'dob' => '2004-08-18',
            'gender' => 'Perempuan',
            'address' => 'DSN TALAGAH',
            'phone' => '085259670050',
        ]);

        // 3. Lab Request (Matching exact metadata in image)
        $reqDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2026-06-03 10:54:00');
        $finishedDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2026-06-03 11:10:00');

        $labRequest = LabRequest::create([
            'patient_id' => $patient->id,
            'lab_number' => '008479/RME/WKPMK/V/2026',
            'request_number' => '008477/RME/WKPMK/V/2026',
            'request_date' => $reqDate,
            'specimen_date' => $reqDate,
            'finished_date' => $finishedDate,
            'sender_doctor' => 'APS . (Atas Permintaan Sendiri)',
            'pathologist_doctor' => 'dr. Kristin Indriana',
            'printed_by' => 'Taufiqurrohman',
            'notes' => '-',
            'status' => 'verified',
        ]);

        // 4. Lab Results (Widal Serologi)
        $items = [
            [
                'category' => 'IMUNOLOGI/SEROLOGI',
                'test_name' => '- Salmonella Typhi O',
                'result_value' => 'POSITIF 1/80',
                'reference_value' => 'Negatif',
                'unit' => '',
            ],
            [
                'category' => 'IMUNOLOGI/SEROLOGI',
                'test_name' => '- Salmonella Typhi H',
                'result_value' => 'POSITIF 1/80',
                'reference_value' => 'Negatif',
                'unit' => '',
            ],
            [
                'category' => 'IMUNOLOGI/SEROLOGI',
                'test_name' => '- Salmonella Paratyphi A',
                'result_value' => 'POSITIF 1/80',
                'reference_value' => 'Negatif',
                'unit' => '',
            ],
            [
                'category' => 'IMUNOLOGI/SEROLOGI',
                'test_name' => '- Salmonella Paratyphi B',
                'result_value' => 'POSITIF 1/80',
                'reference_value' => 'Negatif',
                'unit' => '',
            ],
        ];

        foreach ($items as $item) {
            LabResult::create(array_merge($item, ['lab_request_id' => $labRequest->id]));
        }

        // 5. Verification Token
        Verification::create([
            'lab_request_id' => $labRequest->id,
            'verified_by' => $doctor->id,
            'verified_at' => $finishedDate,
            'qr_token' => Str::uuid()->toString(),
        ]);
    }
}
