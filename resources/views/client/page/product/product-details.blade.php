@extends('layouts.client')

@section('title')
    {{ $generalSettings->site_name }} || {{ $product->name }}
@endsection

@section('css')
    <style>
        .size-options.disabled {
            color: gray;
            /* Màu chữ xám cho các kích cỡ bị disable */
            cursor: not-allowed;
            /* Đổi con trỏ chuột thành hình tay không cho biết không thể nhấp vào */
            position: relative;
            /* Để thêm dấu X */
            text-decoration: none;
            /* Xóa gạch ngang chữ */
        }

        /* Tạo đường kẻ chéo tạo thành hình X */
        .size-options.disabled::before,
        .size-options.disabled::after {
            content: '';
            /* Không có nội dung, chỉ cần đường kẻ */
            position: absolute;
            /* Đặt vị trí tuyệt đối */
            background-color: gray;
            /* Màu sắc của đường kẻ */
            width: 100%;
            /* Đặt chiều rộng */
            height: 1px;
            /* Đặt chiều cao của đường kẻ mỏng hơn */
            left: 0;
            /* Đặt vị trí bên trái */
        }

        /* Đường kẻ chéo thứ nhất */
        .size-options.disabled::before {
            transform: rotate(45deg);
            /* Xoay 45 độ */
            top: 50%;
            /* Đặt giữa chiều cao của phần tử */
        }

        /* Đường kẻ chéo thứ hai */
        .size-options.disabled::after {
            transform: rotate(-45deg);
            /* Xoay -45 độ */
            top: 50%;
            /* Đặt giữa chiều cao của phần tử */
        }
    </style>
@endsection

@section('section')
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/product">Sản phẩm</a></li>
            </ol>
        </nav>

        <div class="product-single-container product-single-default">
            <div class="cart-message d-none">
                <strong class="single-cart-notice">“Men Black Sports Shoes”</strong>
                <span>Đã được thêm vào giỏ hàng của bạn.</span>
            </div>

            <div class="row">
                <div class="col-lg-5 col-md-6 product-single-gallery">
                    <div class="product-slider-container">
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
                                    data-zoom-image="{{ Storage::url($product->image) }}" width="468" height="468"
                                    alt="product" />
                            </div>
                            @foreach ($product->ProductImageGalleries as $image)
                                <div class="product-item">
                                    <img class="product-single-image" src="{{ Storage::url($image->image) }}"
                                        data-zoom-image="{{ Storage::url($image->image) }}" width="468" height="468"
                                        alt="product" />
                                </div>
                            @endforeach
                        </div>
                        <!-- End .product-single-carousel -->
                        <span class="prod-full-screen">
                            <i class="icon-plus"></i>
                        </span>
                    </div>

                    <div class="prod-thumbnail owl-dots">
                        <div class="owl-dot">
                            <img src="{{ Storage::url($product->image) }}" width="110" height="110"
                                alt="product-thumbnail" />
                        </div>
                        @foreach ($product->ProductImageGalleries as $image)
                            <div class="owl-dot">
                                <img src="{{ Storage::url($image->image) }}" width="110" height="110"
                                    alt="product-thumbnail" />
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- End .product-single-gallery -->

                <div class="col-lg-7 col-md-6 product-single-details">
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

                        <a href="#" class="rating-link">{{ $reviews->total() }} Đánh giá</a>
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


                    <!-- End .price-box -->

                    <div class="product-desc">
                        <p>
                            {{ $product->short_description }}
                        </p>
                    </div>
                    <!-- End .product-desc -->

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

                        {{-- <li>
                            Thẻ:
                            <strong><a href="#" class="product-category">Quần áo</a></strong>,
                            <strong><a href="#" class="product-category">ÁO LEN</a></strong>
                        </li> --}}
                    </ul>
                    <div id="product-filters" class="product-filters-container">
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
                            <a class="font1 text-uppercase clear-btn" href="#">XÓA</a>
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
                    <!-- End .product-action -->

                    @php
                        $socials = \App\Models\Social::query()->where('status', 1)->get();

                    @endphp

                    <hr class="divider mb-0 mt-0">

                    <div class="product-single-share mb-2">
                        <div class="social-icons mr-2">
                            <div class="social-icons">
                                @foreach ($socials as $social)
                                    <a href="{{ $social->url }}" class="social-icon" target="_blank">
                                        <i class="{{ $social->icon }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <!-- End .social-icons -->

                        <a href="#" data-productid="{{ $product->id }}" class="btn-icon-wish add-wishlist"
                            class="btn-icon-wish {{ Auth::check() &&Auth::user()->wishlist()->where('product_id', $product->id)->exists()? 'added-wishlist': '' }}"
                            title="Add to Wishlist"><i class="icon-wishlist-2"></i><span>Thêm vào danh sách yêu
                                thích</span></a>

                    </div>
                    <!-- End .product single-share -->
                </div>
                <!-- End .product-single-details -->
            </div>
            <!-- End .row -->
        </div>
        <!-- End .product-single-container -->

        <div class="product-single-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content"
                        role="tab" aria-controls="product-desc-content" aria-selected="true">Mô tả</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="product-tab-tags" data-toggle="tab" href="#product-tags-content"
                        role="tab" aria-controls="product-tags-content" aria-selected="false">Thông tin sản phẩm</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link count-review" id="product-tab-reviews" data-toggle="tab"
                        href="#product-reviews-content" role="tab" aria-controls="product-reviews-content"
                        aria-selected="false">{{ $reviews->total() }} Đánh giá</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                    aria-labelledby="product-tab-desc">
                    <div class="product-desc-content">
                        {!! $product->long_description !!}
                    </div>
                    <!-- End .product-desc-content -->
                </div>
                <!-- End .tab-pane -->

                <div class="tab-pane fade" id="product-tags-content" role="tabpanel" aria-labelledby="product-tab-tags">
                    <table class="table table-striped mt-2">
                        <tbody>
                            @foreach ($variantGroups as $key => $value)
                                <tr>
                                    <th>{{ $key }}</th>
                                    <td>
                                        @foreach ($value as $item)
                                            {{ $item }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- End .tab-pane -->
                <div class="tab-pane fade" id="product-reviews-content" role="tabpanel"
                    aria-labelledby="product-tab-reviews">
                    <div class="product-reviews-content">
                        <div id="reviewSection">
                            @include('client.page.product.review-list', ['reviews' => $reviews])
                        </div>
                        @php
                            if (auth()->check()) {
                                $isBrought = \App\Models\Order::query()
                                    ->where([
                                        'user_id' => auth()->id(),
                                        'order_status' => 'delivered',
                                    ])
                                    ->whereHas('orderProducts', function ($query) use ($product) {
                                        $query->where('product_id', $product->id);
                                    })
                                    ->exists();

                                $hasComment = $product->reviews()->where('user_id', auth()->id())->exists();

                                if ($hasComment || !$isBrought) {
                                    $isBrought = false;
                                }
                            }
                        @endphp
                        @if (isset($isBrought) && $isBrought === true)
                            <div class="add-product-review">
                                <h3 class="review-title">Thêm đánh giá</h3>

                                <form id="reviewForm" data-slug="{{ $product->slug }}" class="comment-form m-0">
                                    <div class="rating-form">
                                        <label for="rate">Đánh giá<span class="required">*</span></label>
                                        <span class="rating-stars">
                                            <a class="star-1" data-value="1" href="#">1</a>
                                            <a class="star-2" data-value="2" href="#">2</a>
                                            <a class="star-3" data-value="3" href="#">3</a>
                                            <a class="star-4" data-value="4" href="#">4</a>
                                            <a class="star-5" data-value="5" href="#">5</a>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Đánh giá của bạn<span class="required">*</span></label>
                                        <textarea name="review" cols="5" rows="6" class="form-control form-control-sm" required></textarea>
                                    </div>
                                    <!-- End .form-group -->
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="submit" class="btn btn-primary" value="Gửi">
                                </form>

                            </div>
                        @endif

                        <!-- End .add-product-review -->

                    </div>
                    <!-- End .product-reviews-content -->
                </div>
                <!-- End .tab-pane -->
            </div>
            <!-- End .tab-content -->
        </div>
        <!-- End .product-single-tabs -->

        <div class="products-section pt-0">
            <h2 class="section-title">Sản phẩm liên quan</h2>

            <div class="products-slider owl-carousel owl-theme dots-top dots-small">
                @foreach ($productRelated as $product)
                    <div class="product-default">
                        <figure>
                            <a href="{{ route('product.detail', ['slug' => $product->slug]) }}">
                                <img src="{{ Storage::url($product->image) }}" width="280" height="280"
                                    alt="product">
                                <img src="{{ Storage::url($product->image) }}" width="280" height="280"
                                    alt="product">
                                {{-- <img src="
                                @if (isset($product->ProductImageGalleries[0]->image)) {{ Storage::url($product->ProductImageGalleries[0]->image) }}
                                @else
                                    {{ Storage::url($product->image) }} @endif
                                    "width="280"
                                    height="280" alt="product"> --}}
                            </a>
                            <div class="label-group">
                                <div class="product-label label-hot">HOT</div>
                                <div class="product-label label-sale">-20%</div>
                            </div>
                        </figure>
                        <div class="product-details">
                            <div class="category-list">
                                <a href="category.html" class="product-category">{{ $product->category->title }}</a>
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
                                    <span class="ratings" style="width:{{ $ratingWidth }}%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
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
                                @elseif ($product->type_product === 'product_variant')
                                    <span
                                        class="product-price">{{ $priceProduct }}{{ $generalSettings->currency_icon }}</span>
                                @endif
                            </div>


                            <!-- End .price-box -->
                            <div class="product-action">
                                <a href="#" data-productid="{{ $product->id }}"
                                    class="btn-icon-wish {{ Auth::check() &&Auth::user()->wishlist()->where('product_id', $product->id)->exists()? 'added-wishlist': '' }}"
                                    title="wishlist"><i class="icon-heart"></i></a>
                                <a href="{{ route('product.detail', ['slug' => $product->slug]) }}"
                                    class="btn-icon btn-add-cart"><i class="fa fa-arrow-right"></i><span>LỰA CHỌN
                                        LOẠI</span></a>
                                <a href="ajax/product-quick-view.html" class="btn-quickview2" title="Quick View"><i
                                        class="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                        <!-- End .product-details -->
                    </div>
                @endforeach
            </div>
            <!-- End .products-slider -->
        </div>

        {{-- <div class="product-widgets-container row pb-2">
            <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                <h4 class="section-sub-title">Sản phẩm nổi bật</h4>
                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Ultimate 3D Bluetooth Speaker</a>
                        </h3>

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
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>

                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Brown Women Casual HandBag</a> </h3>

                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:100%"></span>
                                <!-- End .ratings -->
                                <span class="tooltiptext tooltip-top">5.00</span>
                            </div>
                            <!-- End .product-ratings -->
                        </div>
                        <!-- End .product-container -->

                        <div class="price-box">
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>

                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Circled Ultimate 3D Speaker</a> </h3>

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
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                <h4 class="section-sub-title">Sản phẩm bán chạy nhất</h4>
                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Blue Backpack for the Young - S</a>
                        </h3>

                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:100%"></span>
                                <!-- End .ratings -->
                                <span class="tooltiptext tooltip-top">5.00</span>
                            </div>
                            <!-- End .product-ratings -->
                        </div>
                        <!-- End .product-container -->

                        <div class="price-box">
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>

                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Casual Spring Blue Shoes</a> </h3>

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
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>

                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Men Black Gentle Belt</a> </h3>

                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:100%"></span>
                                <!-- End .ratings -->
                                <span class="tooltiptext tooltip-top">5.00</span>
                            </div>
                            <!-- End .product-ratings -->
                        </div>
                        <!-- End .product-container -->

                        <div class="price-box">
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                <h4 class="section-sub-title">Latest Products</h4>
                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Brown-Black Men Casual Glasses</a>
                        </h3>

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
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>

                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Brown-Black Men Casual Glasses</a>
                        </h3>

                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:100%"></span>
                                <!-- End .ratings -->
                                <span class="tooltiptext tooltip-top">5.00</span>
                            </div>
                            <!-- End .product-ratings -->
                        </div>
                        <!-- End .product-container -->

                        <div class="price-box">
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>

                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Black Men Casual Glasses</a> </h3>

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
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                <h4 class="section-sub-title">Top Rated Products</h4>
                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Basketball Sports Blue Shoes</a> </h3>

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
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>

                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Men Sports Travel Bag</a> </h3>

                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:100%"></span>
                                <!-- End .ratings -->
                                <span class="tooltiptext tooltip-top">5.00</span>
                            </div>
                            <!-- End .product-ratings -->
                        </div>
                        <!-- End .product-container -->

                        <div class="price-box">
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>

                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74" alt="product">
                            <img src="" width="74" height="74" alt="product">
                        </a>
                    </figure>

                    <div class="product-details">
                        <h3 class="product-title"> <a href="product.html">Brown HandBag</a> </h3>

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
                            <span class="product-price">$49.00</span>
                        </div>
                        <!-- End .price-box -->
                    </div>
                    <!-- End .product-details -->
                </div>
            </div>
        </div> --}}
        <!-- End .row -->
    </div>
    <!-- End .container -->
@endsection

@push('scripts')
    <script>
        // Nhúng dữ liệu từ PHP vào JavaScript
        var variantData = <?php echo $variantDataJson; ?>;
        console.log(variantData);

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var countOptions = $('#product-filters').find($('.product-single-filter')).length - 1;

            // Lấy giá trị của input số lượng và min, max từ thuộc tính của input
            var $qtyInput = $('input[name="qty"]');
            var minQty = parseInt($qtyInput.attr('min'));
            var maxQty = parseInt($qtyInput.attr('max'));

            $qtyInput.on('change', function() {
                var currentQty = parseInt($qtyInput.val());
                if (currentQty < minQty) {
                    $qtyInput.val(minQty);
                } else if (currentQty > maxQty) {
                    $qtyInput.val(maxQty);
                }
            });

            // Chọn biến thể
            $(document).on('click', '.select-variant', function() {
                let selectedOptions = {};
                let currentOptions = $('#product-filters').find($('.product-single-filter a.selected'))
                    .length;
                if (countOptions === currentOptions) {
                    $('.product-single-filter a.selected').each(function() {
                        const attribute = $(this).data('attribute');
                        const value = $(this).data('value');
                        // Cập nhật vào đối tượng selectedOptions
                        selectedOptions[attribute] = value;
                    });
                    let idPrd = $('.product-single-filter a.selected').data('idproduct');
                    $.ajax({
                        url: "{{ route('product.get-qty-variant') }}",
                        method: 'POST',
                        data: {
                            product_id: idPrd,
                            variants: selectedOptions,
                        },
                        success: function(data) {

                            if (data.status === 'success') {

                                const formatCurrency = (value) => {
                                    return new Intl.NumberFormat('vi-VN', {
                                            style: 'decimal', // Không dùng currency để loại bỏ ký hiệu ₫
                                            minimumFractionDigits: 0
                                        }).format(value) +
                                        "{{ $generalSettings->currency_icon }}"; // Thêm ' VND' vào cuối
                                };
                                let priceText = '';

                                if (data.variant.variant_offer_start_date && data.variant
                                    .variant_offer_end_date) {
                                    let currentDate = new Date();
                                    let startDate = new Date(data.variant
                                        .variant_offer_start_date);
                                    let endDate = new Date(data.variant
                                        .variant_offer_end_date);

                                    if (startDate <= currentDate && currentDate <= endDate &&
                                        data.variant.offer_price_variant > 0) {
                                        priceText =
                                            `<span style="margin-right: 10px;">${formatCurrency(data.variant.offer_price_variant)}</span>`;
                                    } else {
                                        priceText =
                                            `<span>${formatCurrency(data.variant.price_variant)}</span>`;
                                    }
                                } else {
                                    priceText =
                                        `<span>${formatCurrency(data.variant.price_variant)}</span>`;
                                }

                                // if (data.variant.offer_price_variant > 0) {
                                //     // Thêm giá khuyến mãi bên cạnh
                                //     priceText =
                                //         `<span style="margin-right: 10px;">${formatCurrency(data.variant.offer_price_variant)}</span>`;
                                //     // priceText +=
                                //     //     `<span style="text-decoration: line-through red; color: black;">${formatCurrency(data.variant.price_variant)}</span> `;
                                // } else {
                                //     priceText =
                                //         `<span>${formatCurrency(data.variant.price_variant)}</span>`;
                                // }
                                $('.price-render').html(priceText);
                                $('.qty-product').text(data.variant.qty);
                                // Cập nhật thuộc tính max của input số lượng
                                $qtyInput.attr('max', data.variant.qty);
                                minQty = parseInt($qtyInput.attr('min'));
                                maxQty = parseInt($qtyInput.attr('max'));

                                // Nếu số lượng hiện tại lớn hơn số lượng tối đa mới, điều chỉnh lại giá trị
                                if (parseInt($qtyInput.val()) > data.qty) {
                                    $qtyInput.val(data.qty);
                                }
                            }
                        },
                        error: function(error) {

                        },
                    })
                }
            })

            // Xử lý sự kiện nhấp vào tùy chọn màu
            $('.color-options').click(function() {
                // Bỏ chọn tất cả các màu trước đó
                $('.color-options').removeClass('selected');

                $(this).addClass('selected');
                // Xóa các kích cỡ hiện tại
                var ulElement = $('.size-options').closest('.config-size-list');
                if (ulElement) {
                    var selectedColor = $(this).data('color'); // Lấy màu đã chọn
                    var availableSizes = variantData[
                        selectedColor]; // Lấy các kích cỡ tương ứng với màu đã chọn

                    ulElement.empty();

                    // Hiển thị các kích cỡ liên quan đến màu đã chọn
                    if (availableSizes) {
                        $.each(availableSizes, function(size, qty) {
                            var sizeLink = $(
                                '<li><a href="javascript:;" class="d-flex select-variant align-items-center justify-content-center size-options" data-size="' +
                                size + '" data-attribute="size" data-value="' + size +
                                '">' +
                                size + '</a></li>'
                            );
                            // Kiểm tra số lượng
                            if (qty <= 0) {
                                sizeLink.find('a').addClass('disabled').css('pointer-events',
                                    'none');;
                            }

                            ulElement.append(sizeLink);
                        });
                    }
                }
            });

            $('.color-options.default-selected').trigger('click');

            // // Xử lý sự kiện nhấp vào tùy chọn kích cỡ
            // $('.config-size-list').on('click', '.size-options', function() {
            //     var ulElement = $(this).closest('.config-size-list');
            //     ulElement.find('.size-options').removeClass('selected');
            //     ulElement.find('li').removeClass('active');

            //     $(this).addClass('selected');
            //     var liElement = $(this).closest('li');
            //     liElement.addClass('active');
            // });

            $('.config-size-list').on('click', 'a', function() {
                var ulElement = $(this).closest('.config-size-list');
                ulElement.find('a').removeClass('selected');
                ulElement.find('li').removeClass('active');
                var liElement = $(this).closest('li');
                liElement.addClass('active');
                $(this).addClass('selected');
            });

            // Xử lý sự kiện nhấp vào nút Clear
            $('.clear-btn').click(function() {
                $('.color-options').removeClass('selected'); // Xóa class selected nếu cần
                console.log("Filters cleared");
            });

            //product reviews
            // Hàm xử lý gửi form bình luận
            $('#reviewForm').on('submit', function(e) {
                e.preventDefault();
                let slug = $(this).data('slug');
                let rate = $('.rating-stars a.active').data('value');
                let formData = new FormData(this);
                formData.append('rate', rate);

                $.ajax({
                    url: "{{ route('reviews') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'success') {
                            getReviews(data.review.product_id, slug);
                            $('#text-review').remove();
                            toastr.success(data.message);
                            $('#reviewForm')[0].reset(); // Đặt lại giá trị của các input
                            $('.rating-stars a').removeClass('active');
                            $('.add-product-review').remove();
                        } else if (data.status == 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value);
                            })
                        }
                    }
                })
            })

            function getReviews(productId, slug) {

                $.ajax({
                    url: "{{ route('get-reviews') }}",
                    method: 'GET',
                    data: {
                        product_id: productId,
                    },
                    success: function(data) {
                        $('#reviewSection').html(data.updateHtmlReview);
                        $('#pagination-links a').each(function() {
                            var newUrl = $(this).attr('href').replace(
                                /reviews\?product_id=\d+&page=\d+/,
                                function(match) {
                                    return `product/detail/${$slug}?page=` +
                                        match.split('page=')[1];
                                });
                            $(this).attr('href', newUrl);
                        });
                        $('.count-review').text(data.total + ' Đánh giá')
                    },
                    error: function() {}
                })
            }

            // Cập nhật sự kiện click cho phân trang sau khi AJAX tải lại
            $(document).on('click', '#pagination-links a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#reviewSection').html(data);
                    }
                });
            });
        });
    </script>
@endpush
