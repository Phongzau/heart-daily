            <section class="new-products-section">
                <div class="container">
                    <h2 class="section-title heading-border ls-20 border-0">Hàng mới</h2>

                    <div class="products-slider custom-products owl-carousel owl-theme nav-outer show-nav-hover nav-image-center mb-2"
                        data-owl-options="{
						'dots': false,
						'nav': true,
						'responsive': {
							'992': {
								'items': 4
							},
							'1200': {
								'items': 5
							}
						}
					}">
                        @foreach ($products as $product)
                            <div class="product-default appear-animate" data-animation-name="fadeInRightShorter">
                                <figure height="220">
                                    <a href="{{ route('product.detail', ['slug' => $product->slug]) }}">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="product-image"
                                            alt="{{ $product->name }}">
                                    </a>
                                    <div class="label-group">
                                        <div class="product-label label-hot">HOT</div>
                                        @if (checkDiscount($product))
                                            @php
                                                $discount =
                                                    (($product->price - $product->offer_price) / $product->price) * 100;
                                            @endphp
                                            <div class="product-label label-sale">-{{ round($discount) }}%</div>
                                        @endif
                                    </div>
                                </figure>
                                <div class="product-details">
                                    <div class="category-list">
                                        <a href="{{ route('product.detail', ['slug' => $product->slug]) }}"
                                            class="product-category">{{ $product->brand->name ?? ' ' }}</a>
                                    </div>
                                    <h3 class="product-title">
                                        <a
                                            href="{{ route('product.detail', ['slug' => $product->slug]) }}">{{ $product->name }}</a>
                                    </h3>
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

                                                if (empty($priceArray) && !is_array($priceArray)) {
                                                    $priceProduct = 'Không có';
                                                } else {
                                                    $priceProduct = number_format(min($priceArray));
                                                }

                                                // dump($priceProduct);
                                                // sort($priceArray);
                                                // $priceProduct = '';
                                                // if (count(array_unique($priceArray)) === 1) {
                                                //     $priceProduct = number_format($priceArray[0]) . ' VND';
                                                // } else {
                                                //     $priceProduct =
                                                //         number_format($priceArray[0]) .
                                                //         ' VND ~ ' .
                                                //         number_format(end($priceArray)) .
                                                //         ' VND';
                                                // }

                                            @endphp
                                            <span
                                                class="product-price">{{ $priceProduct }}{{ $generalSettings->currency_icon }}</span>
                                        @endif
                                        @if ($product->type_product === 'product_simple')
                                            @if (checkDiscount($product))
                                                <del
                                                    class="old-price">{{ number_format($product->price) }}{{ $generalSettings->currency_icon }}</del>
                                                <span
                                                    class="product-price">{{ number_format($product->offer_price) }}{{ $generalSettings->currency_icon }}</span>
                                            @else
                                                <span
                                                    class="product-price">{{ number_format($product->price) }}{{ $generalSettings->currency_icon }}</span>
                                            @endif
                                        @endif
                                        {{-- @if (checkDiscount($product))
                                            <del class="old-price">{{ number_format($product->price) }}</del>
                                            <span class="product-price">{{ number_format($product->offer_price) }}
                                                VND</span>
                                        @else
                                            <span class="product-price">{{ number_format($product->price) }} VND</span>
                                        @endif --}}
                                    </div>
                                    <!-- End .price-box -->
                                    <div class="product-action">
                                        <a href="#" data-productid="{{ $product->id }}"
                                            class="btn-icon-wish
                                                @if (Auth::check()) {{ Auth::user()->wishlist()->where('product_id', $product->id)->exists()? 'added-wishlist': '' }} @endif
                                             "
                                            title="wishlist"><i class="icon-heart"></i></a>
                                        @if ($product->type_product === 'product_simple')
                                            <form class="shopping-cart-form">
                                                <input name="qty" hidden value="1" type="number">
                                                <input type="text" hidden name="product_id"
                                                    value="{{ $product->id }}">
                                                <button type="submit"
                                                    class="btn-icon add-to-cart-simple btn-add-cart product-type-simple"><i
                                                        class="icon-shopping-cart"></i><span>THÊM VÀO
                                                        GIỎ</span></button>
                                            </form>
                                        @elseif ($product->type_product === 'product_variant')
                                            <a href="{{ route('product.detail', ['slug' => $product->slug]) }}"
                                                class="btn-icon btn-add-cart"><i class="fa fa-arrow-right"></i><span>LỰA
                                                    CHỌN LOẠI
                                                </span></a>
                                        @endif
                                        <a href="ajax/product-quick-view.html" class="btn-quickview2"
                                            title="Quick View"><i class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </div>
                                <!-- End .product-details -->
                            </div>
                        @endforeach


                    </div>
                    <!-- End .featured-proucts -->

                </div>
            </section>
