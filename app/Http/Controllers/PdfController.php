<?php

namespace App\Http\Controllers;

use App\Models\LabRequest;
use App\Services\QrCodeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    public function generateLabReport(Request $request, LabRequest $labRequest)
    {
        $labRequest->load(['patient', 'results', 'verification.verifier']);

        $qrDataUri = null;
        if ($labRequest->verification) {
            $verificationUrl = route('verify.show', ['qr_token' => $labRequest->verification->qr_token]);
            $qrDataUri = QrCodeService::generateSvgDataUri($verificationUrl, 140);
        }

        $pdf = Pdf::loadView('pdf.lab-report', [
            'labRequest' => $labRequest,
            'qrDataUri' => $qrDataUri,
        ])->setPaper('a4', 'portrait');

        $filename = 'Hasil_Lab_' . str_replace('/', '_', $labRequest->lab_number) . '.pdf';

        if ($request->has('download')) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }
}
