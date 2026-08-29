<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Tanda Tangan Elektronik - Hasil Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col justify-between p-4 sm:p-6 antialiased selection:bg-teal-500 selection:text-white">

    <div class="max-w-xl mx-auto w-full my-auto">
        <!-- Header Brand -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-teal-500/10 border border-teal-500/30 text-teal-600 mb-3 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Portal Verifikasi Dokumen Medis</h1>
            <p class="text-xs text-slate-500 mt-1">Klinik & Laboratorium Patologi Klinik Sehat Sejahtera</p>
        </div>

        @if($verification)
            <!-- Verified Card -->
            <div class="bg-white border border-emerald-500/30 rounded-2xl p-6 shadow-xl relative overflow-hidden">
                <!-- Status Header -->
                <div class="flex items-center gap-4 border-b border-slate-200 pb-5 mb-5">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 border border-emerald-300 flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300 mb-1">
                            DOKUMEN TERVERIFIKASI SAH
                        </span>
                        <h2 class="text-base font-semibold text-slate-900">Tanda Tangan Elektronik Valid</h2>
                    </div>
                </div>

                <!-- Verification Meta -->
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Nomor Laboratorium:</span>
                        <span class="font-semibold text-teal-700">{{ $verification->labRequest->lab_number }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Nomor Rekam Medis:</span>
                        <span class="font-medium text-slate-800">{{ $verification->labRequest->patient->rm_number }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Nama Pasien:</span>
                        <span class="font-medium text-slate-800">{{ $verification->labRequest->patient->name }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Tgl Registrasi:</span>
                        <span class="text-slate-700">{{ $verification->labRequest->request_date->format('d M Y, H:i') }} WIB</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Penanggung Jawab:</span>
                        <span class="font-semibold text-emerald-700">{{ $verification->verifier->name }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Waktu Verifikasi:</span>
                        <span class="text-slate-700">{{ $verification->verified_at->format('d M Y, H:i:s') }} WIB</span>
                    </div>
                </div>

                <!-- Item Results Summary -->
                <div class="mt-6">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Item Pemeriksaan Terdaftar</h3>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-200 space-y-2">
                        @foreach($verification->labRequest->results as $res)
                            <div class="flex justify-between text-xs py-1 px-2 rounded hover:bg-slate-100">
                                <span class="text-slate-700 font-medium">{{ $res->test_name }}</span>
                                <span class="font-semibold {{ Str::contains(strtoupper($res->result_value), ['POSITIF', 'HIGH']) ? 'text-red-600' : 'text-emerald-700' }}">
                                    {{ $res->result_value }} {{ $res->unit }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer Seal -->
                <div class="mt-6 pt-4 border-t border-slate-200 text-center">
                    <p class="text-xs text-slate-500">
                        Dokumen ini telah ditandatangani secara elektronik sesuai dengan ketentuan Pasal 11 UU ITE dan diakui keabsahannya secara hukum.
                    </p>
                </div>
            </div>
        @else
            <!-- Invalid / Not Found Card -->
            <div class="bg-white border border-rose-300 rounded-2xl p-6 shadow-xl text-center">
                <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 border border-rose-300 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900 mb-2">Dokumen Tidak Ditemukan / Tidak Valid</h2>
                <p class="text-sm text-slate-600 mb-4">
                    Token verifikasi <code class="bg-slate-100 px-2 py-1 rounded text-rose-600 font-mono">{{ $qr_token }}</code> tidak terdaftar pada sistem atau telah dibatalkan.
                </p>
                <div class="text-xs text-slate-500">
                    Jika Anda merasa ini adalah kesalahan, silakan hubungi bagian Administrasi Klinik Sehat Sejahtera.
                </div>
            </div>
        @endif

        <div class="text-center mt-6 text-xs text-slate-500">
            &copy; {{ date('Y') }} Klinik Sehat Sejahtera. All rights reserved.
        </div>
    </div>

</body>
</html>
