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

@include('admin.component.header')
@include('admin.component.navbar')
@include('admin.component.sidebar')

<!-- Main Content -->
<div class="main-content">
    @yield('section')
</div>
@include('admin.component.footer')
