@include('client.component.header')
@include('client.component.topbar')
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
@include('client.component.newletter-popup')
