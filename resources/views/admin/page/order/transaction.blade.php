@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Thông tin giao dịch
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Thông tin giao dịch</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tất cả thông tin giao dịch</h4>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush