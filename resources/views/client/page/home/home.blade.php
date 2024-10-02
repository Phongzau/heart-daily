@extends('layouts.client')

@section('section')
    {{-- Home slider  --}}
    @include('client.page.home.sections.banner-slider')
    {{-- End Home slider  --}}

    {{-- Box slider  --}}
    @include('client.page.home.sections.box-slider')
    {{-- End Box slider  --}}

    {{-- Feature product  --}}
    @include('client.page.home.sections.featured-product')
    {{-- End Feature product  --}}

    {{-- New product  --}}
    @include('client.page.home.sections.new-product')
    {{-- End New product  --}}

    {{-- Feature box  --}}
    @include('client.page.home.sections.feature-box')
    {{-- End Feature box  --}}

    {{-- Promo product  --}}
    @include('client.page.home.sections.promo-product')
    {{-- End Promo product  --}}

    {{-- Blog & Brand & Widget  --}}
    @include('client.page.home.sections.blog-brand-widget')
    {{-- End Blog & Brand & Widget  --}}
@endsection
