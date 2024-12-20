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
                    @if (checkDiscount($product))
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

                @php
                    $averageRating = $product->reviews->avg('rate');
                    $ratingWidth = ($averageRating / 5) * 100;
                @endphp
                <div class="ratings-container">
                    <div class="product-ratings">
                        <span class="ratings" style="width: {{ $ratingWidth }}%"></span>
                        <!-- End .ratings -->
                        <span class="tooltiptext tooltip-top"></span>
                    </div>
                    <!-- End .product-ratings -->
                </div>
                <!-- End .product-container -->

                <div class="price-box">
                    @if ($product->type_product === 'product_variant')
                        @php
                            $priceArray = [];
                            foreach ($product->ProductVariants as $productVariant) {
                                if (checkDiscountVariant($productVariant)) {
                                    $priceArray[] = $productVariant->offer_price_variant;
                                } else {
                                    $priceArray[] = $productVariant->price_variant;
                                }
                            }
                            $priceProduct = number_format(min($priceArray));
                        @endphp
                    @endif
                    @if ($product->type_product === 'product_simple')
                        @if (checkDiscount($product))
                            <del class="old-price">{{ number_format($product->price) }}</del>
                            <span
                                class="product-price">{{ number_format($product->offer_price) }}{{ $generalSettings->currency_icon }}</span>
                        @else
                            <span
                                class="product-price">{{ number_format($product->price) }}{{ $generalSettings->currency_icon }}</span>
                        @endif
                    @elseif ($product->type_product === 'product_variant')
                        <span class="product-price">{{ $priceProduct }}{{ $generalSettings->currency_icon }}</span>
                    @endif

                </div>
                <!-- End .price-box -->

                <div class="product-action">
                    <a href="#" data-productid="{{ $product->id }}"
                        class="btn-icon-wish {{ Auth::check() &&Auth::user()->wishlist()->where('product_id', $product->id)->exists()? 'added-wishlist': '' }}"
                        title="wishlist"><i class="icon-heart"></i></a>
                    @if ($product->type_product === 'product_simple')
                        <form class="shopping-cart-form">
                            <input name="qty" hidden value="1" type="number">
                            <input type="text" hidden name="product_id" value="{{ $product->id }}">
                            <button type="submit"
                                class="btn-icon add-to-cart-simple btn-add-cart product-type-simple"><i
                                    class="icon-shopping-cart"></i><span>THÊM VÀO GIỎ</span></button>
                        </form>
                    @elseif ($product->type_product === 'product_variant')
                        <a href="{{ route('product.detail', ['slug' => $product->slug]) }}"
                            class="btn-icon btn-add-cart"><i class="fa fa-arrow-right"></i><span>LỰA CHỌN
                                LOẠI</span></a>
                    @endif
                    <a href="ajax/product-quick-view.html" class="btn-quickview2" title="Quick View"><i
                            class="fas fa-external-link-alt"></i></a>
                </div>
            </div>
            <!-- End .product-details -->
        </div>
    </div>
@endforeach

<!-- End .col-sm-4 -->
