@foreach ($products as $product)
    <div class="col-6 col-sm-4 col-md-3">
        <div class="product-default">
            <figure height="220">
                <a href="{{ route('product.detail', ['slug' => $product->slug]) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" class="product-image"
                        alt="{{ $product->name }}" />
                </a>

                <div class="label-group">
                    <div class="product-label label-hot">HOT</div>
                    @if ($product->offer_price)
                        @php
                            $discount = (($product->price - $product->offer_price) / $product->price) * 100;
                        @endphp
                        <div class="product-label label-sale">-{{ round($discount) }}%</div>
                    @endif
                </div>
            </figure>

            <div class="product-details">
                <div class="category-wrap">
                    <div class="category-list">
                        <a href="{{ route('product.detail', ['slug' => $product->slug]) }}"
                            class="product-category">{{ $product->brand->name ?? ' ' }}</a>
                    </div>
                </div>

                <h3 class="product-title"> <a
                        href="{{ route('product.detail', ['slug' => $product->slug]) }}">{{ $product->name }}</a> </h3>

                <div class="ratings-container">
                    <div class="product-ratings">
                        <span class="ratings" style="width:100%"></span>
                        <!-- End .ratings -->
                        <span class="tooltiptext tooltip-top"></span>
                    </div>
                    <!-- End .product-ratings -->
                </div>
                <!-- End .product-container -->

                <div class="price-box">
                    @if ($product->offer_price)
                        <span class="old-price">{{ number_format($product->price) }}</span>
                        <span class="product-price">{{ number_format($product->offer_price) }}
                            VND</span>
                    @else
                        <span class="product-price">{{ number_format($product->price) }} VND</span>
                    @endif

                </div>
                <!-- End .price-box -->

                <div class="product-action">
                    <a href="wishlist.html" class="btn-icon-wish" title="wishlist"><i class="icon-heart"></i></a>
                    <a href="{{ route('product.detail', ['slug' => $product->slug]) }}"
                        class="btn-icon btn-add-cart"><i class="fa fa-arrow-right"></i><span>SELECT
                            OPTIONS</span></a>
                    <a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View"><i
                            class="fas fa-external-link-alt"></i></a>
                </div>
            </div>
            <!-- End .product-details -->
        </div>
    </div>
@endforeach
<!-- End .col-sm-4 -->
