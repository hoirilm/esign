<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'KLINIK') : config('app.name', 'KLINIK') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<!-- Google Fonts: Plus Jakarta Sans & Outfit -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
<script>
    document.documentElement.classList.remove('dark');
    window.localStorage.setItem('flux.appearance', 'light');
    if (window.Flux) {
        window.Flux.applyAppearance = function() {
            document.documentElement.classList.remove('dark');
            window.localStorage.setItem('flux.appearance', 'light');
        };
    }
</script>
