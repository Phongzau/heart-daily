@extends('layouts.admin')

@section('title')
    Heart Daily | Category Prodcut
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Category Product</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Category Product</h4>
                            @can('create-categories-products')
                                <div class="card-header-action">
                                    <a href="{{ route('admin.category_products.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Create New
                                    </a>
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

                $.ajax({
                    url: "{{ route('admin.category_products.change-status') }}",
                    method: 'PUT',
                    data: {
                        status: isChecked,
                        id: id
                    },
                    success: function(data) {
                        console.log(data);
                        toastr.success(data.message);

                        // Nếu có mảng id_array trả về từ server
                        if (data.id_array && data.id_array.length > 0) {
                            // Duyệt qua mảng id_array để cập nhật trạng thái của các checkbox tương ứng
                            data.id_array.forEach(function(id) {
                                // Tìm checkbox có data-id trùng với giá trị trong mảng id_array
                                let $checkbox = $("input.change-status[data-id='" + id +
                                    "']");

                                // Nếu trạng thái là không checked, bỏ chọn checkbox
                                if (!isChecked) {
                                    $checkbox.prop('checked',
                                    false); // Xóa trạng thái checked
                                } else {
                                    $checkbox.prop('checked',
                                    true); // Đặt trạng thái checked nếu cần
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush
