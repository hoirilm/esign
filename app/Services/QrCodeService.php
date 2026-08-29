<?php

namespace App\Services;

use App\Models\LabRequest;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCodeService
{
    /**
     * Generate ultra-compact Plain Text string for Lab Verification TTE.
     * Reduces payload size to ~90 characters so QR Code matrix drops to Version 3-4 (33x33 grid),
     * producing huge, sparse, easily-scannable QR code pixels.
     */
    public static function formatLabRequestPlainText(LabRequest $labRequest): string
    {
        $verification = $labRequest->verification;
        $verifierName = $verification?->verifier?->name ?? $labRequest->pathologist_doctor ?? 'Dokter Penanggung Jawab';
        $verifiedAt = $verification?->verified_at ? $verification->verified_at->format('d/m/Y H:i') : '-';

        return implode("\n", [
            "[TTE LAB SAH]",
            "No: " . $labRequest->lab_number,
            "RM: " . ($labRequest->patient->rm_number ?? '-') . " | " . ($labRequest->patient->name ?? '-'),
            "Dokter: " . $verifierName,
            "Tgl: " . $verifiedAt . " WIB",
        ]);
    }

    /**
     * Generate a PNG Base64 Data URI for QR Code string (DomPDF & Web compatible).
     * Uses Low Error Correction Level (L) for maximum module size, sparseness, and fast scanning.
     */
    public static function generatePngDataUri(string $content, int $size = 200): string
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle($size, 2),
                new ImagickImageBackEnd('png')
            );
            $writer = new Writer($renderer);
            $png = $writer->writeString($content, 'UTF-8', ErrorCorrectionLevel::L());

            return 'data:image/png;base64,'.base64_encode($png);
        } catch (\Throwable $e) {
            return self::generateSvgDataUri($content, $size);
        }
    }

    /**
     * Generate an SVG Base64 Data URI for QR Code string.
     */
    public static function generateSvgDataUri(string $content, int $size = 200): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle($size, 2),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $svg = $writer->writeString($content, 'UTF-8', ErrorCorrectionLevel::L());

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }
}
