<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- SEO -->
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="Gorontaloweb.com">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta content="@yield('title')" property="og:title">
    <meta content="@yield('description')" property="og:description">
    {{-- <meta content="@yield('image')" property="og:image"> --}}
    <!-- OG -->
    {{-- <meta property="og:title" content="@yield('title', 'Platform Event Laravel')">
    <meta property="og:description" content="@yield('description', 'Platform Event Multi-Tenant Laravel')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}"> --}}

    <!-- Title -->
    <title>@yield('title')</title>
    <!-- Libs CSS -->
    <link rel="stylesheet" href="{{ asset('css/vendors/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors/carouselTicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors/magnific-popup.css') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Roboto:wght@400;500;700&display=swap" />

    {{-- Vendor & Icon Fonts (non-Vite) --}}
    <link rel="stylesheet" href="{{ asset('fonts/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/boxicons/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/remixicon/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/solid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/regular.min.css') }}">

    <style>
        .ticket-bar {
            display: none;
        }

        /* Tampilkan hanya di mobile & tablet */
        @media (max-width: 991.98px) {
            .ticket-bar {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                z-index: 9999;
                /* background-color: #f3f3f3; */
                background-color: #f8f9fa;
                padding: 10px 15px 8px;
                box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
                justify-content: space-between;
                align-items: center;
            }
        }
    </style>
    @livewireStyles
    @vite([
        'resources/css/main.css',
        'resources/css/style.css',
    ])
</head>
<body class="charity">
    <!--Preloader-->
    <x-header.navbar />

    <!-- Render content -->
    {{ $slot }}

    <x-footer.footer />

    <!-- Scroll top -->
    <div class="btn-scroll-top">
        <svg class="progress-square svg-content" width="100%" height="100%" viewBox="0 0 40 40">
            <path d="M8 1H32C35.866 1 39 4.13401 39 8V32C39 35.866 35.866 39 32 39H8C4.13401 39 1 35.866 1 32V8C1 4.13401 4.13401 1 8 1Z" />
        </svg>
    </div>

    <!-- Libs JS -->
    <script src="{{ asset('js/vendors/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendors/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendors/aos.js') }}"></script>
    <script src="{{ asset('js/vendors/wow.min.js') }}"></script>
    <script src="{{ asset('js/vendors/headhesive.min.js') }}"></script>
    <script src="{{ asset('js/vendors/smart-stick-nav.js') }}"></script>
    <script src="{{ asset('js/vendors/jquery.carouselTicker.min.js') }}"></script>
    <script src="{{ asset('js/vendors/jquery.odometer.min.js') }}"></script>
    <script src="{{ asset('js/vendors/jquery.appear.js') }}"></script>
    <script src="{{ asset('js/vendors/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/vendors/gsap.min.js') }}"></script>
    <script src="{{ asset('js/vendors/ScrollToPlugin.min.js') }}"></script>
    <script src="{{ asset('js/vendors/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('js/vendors/aat.min.js') }}"></script>
    <script src="{{ asset('js/vendors/Splitetext.js') }}"></script>
    <script src="{{ asset('js/vendors/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/vendors/isotope.pkgd.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    window.addEventListener('toast', (e) => {
        const d = e.detail || {};
        Swal.fire({
        toast: true,
        position: 'top-end',
        icon: d.icon || 'info',
        title: d.message || '',
        showConfirmButton: false,
        timer: 2200,
        timerProgressBar: true,
        });
    });
    </script>

    <script src="//unpkg.com/alpinejs" defer></script>
    @livewireScripts
    @vite([
        'resources/js/gsap-custom.js',
        'resources/js/main.js',
    ])
</body>
</html>
