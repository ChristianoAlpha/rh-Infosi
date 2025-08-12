<!DOCTYPE html>
<html lang="pt-pt" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('auth/img/infosi2.png') }}">
    
    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS do novo design -->
    <link rel="stylesheet" href="{{ asset('auth/css/styles.css') }}">
</head>
<body>
    <!-- Fundo animado tecnológico -->
    <div class="animated-background">
        <div class="network-grid"></div>
        <div class="floating-particles"></div>
        <div class="tech-lines"></div>
    </div>

    @yield('content')

    <!-- Elementos decorativos -->
    <div class="decorative-elements">
        <div class="floating-icon floating-icon-1">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="floating-icon floating-icon-2">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                <path d="M19.4 15A1.65 1.65 0 0 0 21 13.35A1.65 1.65 0 0 0 19.4 11.65A1.65 1.65 0 0 0 17.75 13.35A1.65 1.65 0 0 0 19.4 15Z" stroke="currentColor" stroke-width="2"/>
                <path d="M4.6 15A1.65 1.65 0 0 0 6.25 13.35A1.65 1.65 0 0 0 4.6 11.65A1.65 1.65 0 0 0 2.95 13.35A1.65 1.65 0 0 0 4.6 15Z" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div class="floating-icon floating-icon-3">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="12,2 15.09,8.26 22,9 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9 8.91,8.26" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>

    <!-- JavaScript do novo design -->
    <script src="{{ asset('auth/js/script.js') }}"></script>
</body>
</html>

