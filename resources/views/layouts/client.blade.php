<head>
    <!-- PWA -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4caf50">

    <!-- Đăng ký Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker
                .register('{{ asset('service-worker.js') }}')
                .then(reg => console.log('Service Worker registered.', reg))
                .catch(err => console.error('Service Worker registration failed.', err));
        }
    </script>
</head>

@include('client.component.header')
<!-- End .top-notice -->

<header class="header">
    @include('client.component.header-middle')
    <!-- End .header-middle -->
    @include('client.component.header-bottom')
    <!-- End .header-bottom -->
</header>
<!-- End .header -->

<main class="main">
    @yield('section')
</main>
<!-- End .main -->
@include('client.component.footer')