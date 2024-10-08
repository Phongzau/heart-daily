@extends('layouts.admin')

@section('title')
HeartDaily | Logo
@endsection

@section('section')
<!-- Main Content -->

<section class="section">
    <div class="section-header">
        <h1>Settings</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="list-group" id="list-tab" role="tablist">
                                    <!-- <a class="list-group-item list-group-item-action active" id="list-home-list"
                                        data-toggle="list" href="#list-home" role="tab">General Setting</a>
                                    <a class="list-group-item list-group-item-action" id="list-profile-list"
                                        data-toggle="list" href="#list-profile" role="tab">Email Configuration</a> -->
                                    <a class="active list-group-item list-group-item-action" id="list-messages-list"
                                        data-toggle="list" href="#list-messages" role="tab">Logo and Favicon</a>
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="tab-content" id="nav-tabContent">

                                    @include('admin.page.settings.logo_settings')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
@endpush
