@php
    $address = json_decode($order->order_address);
    $shipping = json_decode($order->shipping_method);
    $coupon = json_decode($order->coupon_method);
@endphp
@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Chi tiết đơn hàng
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Đơn hàng</h1>
        </div>
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Hóa đơn</h2>
                                <div class="invoice-number">ID đơn hàng #{{ $order->invoice_id }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Người đặt:</strong><br>
                                        <b>Tên: </b>{{ $order->user->first_name }} {{ $order->user->last_name }}<br>
                                        <b>Email: </b>{{ $order->user->email }}<br>
                                        <b>Điện thoại: </b>{{ $order->user->phone }}<br>
                                        <b>Địa chỉ: </b>{{ $order->user->address }}
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Người nhận:</strong><br>
                                        <b>Tên: </b>{{ $address->first_name }}<br>
                                        <b>Email: </b>{{ $address->email }}<br>
                                        <b>Điện thoại: </b>{{ $address->phone }}<br>
                                        <b>Địa chỉ: </b>{{ $address->address }} <br>
                                        @php
                                            $provinceTitle = \App\Models\Province::query()
                                                ->where('id', $address->province_id)
                                                ->pluck('title')
                                                ->first();

                                            $districtTitle = \App\Models\District::query()
                                                ->where('id', $address->district_id)
                                                ->pluck('title')
                                                ->first();

                                            $communeTitle = \App\Models\Commune::query()
                                                ->where('id', $address->commune_id)
                                                ->pluck('title')
                                                ->first();
                                        @endphp
                                        {{ $provinceTitle }},
                                        {{ $districtTitle }},
                                        {{ $communeTitle }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Thông tin thanh toán:</strong><br>
                                        <b>Phương thức: </b>{{ $order->payment_method }}<br>
                                        <b>ID giao dịch: </b> {{ @$order->transaction->transaction_id }} <br>
                                        <b>Trạng thái: </b>
                                        {{ $order->payment_status === 1 ? 'Hoàn thành' : 'Chưa hoàn thành' }}
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    @php
                                        use Carbon\Carbon;
                                        Carbon::setLocale('vi');
                                    @endphp
                                    <address>
                                        <strong>Ngày đặt hàng:</strong><br>
                                        {{ Carbon::parse($order->created_at)->translatedFormat('d F, Y') }}<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Tóm tắt đơn hàng</div>
                            <p class="section-lead">Không thể xóa tất cả các mục ở đây.</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Mục</th>
                                        <th>Phân loại</th>
                                        <th class="text-center">Giá</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-right">Tổng</th>
                                    </tr>
                                    @foreach ($order->orderProducts as $index => $product)
                                        @php
                                            if ($product->product->type_product === 'product_variant') {
                                                $variants = json_decode($product->variants);
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            @if (isset($product->product->slug))
                                                <td><a target="_blank"
                                                        href="{{ route('product.detail', $product->product->slug) }}">{{ $product->product_name }}</a>
                                                </td>
                                            @else
                                                <td>{{ $product->product_name }}</td>
                                            @endif
                                            <td>
                                                @if ($product->product->type_product === 'product_simple')
                                                    {{ $product->variants }}
                                                @elseif($product->product->type_product === 'product_variant')
                                                    @foreach ($variants as $key => $variant)
                                                        <b>{{ $key }}: </b> {{ $variant }} <br>
                                                    @endforeach
                                                @endif

                                            </td>
                                            <td class="text-center">{{ number_format($product->unit_price) }} VNĐ</td>
                                            <td class="text-center">{{ $product->qty }}</td>
                                            <td class="text-right">
                                                {{ number_format($product->unit_price * $product->qty + $product->variant_total) }}
                                                VNĐ
                                            </td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="">Trạng thái thanh toán</label>
                                            <select name="payment_status" id="payment_status" data-id="{{ $order->id }}"
                                                class="form-control">
                                                <option {{ $order->payment_status == 0 ? 'selected' : '' }} value="0">
                                                    Chưa thanh toán</option>
                                                <option {{ $order->payment_status == 1 ? 'selected' : '' }} value="1">
                                                    Hoàn thành</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="">Trạng thái đơn hàng</label>
                                            <select name="order_status" class="form-control" data-id="{{ $order->id }}"
                                                id="order_status">
                                                @foreach (config('order_status.order_status_admin') as $key => $orderStatus)
                                                    <option
                                                        {{ $order->order_status === 'return' && $key !== 'return' ? 'disabled' : '' }}
                                                        {{ $order->order_status !== 'return' && $key === 'return' ? 'disabled' : '' }}
                                                        {{ $order->order_status === $key ? 'selected' : '' }}
                                                        value="{{ $key }}">{{ $orderStatus['status'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Tổng</div>
                                        <div class="invoice-detail-value">
                                            {{ number_format($order->sub_total) }} VNĐ</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Vận chuyển(+)</div>
                                        <div class="invoice-detail-value">
                                            {{ number_format(getCartCod()) }}VNĐ</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Mã giảm giá(-)</div>
                                        <div class="invoice-detail-value">
                                            {{ @$coupon->discount ? number_format(getOrderDiscount($coupon->discount_type, $order->sub_total, $coupon->discount)) : 0 }}
                                            VNĐ
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Tổng cộng</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ number_format($order->amount) }} VNĐ</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <button class="btn btn-warning btn-icon icon-left print_invoice"><i class="fas fa-print"></i>
                        In</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#order_status').on('change', function() {
                let status = $(this).val();
                let id = $(this).data('id');
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.orders.order.status') }}",
                    data: {
                        status: status,
                        id: id,
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            toastr.success(data.message);
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            })

            $('#payment_status').on('change', function() {
                let status = $(this).val();
                let id = $(this).data('id');
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.orders.payment.status') }}",
                    data: {
                        status: status,
                        id: id,
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            toastr.success(data.message);
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            })

            $('.print_invoice').on('click', function() {
                let printBody = $('.invoice-print');
                let originalContents = $('body').html();

                $('body').html(printBody.html());
                window.print();
                $('body').html(originalContents);

            })
        })
    </script>
@endpush
