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
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="filter-order-status">Trạng thái đơn hàng</label>
                                    <select id="filter-order-status" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="pending">Chưa xử lý</option>
                                        <option value="processed_and_ready_to_ship">Đã xử lý</option>
                                        <option value="dropped_off">Đã giao cho đơn vị vận chuyển</option>
                                        <option value="shipped">Đã vận chuyển</option>
                                        <option value="out_for_delivery">Đang giao</option>
                                        <option value="delivered">Đã giao hàng</option>
                                        <option value="return">Trả hàng</option>
                                        <option value="canceled">Hủy bỏ</option>
                                     
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="filter-payment-status">Trạng thái thanh toán</label>
                                    <select id="filter-payment-status" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="1">Hoàn thành</option>
                                        <option value="0">Chưa xử lý</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="filter-start-date">Ngày bắt đầu</label>
                                    <input type="date" id="filter-start-date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="filter-end-date">Ngày kết thúc</label>
                                    <input type="date" id="filter-end-date" class="form-control">
                                </div>
                            </div>
                            
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
        $(document).ready(function () {
    // Lắng nghe sự kiện thay đổi trên các bộ lọc và reload bảng
    $('#filter-order-status, #filter-payment-status, #filter-start-date, #filter-end-date').on('change', function () {
        // Lấy tham số từ các bộ lọc
        let orderStatus = $('#filter-order-status').val();
        let paymentStatus = $('#filter-payment-status').val();
        let startDate = $('#filter-start-date').val();
        let endDate = $('#filter-end-date').val();

        // Thay đổi URL của Ajax và reload bảng
        $('#order-table').DataTable().ajax.url('{{ route('admin.orders.index') }}?order_status=' + orderStatus + '&payment_status=' + paymentStatus + '&start_date=' + startDate + '&end_date=' + endDate).load();
    });
});

    </script>
@endpush
