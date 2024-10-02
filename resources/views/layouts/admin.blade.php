@include('admin.component.header')
@include('admin.component.navbar')
@include('admin.component.sidebar')

<!-- Main Content -->
<div class="main-content">
    @yield('section')
</div>
@include('admin.component.footer')
