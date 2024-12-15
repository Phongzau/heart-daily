@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Danh mục đơn hàng đã xóa
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Danh sách đơn hàng đã xóa mềm</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h2>Danh sách đơn hàng đã xóa mềm</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái đơn</th>
                                        <th>Trạng thái thanh toán</th>
                                        <th>Phương thức thanh toán</th>
                                        <th width=200>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->invoice_id }}</td>
                                            <td>{{ @$order->user->name }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $order->product_qty }}</td>
                                            <td>{{ number_format($order->amount) }} {{ config('settings.currency_icon', 'VNĐ') }}</td>
                                            <td>
                                                @switch($order->order_status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">Chưa xử lý</span>
                                                    @break

                                                    @case('processed_and_ready_to_ship')
                                                        <span class="badge bg-info">Đã xử lý</span>
                                                    @break

                                                    @case('dropped_off')
                                                        <span class="badge bg-info">Đã giao cho đơn vị vận chuyển</span>
                                                    @break

                                                    @case('shipped')
                                                        <span class="badge bg-warning">Đã vận chuyển</span>
                                                    @break

                                                    @case('out_for_delivery')
                                                        <span class="badge bg-primary">Đang giao</span>
                                                    @break

                                                    @case('delivered')
                                                        <span class="badge bg-success">Đã giao hàng</span>
                                                    @break

                                                    @case('return')
                                                        <span class="badge bg-secondary">Trả hàng</span>
                                                    @break

                                                    @case('canceled')
                                                        <span class="badge bg-danger">Hủy bỏ</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-secondary">Không xác định</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @if ($order->payment_status == 1)
                                                    <span class="badge bg-success">Hoàn thành</span>
                                                @else
                                                    <span class="badge bg-warning">Chưa xử lý</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->payment_method }}</td>
                                            <td>
                                                <form action="{{ route('admin.orders.restore', $order->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success" title="Khôi phục"><i class="fa-regular fa-trash-arrow-up fa-xl"></i></button>
                                                </form>
                                                <form action="{{ route('admin.orders.forceDelete', $order->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Xóa vĩnh viễn"><i class="fa-regular fa-eraser fa-xl"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
