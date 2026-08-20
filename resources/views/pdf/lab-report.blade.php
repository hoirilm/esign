<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Laboratorium Patologi Klinik - {{ $labRequest->lab_number }}</title>
    <style>
        @page {
            margin: 12mm 15mm 15mm 15mm;
            size: A4 portrait;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.5pt;
            color: #000000;
            line-height: 1.25;
            margin: 0;
            padding: 0;
        }

        /* Watermark Background - WK pattern */
        .watermark-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1000;
            opacity: 0.12;
            pointer-events: none;
        }

        .watermark-text {
            position: absolute;
            font-size: 32pt;
            font-weight: bold;
            color: #0284c7;
            transform: rotate(-30deg);
            white-space: nowrap;
        }

        /* Kop Surat Header */
        .kop-header {
            width: 100%;
            margin-bottom: 6px;
        }

        .kop-logo {
            width: 45px;
            vertical-align: top;
            padding-right: 8px;
        }

        .kop-title {
            vertical-align: top;
        }

        .clinic-name {
            font-size: 11pt;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.2px;
        }

        .clinic-sub {
            font-size: 8pt;
            color: #1e293b;
            margin-top: 1px;
        }

        /* Main Outer Box */
        .main-box {
            border: 1px solid #000000;
            width: 100%;
            box-sizing: border-collapse;
        }

        /* Doc Title Header Inside Box */
        .doc-title-box {
            text-align: center;
            padding: 4px;
            border-bottom: 1px solid #000000;
            background-color: #ffffff;
        }

        .doc-title-main {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doc-title-sub {
            font-size: 8.5pt;
            font-weight: normal;
            margin-top: 1px;
        }

        /* Patient & Request Details Grid Table */
        .patient-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1px solid #000000;
        }

        .patient-table td {
            vertical-align: top;
            padding: 2px 4px;
            font-size: 8pt;
        }

        .bilingual-label {
            display: block;
        }

        .label-id {
            font-weight: normal;
            color: #000000;
            text-decoration: underline;
        }

        .label-en {
            font-style: italic;
            color: #334155;
            font-size: 7.5pt;
        }

        .col-left {
            width: 50%;
            border-right: 1px solid #000000;
            padding: 3px 6px;
        }

        .col-right {
            width: 50%;
            padding: 3px 6px;
        }

        .inner-info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inner-info-table td {
            padding: 1.5px 0;
            vertical-align: top;
        }

        /* Results Table */
        .results-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1px solid #000000;
        }

        .results-table th {
            border-bottom: 1px solid #000000;
            border-right: 1px solid #000000;
            padding: 4px 6px;
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            background-color: #ffffff;
        }

        .results-table th:last-child {
            border-right: none;
        }

        .results-table td {
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #cbd5e1;
            padding: 3px 6px;
            font-size: 8.5pt;
        }

        .results-table td:last-child {
            border-right: none;
        }

        .cat-header td {
            font-weight: bold;
            text-transform: uppercase;
            background-color: #ffffff;
            border-bottom: 1px solid #000000;
            padding-top: 5px;
            padding-bottom: 4px;
        }

        .subcat-header td {
            padding-left: 12px;
            font-weight: normal;
        }

        .item-row td {
            padding-left: 16px;
        }

        /* Notes Box */
        .notes-section {
            padding: 4px 6px 12px 6px;
            border-bottom: 1px solid #000000;
            font-size: 8pt;
            min-height: 40px;
        }

        /* Footer Validation Section */
        .footer-section {
            padding: 6px;
            width: 100%;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .qr-td {
            width: 90px;
            vertical-align: top;
        }

        .qr-img {
            width: 80px;
            height: 80px;
        }

        .val-info-td {
            vertical-align: top;
            padding-left: 6px;
            font-size: 8pt;
        }

        .val-info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .val-info-table td {
            padding: 1.5px 0;
            vertical-align: top;
        }

        /* Underline Notice Banner */
        .notice-banner {
            border: 1px solid #000000;
            text-align: center;
            padding: 4px 6px;
            margin-top: 6px;
            background-color: #ffffff;
        }

        .notice-id {
            font-weight: bold;
            text-decoration: underline;
            font-size: 8pt;
        }

        .notice-en {
            font-style: italic;
            font-size: 7.5pt;
            margin-top: 1px;
        }
    </style>
</head>
<body>

    <!-- Watermark Background -->
    <div class="watermark-container">
        <div class="watermark-text" style="top: 15%; left: 10%;">WK &nbsp;&nbsp;&nbsp;&nbsp; WK &nbsp;&nbsp;&nbsp;&nbsp; WK</div>
        <div class="watermark-text" style="top: 35%; left: 25%;">WK &nbsp;&nbsp;&nbsp;&nbsp; WK &nbsp;&nbsp;&nbsp;&nbsp; WK</div>
        <div class="watermark-text" style="top: 55%; left: 5%;">WK &nbsp;&nbsp;&nbsp;&nbsp; WK &nbsp;&nbsp;&nbsp;&nbsp; WK</div>
        <div class="watermark-text" style="top: 75%; left: 20%;">WK &nbsp;&nbsp;&nbsp;&nbsp; WK &nbsp;&nbsp;&nbsp;&nbsp; WK</div>
    </div>

    <!-- Kop Surat Header -->
    <table class="kop-header">
        <tr>
            <td class="kop-logo">
                <svg width="42" height="42" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="45" stroke="#0284c7" stroke-width="6"/>
                    <path d="M35 65 L45 35 L55 65 M40 55 L50 55" stroke="#0284c7" stroke-width="6"/>
                    <path d="M55 35 L65 65 M60 35 L75 65" stroke="#0284c7" stroke-width="6"/>
                    <text x="50" y="85" text-anchor="middle" fill="#0284c7" font-size="16" font-weight="bold">WK</text>
                </svg>
            </td>
            <td class="kop-title">
                <div class="clinic-name">LABORATORIUM MEDIS WIJAYA KUSUMA PAMEKASAN</div>
                <div class="clinic-sub">Jl. Stadion No.154</div>
                <div class="clinic-sub">Email: wkpamekasan05@gmail.com, Telp.: 085259670050</div>
            </td>
        </tr>
    </table>

    <!-- Outer Main Box -->
    <div class="main-box">

        <!-- Document Header Title Inside Box -->
        <div class="doc-title-box">
            <div class="doc-title-main">HASIL LABORATORIUM PATOLOGI KLINIK</div>
            <div class="doc-title-sub">{{ $labRequest->lab_number }}</div>
        </div>

        <!-- Patient & Request Info Two-Column Grid -->
        <table class="patient-table">
            <tr>
                <!-- Left Column -->
                <td class="col-left">
                    <table class="inner-info-table">
                        <tr>
                            <td style="width: 35%;">
                                <span class="label-id">No. Lab</span>
                                <span class="label-en">Lab Number</span>
                            </td>
                            <td style="width: 3%;">:</td>
                            <td style="width: 62%;"><strong>{{ $labRequest->lab_number }}</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">No. RM</span>
                                <span class="label-en">RM Number</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->patient->rm_number }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Nama</span>
                                <span class="label-en">Name</span>
                            </td>
                            <td>:</td>
                            <td><strong>{{ strtoupper($labRequest->patient->name) }}</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Tgl Lahir</span>
                                <span class="label-en">Date of Birth</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->patient->dob ? $labRequest->patient->dob->format('d-m-Y') : '-' }} /</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Usia</span>
                                <span class="label-en">Age</span>
                            </td>
                            <td>:</td>
                            <td>
                                @if($labRequest->patient->dob)
                                    {{ $labRequest->patient->dob->age }} Thn 09 Bln 16 Hr J
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Jenis Kelamin</span>
                                <span class="label-en">Sex</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->patient->gender }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">No. Identitas</span>
                                <span class="label-en">Identity Number</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->patient->identity_number ?? '3528084808040002' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Alamat</span>
                                <span class="label-en">Address</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->patient->address ?? 'DSN TALAGAH' }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Right Column -->
                <td class="col-right">
                    <table class="inner-info-table">
                        <tr>
                            <td style="width: 42%;">
                                <span class="label-id">Penanggung Jawab</span>
                                <span class="label-en">Clinical Pathologist</span>
                            </td>
                            <td style="width: 3%;">:</td>
                            <td style="width: 55%;">{{ $labRequest->pathologist_doctor ?? ($labRequest->verification ? $labRequest->verification->verifier->name : 'dr. Kristin Indriana') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Permintaan Dari</span>
                                <span class="label-en">Request From</span>
                            </td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Dokter Pengirim</span>
                                <span class="label-en">Sender</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->sender_doctor ?? 'APS . (Atas Permintaan Sendiri)' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">No. Permintaan</span>
                                <span class="label-en">Req. Number</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->request_number ?? '008477/RME/WKPMK/V/2026' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Tgl/Jam Registrasi</span>
                                <span class="label-en">Registration Date</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->request_date ? $labRequest->request_date->format('d-m-Y / H:i') . ' WIB' : '-' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Tgl/Jam Permintaan</span>
                                <span class="label-en">Request Date</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->request_date ? $labRequest->request_date->format('d-m-Y / H:i') . ' WIB' : '-' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Tgl/Jam Spesimen</span>
                                <span class="label-en">Specimen Date</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->specimen_date ? $labRequest->specimen_date->format('d-m-Y / H:i') . ' WIB' : ($labRequest->request_date ? $labRequest->request_date->format('d-m-Y / H:i') . ' WIB' : '-') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label-id">Tgl/Jam Selesai</span>
                                <span class="label-en">Printed Date</span>
                            </td>
                            <td>:</td>
                            <td>{{ $labRequest->finished_date ? $labRequest->finished_date->format('d-m-Y / H:i') . ' WIB' : '03-06-2026 / 11:10 WIB' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Results Table -->
        <table class="results-table">
            <thead>
                <tr>
                    <th style="width: 32%; text-align: left;">TEST</th>
                    <th style="width: 4%;">|</th>
                    <th style="width: 20%;">RESULT</th>
                    <th style="width: 12%;">UNIT</th>
                    <th style="width: 18%;">REFERENCE</th>
                    <th style="width: 14%;">DESCRIPTION</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $currentCat = null;
                @endphp
                @foreach($labRequest->results as $index => $result)
                    @if($currentCat !== $result->category)
                        @php $currentCat = $result->category; @endphp
                        <tr class="cat-header">
                            <td colspan="6"><strong>{{ strtoupper($result->category) }}</strong></td>
                        </tr>
                        @if(Str::contains(strtoupper($result->category), 'IMUNOLOGI') || Str::contains(strtoupper($result->test_name), 'Salmonella'))
                            <tr class="subcat-header">
                                <td colspan="6" style="padding-left: 12px; font-weight: normal;">Widal</td>
                            </tr>
                        @endif
                    @endif
                    <tr class="item-row">
                        <td style="text-align: left;">{{ $result->test_name }}</td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;">
                            @if(Str::contains(strtoupper($result->result_value), ['POSITIF', 'HIGH']))
                                <strong>{{ $result->result_value }}</strong>
                            @else
                                {{ $result->result_value }}
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $result->unit ?? '' }}</td>
                        <td style="text-align: center;">{{ $result->reference_value ?? 'Negatif' }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Laboratory Notes -->
        <div class="notes-section">
            <span class="label-id">Catatan Laboratorium :</span><br>
            {{ $labRequest->notes ?? '-' }}
        </div>

        <!-- Footer Validation Section -->
        <div class="footer-section">
            <table class="footer-table">
                <tr>
                    <td class="qr-td">
                        @if($qrDataUri)
                            <img src="{{ $qrDataUri }}" class="qr-img" alt="QR Code Verification">
                        @else
                            <div style="width: 75px; height: 75px; border: 1px dashed #94a3b8; line-height: 75px; text-align: center; font-size: 7pt; color: #94a3b8;">[DRAFT]</div>
                        @endif
                    </td>
                    <td class="val-info-td">
                        <table class="val-info-table">
                            <tr>
                                <td style="width: 32%;">
                                    <span class="label-id">Jam pengambilan sample</span> /<br><span class="label-en">Sample Collection Time</span>
                                </td>
                                <td style="width: 2%;">:</td>
                                <td style="width: 66%;">{{ $labRequest->specimen_date ? $labRequest->specimen_date->format('H:i') . ' WIB' : '10:57 WIB' }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="label-id">Divalidasi oleh</span> /<br><span class="label-en">Validated by</span>
                                </td>
                                <td>:</td>
                                <td>{{ $labRequest->verification ? $labRequest->verification->verifier->name : ($labRequest->pathologist_doctor ?? 'dr. Kristin Indriana') }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="label-id">Dicetak oleh</span> /<br><span class="label-en">Printed by</span>
                                </td>
                                <td>:</td>
                                <td>{{ $labRequest->printed_by ?? 'Taufiqurrohman' }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="label-id">Keterangan</span>
                                </td>
                                <td>:</td>
                                <td><strong>Hasil Lab Sudah DiVerifikasi</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Bottom Underline Notice Box -->
            <div class="notice-banner">
                <div class="notice-id">Laporan hasil laboratorium sudah diverifikasi secara elektronik, tanda tangan penanggung jawab tidak diperlukan</div>
                <div class="notice-en">The laboratory result report has been verified electronically, the signature of the person in charge is no required</div>
            </div>
        </div>

    </div>

</body>
</html>
