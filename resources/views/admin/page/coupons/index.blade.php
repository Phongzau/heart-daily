@extends('layouts.admin')

@section('title')
    Heart Daily | Coupons
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Mã giảm giá</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Danh sách mã giảm giá</h4>
                            <div class="card-header-action mr-2">
                                <a href="{{ route('admin.coupons.add') }}" class="btn btn-primary"><i
                                        class="fas fa-plus mr-1"></i>Thêm mã khuyến mãi cho người dùng</a>
                            </div>
                            @can('create-coupons')
                                <div class="card-header-action">
                                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus mr-1"></i>Thêm mới</a>
                                </div>
                            @endcan
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

    <script>
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');
                console.log(id);

                $.ajax({
                    url: "{{ route('admin.coupons.change-status') }}",
                    method: 'PUT',
                    data: {
                        status: isChecked,
                        id: id
                    },
                    success: function(data) {
                        toastr.success(data.message);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush
