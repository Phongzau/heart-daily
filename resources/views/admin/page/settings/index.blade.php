@extends('layouts.admin')

@section('title')
    HeartDaily | Settings
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Settings</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Tab Links -->
                                <div class="col-2">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action active" id="list-general-list"
                                            data-toggle="list" href="#list-general" role="tab">General Setting</a>
                                        <a class="list-group-item list-group-item-action" id="list-email-list"
                                            data-toggle="list" href="#list-email" role="tab">Email Configuration</a>
                                        <a class="list-group-item list-group-item-action" id="list-logo-list"
                                            data-toggle="list" href="#list-logo" role="tab">Logo and Favicon</a>
                                    </div>
                                </div>

                                <!-- Tab Content -->
                                <div class="col-10">
                                    <div class="tab-content" id="nav-tabContent">
                                        <!-- General Settings Tab -->
                                        <div class="tab-pane fade show active" id="list-general" role="tabpanel"
                                            aria-labelledby="list-general-list">
                                            @include('admin.page.settings.general_settings')
                                        </div>

                                        <!-- Email Configuration Tab -->
                                        <div class="tab-pane fade" id="list-email" role="tabpanel"
                                            aria-labelledby="list-email-list">
                                            <!-- Include or write content for Email Configuration here -->
                                            <p>Email Configuration content here.</p>
                                        </div>

                                        <!-- Logo and Favicon Tab -->
                                        <div class="tab-pane fade" id="list-logo" role="tabpanel"
                                            aria-labelledby="list-logo-list">
                                            @include('admin.page.settings.logo_settings')
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End Row -->
                        </div>
                    </div> <!-- End Card -->
                </div>
            </div> <!-- End Row -->
        </div> <!-- End Section Body -->
    </section>
@endsection

@push('scripts')
    <!-- Any additional scripts if necessary -->
@endpush
