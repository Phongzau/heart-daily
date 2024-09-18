@extends('frontend.layouts.master')

@section('section')
    {{-- Home slider  --}}
    @include('frontend.home.sections.banner-slider')
    {{-- End Home slider  --}}

    {{-- Box slider  --}}
    @include('frontend.home.sections.box-slider')
    {{-- End Box slider  --}}

    {{-- Feature product  --}}
    @include('frontend.home.sections.featured-product')
    {{-- End Feature product  --}}

    {{-- New product  --}}
    @include('frontend.home.sections.new-product')
    {{-- End New product  --}}

    {{-- Feature box  --}}
    @include('frontend.home.sections.feature-box')
    {{-- End Feature box  --}}

    {{-- Promo product  --}}
    @include('frontend.home.sections.promo-product')
    {{-- End Promo product  --}}

    {{-- Blog & Brand & Widget  --}}
    @include('frontend.home.sections.blog-brand-widget')
    {{-- End Blog & Brand & Widget  --}}
@endsection
