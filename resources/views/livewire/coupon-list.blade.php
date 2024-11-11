        <div class="sidebar-content">
            <h2 style="color: #17a2b8">Kho mã giảm giá</h2>
            @if ($listCoupon && $listCoupon->isNotEmpty())
                @foreach ($listCoupon as $coupon)
                    @php
                        if (session()->has('coupon')) {
                            $couponSession = session()->get('coupon', []);
                            $couponUsed = $couponSession['coupon_code'] == $coupon->code;
                        }

                        if ($coupon->discount_type === 'percent') {
                            $discount = $coupon->discount . '%';
                        } elseif ($coupon->discount_type === 'amount') {
                            $discount = number_format($coupon->discount) . ' VND';
                        }
                    @endphp
                    <div class="coupon-card" data-code="{{ $coupon->code }}">
                        <div class="coupon-details">
                            <div class="coupon-title">{{ $coupon->name }}</div>
                            <div class="coupon-code">Mã: <span class="code-coupon">{{ $coupon->code }}</span> </div>
                            <div class="coupon-code">Giảm: {{ $discount }}</span> </div>
                            <div class="coupon-condition">Điều kiện đơn hàng:
                                {{ number_format($coupon->min_order_value) }}
                                VND</div>
                            <div class="coupon-expiry">HSD:
                                {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}
                            </div>
                        </div>
                        <button class="use-coupons @if (@$couponUsed) used-coupon @endif"
                            data-code="{{ $coupon->code }}" @if (@$couponUsed) disabled @endif>
                            @if (@$couponUsed)
                                Đang sử dụng
                            @else
                                Sử dụng
                            @endif
                        </button>
                    </div>
                @endforeach
            @else
                <div class="coupon-card">
                    <div class="coupon-details text-center">
                        <div class="coupon-title">Không có Coupon nào</div>
                    </div>
                </div>
            @endif


        </div>

        {{-- <div class="sidebar-content">
            <h2>Kho mã giảm giá</h2>
            @foreach ($listCoupon as $coupon)
                <div class="coupon-card">
                    <div class="coupon-details">
                        <div class="coupon-title">{{ $coupon->name }}</div>
                        <div class="coupon-code">Mã: <span class="code-coupon">{{ $coupon->code }}</span> </div>
                        <div class="coupon-condition">Điều kiện đơn hàng: {{ $coupon->min_order_value }} VND</div>
                        <div class="coupon-expiry">HSD: {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}
                        </div>
                        <button class="copy-button">Sử dụng</button>
                    </div>
            @endforeach
        </div> --}}
