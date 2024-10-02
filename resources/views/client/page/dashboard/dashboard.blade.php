@extends('layouts.client')

@section('section')
    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="demo4.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="category.html">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            My Account
                        </li>
                    </ol>
                </div>
            </nav>

            <h1>My Account</h1>
        </div>
    </div>

    <div class="container account-container custom-account-container">
        <div class="row">
            <div class="sidebar widget widget-dashboard mb-lg-0 mb-3 col-lg-3 order-0">
                <h2 class="text-uppercase">My Account</h2>
                <ul class="nav nav-tabs list flex-column mb-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab"
                            aria-controls="dashboard" aria-selected="true">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="order-tab" data-toggle="tab" href="#order" role="tab"
                            aria-controls="order" aria-selected="true">Orders</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="download-tab" data-toggle="tab" href="#download" role="tab"
                            aria-controls="download" aria-selected="false">Downloads</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab"
                            aria-controls="address" aria-selected="false">Addresses</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab"
                            aria-controls="edit" aria-selected="false">Account
                            details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="shop-address-tab" data-toggle="tab" href="#shipping" role="tab"
                            aria-controls="edit" aria-selected="false">Shopping Addres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('wishlist') }}">Wishlist</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Logout</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9 order-lg-last order-1 tab-content">
                @include('client.page.dashboard.sections.dashboard')

                @include('client.page.dashboard.sections.order')

                @include('client.page.dashboard.sections.download')

                @include('client.page.dashboard.sections.address')

                @include('client.page.dashboard.sections.account-details')

                @include('client.page.dashboard.sections.billing-address')

                @include('client.page.dashboard.sections.shipping-address')
            </div><!-- End .tab-content -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-5"></div><!-- margin -->
@endsection
