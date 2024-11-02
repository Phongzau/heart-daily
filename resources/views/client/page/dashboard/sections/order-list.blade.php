@if ($orders->isEmpty())
    <div class="text-center" style="margin: 5px;">
        <h3 style="color:rgba(138, 138, 135, 0.878);">Không có đơn hàng nào !!</h3>
    </div>
@else
    @foreach ($orders as $order)
        <div class="order-content" id="order-{{ $order->id }}">
            <div class="order-item">
                <div class="order-header">
                    <span class="order-shop">HeartDaily Store - {{ $order->created_at->format('d/m/Y') }}</span>
                    <span class="order-status">{{ orderType($order->order_status) }}</span>
                </div>
                @php
                    $product = $order->orderProducts->first();
                    if ($product->product->type_product === 'product_variant') {
                        $variants = json_decode($product->variants, true);
                    }
                @endphp
                <div class="order-body">
                    <div class="order-product">
                        <img src="{{ Storage::url($product->product->image) }}" alt="Product Image"
                            class="product-image">
                        <div class="product-details">
                            <h4 class="product-name">{{ $product->product_name }}
                            </h4>
                            <span class="product-quantity">Phân loại hàng:
                                @if (!empty($variants) && isset($variants))
                                    @foreach ($variants as $key => $variant)
                                        {{ ucfirst($key) }} {{ ucfirst($variant) }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                @else
                                    Không
                                @endif
                            </span> <br>
                            <span>x{{ $product->qty }}</span>
                        </div>
                        <div class="product-price">
                            <span style="float: right;
                        width: 150px;"
                                class="original-price">({{ $product->qty }}) x {{ number_format($product->unit_price) }}
                                VND</span>
                            <span style="float: right;
                        width: 150px;"
                                class="discounted-price">{{ number_format($product->unit_price * $product->qty) }}
                                VND</span>
                        </div>
                    </div>
                </div>

                <!-- Các sản phẩm ẩn được di chuyển ra ngoài order-body -->
                <div class="hidden-products hidden">
                    @foreach ($order->orderProducts as $item)
                        @if ($loop->first)
                            @continue
                        @endif
                        @php
                            if ($item->product->type_product === 'product_variant') {
                                $variants = json_decode($item->variants, true);
                            }
                        @endphp
                        <div class="order-product hidden-product">
                            <img src="{{ Storage::url($item->product->image) }}" alt="Product Image"
                                class="product-image">
                            <div class="product-details">
                                <h4 class="product-name">{{ $item->product_name }}
                                </h4>
                                <span class="product-quantity">Phân loại hàng:
                                    @if (!empty($variants) && isset($variants))
                                        @foreach ($variants as $key => $variant)
                                            {{ ucfirst($key) }} {{ ucfirst($variant) }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @else
                                        Không
                                    @endif
                                </span>
                                <br>
                                <span>x{{ $item->qty }}</span>
                            </div>
                            <div class="product-price">
                                <span style="float: right; width: 150px;" class="original-price">({{ $item->qty }})
                                    x {{ number_format($item->unit_price) }}
                                    VND</span>
                                <span style="float: right; width: 150px;"
                                    class="discounted-price">{{ number_format($item->unit_price * $item->qty) }}
                                    VND</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    @if (count($order->orderProducts) > 1)
                        <span class="show-more" style="cursor: pointer; color: #ee4d2d;">Hiển thị thêm sản
                            phẩm<i style="margin-left: 5px;" class="fas fa-chevron-down"></i></span>
                    @endif
                </div>
                <div class="order-footer">
                    <div class="">
                        <span class="mr-2
                    ">({{ count($order->orderProducts) }} sản
                            phẩm)</span>
                        <span class="total-label">Thành tiền: <strong
                                class="total-price">{{ number_format($order->amount) }} VND</strong></span>
                    </div>
                    <div style="padding: 10px 0px 10px 10px;" class="order-buttons">
                        {!! renderOrderButtons($order->order_status, $order->id) !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- End .row -->
    <nav class="toolbox toolbox-pagination">
        <div class="toolbox-item toolbox-show"></div>
        <ul class="pagination toolbox-item" id="pagination-links">
            {{ $orders->appends(request()->query())->links() }}
        </ul>
    </nav>
@endif
