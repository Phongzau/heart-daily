@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Danh mục đơn hàng
@endsection
@section('css')
    <style>
        .disabled-link {
            pointer-events: none;
            cursor: not-allowed;
            text-decoration: none;
        }
    </style>
@endsection
@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Đơn hàng</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tất cả đơn hàng</h4>
                            <div class="card-header-action"><a href="{{ route('admin.orders.deleted') }}"
                                    class="btn btn-secondary">
                                    <i class="fas fa-trash"></i> Thùng rác
                                </a></div>
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
