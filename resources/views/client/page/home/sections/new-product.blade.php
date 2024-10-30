            <section class="new-products-section">
                <div class="container">
                    <h2 class="section-title heading-border ls-20 border-0">New Arrivals</h2>

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
                                        <a href="{{ route('product.detail', ['slug' => $product->slug]) }}">{{ $product->name }}</a>
                                    </h3>
                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:80%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->
                                    <div class="price-box">

                                        @if (checkDiscount($product))
                                            <del class="old-price">{{ number_format($product->price) }}</del>
                                            <span class="product-price">{{ number_format($product->offer_price) }}
                                                VND</span>
                                        @else
                                            <span class="product-price">{{ number_format($product->price) }} VND</span>
                                        @endif
                                    </div>
                                    <!-- End .price-box -->
                                    <div class="product-action">
                                        <a href="#" data-productid="{{ $product->id }}" class="btn-icon-wish {{ Auth::check() && Auth::user()->wishlist()->where('product_id', $product->id)->exists() ? 'added-wishlist' : '' }}" title="wishlist"><i class="icon-heart"></i></a>
                                        <a href="#" class="btn-icon btn-add-cart product-type-simple"><i
                                                class="icon-shopping-cart"></i><span>ADD TO CART</span></a>
                                        <a href="ajax/product-quick-view.html" class="btn-quickview"
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
