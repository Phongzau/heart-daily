<div class="product-single-container product-single-default product-quick-view mb-0 custom-scrollbar">
    <div class="row">
        <div class="col-md-6 product-single-gallery mb-md-0">
            <div class="product-slider-container" style="height: 300px;">
                <div class="label-group">
                    <div class="product-label label-hot">HOT</div>
                    <!---->
                    <div class="product-label label-sale">
                        -16%
                    </div>
                </div>

                <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">

                    <div class="product-item">
                        <img class="product-single-image" src="{{ Storage::url($product->image) }}"
                            data-zoom-image="{{ Storage::url($product->image) }}" alt="product" />
                    </div>
                    @foreach ($product->ProductImageGalleries as $image)
                        <div class="product-item">
                            <img class="product-single-image" src="{{ Storage::url($image->image) }}"
                                data-zoom-image="{{ Storage::url($image->image) }}" alt="product" />
                        </div>
                    @endforeach
                </div>
                <!-- End .product-single-carousel -->
            </div>
            <div class="prod-thumbnail owl-dots">
                <div class="owl-dot">
                    <img src="{{ Storage::url($product->image) }}" alt="product-thumbnail" />
                </div>
                @foreach ($product->ProductImageGalleries as $image)
                    <div class="owl-dot">
                        <img src="{{ Storage::url($image->image) }}" alt="product-thumbnail" />
                    </div>
                @endforeach
            </div>
        </div><!-- End .product-single-gallery -->

        <div class="col-md-6">
            <div class="product-single-details mb-0 ml-md-4">
                <h1 class="product-title">{{ $product->name }}</h1>

                @php
                    $averageRating = $product->reviews->avg('rate');
                    $ratingWidth = ($averageRating / 5) * 100;
                @endphp

                <div class="ratings-container">
                    <div class="product-ratings">
                        <span class="ratings" style="width:{{ $ratingWidth }}%"></span>
                        <!-- End .ratings -->
                        <span class="tooltiptext tooltip-top"></span>
                    </div>
                    <!-- End .product-ratings -->

                    <a href="#" class="rating-link">{{ $reviews->count() }} Đánh giá</a>
                </div>
                <!-- End .ratings-container -->

                <hr class="short-divider">

                @if ($product->type_product === 'product_simple')
                    @if (checkDiscount($product))
                        <div class="price-box">
                            <span
                                class="old-price">{{ number_format($product->price) }}{{ $generalSettings->currency_icon }}</span>
                            <span
                                class="product-price"><del>{{ number_format($product->offer_price) }}{{ $generalSettings->currency_icon }}</del></span>
                        </div>
                    @else
                        <div class="price-box">
                            <span class="product-price">{{ number_format($product->price) }} VND</span>
                        </div>
                    @endif
                @else
                    @php
                        $priceArray = [];
                        foreach ($product->ProductVariants as $productVariant) {
                            if (checkDiscountVariant($productVariant)) {
                                $priceArray[] = $productVariant->offer_price_variant;
                            } else {
                                $priceArray[] = $productVariant->price_variant;
                            }
                        }
                        sort($priceArray);
                        $priceProduct = '';
                        if (count(array_unique($priceArray)) === 1) {
                            $priceProduct = number_format($priceArray[0]);
                        } else {
                            $priceProduct =
                                number_format($priceArray[0]) .
                                $generalSettings->currency_icon .
                                ' ~ ' .
                                number_format(end($priceArray)) .
                                $generalSettings->currency_icon;
                        }

                    @endphp
                    <div class="price-box">
                        <span class="product-price price-render">{{ $priceProduct }} </span>
                    </div>
                @endif

                <div class="product-desc">
                    <p>
                        {{ $product->short_description }}
                    </p>
                </div><!-- End .product-desc -->

                <ul class="single-info-list">
                    <!---->
                    <li>
                        Mã:
                        <strong>{{ $product->sku }}</strong>
                    </li>

                    <li>
                        Danh mục:
                        <strong>
                            <a href="#" class="product-category">{{ $product->category->title }}</a>
                        </strong>
                    </li>
                    <li>
                        Số lượng:
                        <strong>
                            @if ($product->type_product === 'product_simple')
                                <a href="#" class="product-category ">{{ $product->qty }}</a>
                            @else
                                @php
                                    $total = 0;
                                    foreach ($product->ProductVariants as $variant) {
                                        $total += $variant->qty;
                                    }
                                @endphp
                                <a href="#" class="product-category qty-product">{{ $total }}</a>
                            @endif

                        </strong>
                    </li>
                </ul>

                <div class="product-filters-container">
                    @php
                        // Sắp xếp các nhóm thuộc tính để color trước size
                        $orderedKeys = ['Color', 'Size', 'Material'];
                        $remainingKeys = array_diff(array_keys($variantGroups), $orderedKeys); // Lấy các key không nằm trong orderedKeys
                    @endphp

                    @foreach ($orderedKeys as $key)
                        @if (array_key_exists($key, $variantGroups))
                            <div class="product-single-filter">
                                <label>{{ strtolower($key) }}</label>
                                <ul class="config-size-list">
                                    @foreach ($variantGroups[$key] as $index => $item)
                                        <li>
                                            <a href="javascript:;"
                                                class="d-flex select-variant align-items-center justify-content-center {{ strtolower($key) }}-options {{ $key === 'Color' && $index === 0 ? 'default-selected' : '' }}"
                                                data-idproduct="{{ $product->id }}"
                                                data-{{ strtolower($key) }}="{{ $item }}"
                                                data-attribute="{{ strtolower($key) }}"
                                                data-value="{{ $item }}">{{ $item }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach

                    @foreach ($remainingKeys as $key)
                        <!-- In các key không nằm trong orderedKeys -->
                        <div class="product-single-filter">
                            <label>{{ strtolower($key) }}</label>
                            <ul class="config-size-list">
                                @foreach ($variantGroups[$key] as $index => $item)
                                    <li>
                                        <a href="javascript:;"
                                            class="d-flex select-variant align-items-center justify-content-center {{ strtolower($key) }}-options"
                                            data-idproduct="{{ $product->id }}"
                                            data-{{ strtolower($key) }}="{{ $item }}"
                                            data-attribute="{{ strtolower($key) }}"
                                            data-value="{{ $item }}">{{ $item }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach

                    <div class="product-single-filter">
                        <label></label>
                        <a class="font1 text-uppercase clear-btn" href="#">Clear</a>
                    </div>
                    <!---->
                </div>

                <form id="add-to-cart">
                    <div class="product-action">

                        <div class="product-single-qty">
                            @if ($product->type_product === 'product_simple')
                                <input class="horizontal-quantity form-control" min="1"
                                    max="{{ $product->qty }}" name="qty" type="text">
                            @else
                                <input class="horizontal-quantity form-control" min="1" max=""
                                    name="qty" type="text">
                            @endif


                            <input type="text" hidden name="product_id" value="{{ $product->id }}">
                        </div>
                        <!-- End .product-single-qty -->

                        <button type="submit" class="btn btn-dark mr-2" title="Add to Cart"><i
                                class="fas fa-cart-plus mr-2"></i>Thêm vào giỏ</button>

                        <a href="cart.html" class="btn btn-gray view-cart d-none">Xem giỏ</a>
                    </div>
                </form>

                <hr class="divider mb-0 mt-0">
                @php
                    $socials = \App\Models\Social::query()->where('status', 1)->get();

                @endphp
                <div class="product-single-share mb-0">
                    <label class="sr-only">Share:</label>

                    <div class="social-icons mr-2">
                        <div class="social-icons">
                            @foreach ($socials as $social)
                                <a href="{{ $social->url }}" class="social-icon" target="_blank">
                                    <i class="{{ $social->icon }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div><!-- End .social-icons -->

                    <a href="#" data-productid="{{ $product->id }}" class="btn-icon-wish add-wishlist"
                        class="btn-icon-wish {{ Auth::check() &&Auth::user()->wishlist()->where('product_id', $product->id)->exists()? 'added-wishlist': '' }}"
                        title="Add to Wishlist"><i class="icon-wishlist-2"></i><span>Thêm vào danh sách yêu
                            thích</span></a>
                </div><!-- End .product single-share -->
            </div>
        </div><!-- End .product-single-details -->

    </div><!-- End .row -->
</div><!-- End .product-single-container -->
