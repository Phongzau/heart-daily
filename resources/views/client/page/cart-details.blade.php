@extends('layouts.client')

@section('css')
    <style>
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #f8f9fa;
            overflow-x: hidden;
            transition: 0.3s;
            padding-top: 20px;
            border-left: 1px solid #ccc;
            z-index: 1001;
        }

        .sidebar-content {
            padding: 15px;
        }

        .code-coupon {
            font-weight: 700;
        }

        .coupon-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .coupon-card img {
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }

        .coupon-details {
            flex: 1;
        }

        .coupon-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .coupon-code {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .coupon-condition {
            font-size: 14px;
            color: #888;
            margin-bottom: 5px;
        }

        .coupon-expiry {
            font-size: 12px;
            color: #2299dd;
        }

        .use-coupons {
            background-color: #2299dd;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .use-coupons:hover {
            background-color: #656362;
        }

        .used-coupon {
            background-color: #656362;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }

        #openSidebarBtn {
            color: black;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        #openSidebarBtn:hover {
            color: #ffffff;
            background-color: #2299dd;
        }
    </style>
@endsection

@section('section')
    <div class="container">
        <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li class="active">
                <a href="{{ route('cart-details') }}">Shopping Cart</a>
            </li>
            <li>
                <a href="{{ route('checkout') }}">Checkout</a>
            </li>
            <li class="disabled">
                <a href="cart.html">Order Complete</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-lg-12">
                <div class="cart-table-container">
                    <table class="table table-cart">
                        <thead>
                            <tr>
                                <th class="thumbnail-col">
                                    @if (count($carts) !== 0)
                                        <a style="font-size: 9px; color:#ffffff; border-radius: 8%;"
                                            class="btn btn-danger clear_cart">
                                            Clear All
                                        </a>
                                    @endif
                                </th>
                                <th class="product-col">Product</th>
                                <th class="price-col">Price</th>
                                <th class="qty-col">Quantity</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $keyCart => $item)
                                <tr class="product-row">
                                    <td>
                                        <figure class="product-image-container">
                                            <a href="{{ route('product.detail', ['slug' => $item['options']['slug']]) }}"
                                                class="product-image">
                                                <img src="{{ Storage::url($item['options']['image']) }}"
                                                    alt="{{ $item['name'] }}">
                                            </a>

                                            <a href="{{ route('cart.remove-product', ['cartKey' => $keyCart]) }}"
                                                class="btn-remove icon-cancel remove-product" title="Remove Product"></a>
                                        </figure>
                                    </td>
                                    <td class="product-col">
                                        <h5 class="product-title text-center">
                                            <a href="{{ route('product.detail', ['slug' => $item['options']['slug']]) }}">
                                                @if (isset($item['options']['variants']))
                                                    {{ $item['name'] }}
                                                    @foreach ($item['options']['variants'] as $key => $variant)
                                                        <span>
                                                            {{ $key }}: {{ $variant }}
                                                        </span> <br>
                                                    @endforeach
                                                @else
                                                    {{ $item['name'] }}
                                                @endif
                                            </a>
                                        </h5>
                                    </td>
                                    <td>{{ number_format($item['price']) }} VND</td>
                                    <td>
                                        <div class="product-single-qty">
                                            <input class="horizontal-quantity product-qty form-control"
                                                data-cartkey="{{ $keyCart }}" value="{{ $item['qty'] }}"
                                                type="text">
                                        </div><!-- End .product-single-qty -->
                                    </td>
                                    <td class="text-right"><span
                                            id="{{ $keyCart }}">{{ number_format($item['price'] * $item['qty']) }}
                                            VND</span>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($carts) === 0)
                                <div class="text-center">
                                    <span style="width: 100%; color:black; font-size: 20px; font-weight: 700">
                                        Cart is empty!
                                    </span>
                                </div>
                            @endif
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="5" class="clearfix">
                                    <div class="float-left">
                                        <div class="cart-discount">
                                            <form id="coupon_form">
                                                <div class="input-group">
                                                    <input type="text" class="form-control ip-coupon form-control-sm"
                                                        placeholder="Coupon Code"
                                                        value="{{ session()->has('coupon') ? session()->get('coupon')['coupon_code'] : '' }}"
                                                        name="coupon_code">

                                                    <button class="btn btn-sm" type="submit">Apply
                                                        Coupon</button>

                                                </div><!-- End .input-group -->
                                            </form>
                                        </div>
                                    </div><!-- End .float-left -->
                                    <div class="">
                                        <button class="btn choose-coupon btn-sm" id="openSidebarBtn" type="submit">Choose
                                            coupon</button>
                                    </div>
                                    <div style="width: 350px;" class="float-right">
                                        <div class="cart-summary">
                                            <h3>CART TOTALS</h3>

                                            <table class="table table-totals">
                                                <tbody>
                                                    <tr>
                                                        <td>Subtotal:</td>
                                                        <td id="sub_total" style="color: black; font-weight: 700">
                                                            {{ number_format(getCartTotal()) }} VND
                                                        </td>
                                                    </tr>

                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td>Ship COD:</td>
                                                        <td style="color: black; font-weight: 700">
                                                            {{ number_format(getCartCod()) }} VND</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Coupon(-):</td>
                                                        <td id="discount" style="color: black; font-weight: 700">
                                                            {{ number_format(getCartDiscount()) }} VND</td>
                                                    </tr>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td>Total:</td>
                                                        <td id="total" style="font-size: 16px;">
                                                            {{ number_format(getMainCartTotal()) }}
                                                            VND</td>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <div class="checkout-methods">
                                                <a href="{{ route('checkout') }}" class="btn btn-block btn-dark">Proceed to
                                                    Checkout
                                                    <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div><!-- End .cart-summary -->
                                    </div><!-- End .float-right -->
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- End .cart-table-container -->
            </div><!-- End .col-lg-8 -->
        </div><!-- End .row -->
        {{-- <div class="row">
            <div class="col-lg-8">
            </div>
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h3>CART TOTALS</h3>

                    <table class="table table-totals">
                        <tbody>
                            <tr>
                                <td>Subtotal</td>
                                <td><strong style="color: black">{{ number_format(getCartTotal()) }} VND</strong></td>
                            </tr>

                        </tbody>
                        <tbody>
                            <tr>
                                <td>Coupon(-)</td>
                                <td><strong style="color: black">0 VND</strong></td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td>$17.90</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="checkout-methods">
                        <a href="{{ route('checkout') }}" class="btn btn-block btn-dark">Proceed to Checkout
                            <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div><!-- End .cart-summary -->
            </div><!-- End .col-lg-4 -->
        </div> --}}
    </div><!-- End .container -->
    <div id="couponSidebar" class="sidebar">
        <span class="close-btn">&times;</span>
        @livewire('coupon-list')
    </div>
    <div class="mb-6"></div><!-- margin -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Mở modal khi nhấn nút "Choose coupon"
            // Mở sidebar và hiển thị overlay khi nhấn nút
            $("#openSidebarBtn").click(function() {
                $("#couponSidebar").css("width", "400px");
            });

            // Đóng sidebar và ẩn overlay khi nhấn vào dấu '×' hoặc overlay
            $(".close-btn, .overlay").click(function() {
                $("#couponSidebar").css("width", "0");
            });

            // Tăng số lượng input-group-append
            $('.input-group-append').on('click', function() {
                let input = $(this).siblings('.product-qty');
                let cartKey = input.data('cartkey');
                let quantity = parseInt(input.val());

                $.ajax({
                    url: "{{ route('cart.update-quantity') }}",
                    method: "POST",
                    data: {
                        cartKey: cartKey,
                        quantity: quantity,
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            let productId = '#' + cartKey;
                            let totalAmount = data.product_total + ' VND';
                            $(productId).text(totalAmount);
                            renderCartSubTotal();
                            calculateCouponDiscount()
                        } else if (data.status === 'error') {
                            input.val(data.current_qty);
                            toastr.error(data.message);
                        }
                    },
                    error: function(error) {

                    },
                })
            })

            // Giảm số lượng input-group-prepend
            $('.input-group-prepend').on('click', function() {
                let input = $(this).siblings('.product-qty');
                let cartKey = input.data('cartkey');
                let quantity = parseInt(input.val());

                $.ajax({
                    url: "{{ route('cart.update-quantity') }}",
                    method: "POST",
                    data: {
                        cartKey: cartKey,
                        quantity: quantity,
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            let productId = '#' + cartKey;
                            let totalAmount = data.product_total + ' VND';
                            $(productId).text(totalAmount);
                            renderCartSubTotal();
                            calculateCouponDiscount();
                        } else if (data.status === 'error') {
                            input.val(data.current_qty);
                            toastr.error(data.message);
                        }
                    },
                    error: function(error) {

                    },
                })
            })
            $(document).on('click', '.use-coupons', function() {
                let couponCode = $(this).siblings('.coupon-details').find('.code-coupon').text();
                let dataCode = $(this).data('code');

                $.ajax({
                    url: "{{ route('apply-coupon') }}",
                    method: 'GET',
                    data: {
                        coupon_code: couponCode,
                    },
                    success: function(data) {
                        if (data.status == 'error') {
                            toastr.error(data.message);
                        } else if (data.status == 'success') {
                            toastr.success(data.message);
                            $('.use-coupons[data-code="' + dataCode + '"]')
                                .text('Đang sử dụng')
                                .prop('disabled', true)
                                .addClass('used-coupon');
                            updateOtherCoupons(dataCode);
                            $('.ip-coupon').val(couponCode);
                            calculateCouponDiscount();

                        }
                    },
                    error: function(data) {

                    },
                })
            });

            function updateOtherCoupons(selectedCoupon) {
                $('.use-coupons').each(function() {
                    let dataCode = $(this).data('code');
                    if (dataCode !== selectedCoupon) {
                        $(this).text('Sử dụng').prop('disabled', false).removeClass('used-coupon');
                    }
                })
            }
            $('#coupon_form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('apply-coupon') }}",
                    method: 'GET',
                    data: formData,
                    success: function(data) {
                        if (data.status == 'error') {
                            toastr.error(data.message);
                        } else if (data.status == 'success') {
                            toastr.success(data.message);
                            calculateCouponDiscount();
                        }
                    },
                    error: function(data) {

                    },
                })
            })

            $('.clear_cart').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action will clear your cart!",
                    icon: "warning",
                    width: '400px',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, clear it!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            type: 'GET',
                            url: "{{ route('clear.cart') }}",

                            success: function(data) {
                                if (data.status == 'success') {
                                    window.location.reload();
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        })


                    }
                });
            })

            function renderCartSubTotal() {
                $.ajax({
                    url: "{{ route('cart.product-total') }}",
                    method: 'GET',
                    success: function(data) {
                        let totalAmount = data + ' VND';
                        $('#sub_total').text(totalAmount);
                    },
                    error: function(data) {

                    },
                })
            }

            function calculateCouponDiscount() {
                $.ajax({
                    url: "{{ route('coupon-calculation') }}",
                    method: 'GET',
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#discount').text(data.discount + ' VND');
                            $('#total').text(data.cart_total + ' VND');
                        }
                    },
                    error: function(data) {},
                })
            }
        })
    </script>
@endpush
