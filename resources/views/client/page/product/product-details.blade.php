@extends('layouts.client')

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
                <li class="breadcrumb-item"><a href="demo4.html"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
            </ol>
        </nav>

        <div class="product-single-container product-single-default">
            <div class="cart-message d-none">
                <strong class="single-cart-notice">“Men Black Sports Shoes”</strong>
                <span>has been added to your cart.</span>
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

                    <div class="product-nav">
                        <div class="product-prev">
                            <a href="#">
                                <span class="product-link"></span>

                                <span class="product-popup">
                                    <span class="box-content">
                                        <img alt="product" width="150" height="150"
                                            src="{{ asset('frontend/assets/images/products/product-3.jpg') }}"
                                            style="padding-top: 0px;">

                                        <span>Circled Ultimate 3D Speaker</span>
                                    </span>
                                </span>
                            </a>
                        </div>

                        <div class="product-next">
                            <a href="#">
                                <span class="product-link"></span>

                                <span class="product-popup">
                                    <span class="box-content">
                                        <img alt="product" width="150" height="150"
                                            src="{{ asset('frontend/assets/images/products/product-4.jpg') }}"
                                            style="padding-top: 0px;">

                                        <span>Blue Backpack for the Young</span>
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="ratings-container">
                        <div class="product-ratings">
                            <span class="ratings" style="width:60%"></span>
                            <!-- End .ratings -->
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <!-- End .product-ratings -->

                        <a href="#" class="rating-link">( 6 Reviews )</a>
                    </div>
                    <!-- End .ratings-container -->

                    <hr class="short-divider">

                    @if (checkDiscount($product))
                        <div class="price-box">
                            <span class="old-price">{{ number_format($product->price) }}</span>
                            <span class="product-price"><del>{{ number_format($product->offer_price) }}</del> VND</span>
                        </div>
                    @else
                        <div class="price-box">
                            <span class="product-price">{{ number_format($product->price) }} VND</span>
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
                            SKU:
                            <strong>{{ $product->sku }}</strong>
                        </li>

                        <li>
                            CATEGORY:
                            <strong>
                                <a href="#" class="product-category">{{ $product->category->title }}</a>
                            </strong>
                        </li>

                        {{-- <li>
                            TAGs:
                            <strong><a href="#" class="product-category">CLOTHES</a></strong>,
                            <strong><a href="#" class="product-category">SWEATER</a></strong>
                        </li> --}}
                    </ul>
                    <div class="product-filters-container">
                        @php
                            // Sắp xếp các nhóm thuộc tính để color trước size
                            $orderedKeys = ['Color', 'Size'];
                        @endphp

                        @foreach ($orderedKeys as $key)
                            @if (array_key_exists($key, $variantGroups))
                                <div class="product-single-filter">
                                    <label>{{ strtolower($key) }}</label>
                                    <ul class="config-size-list">
                                        @foreach ($variantGroups[$key] as $index => $item)
                                            <li>
                                                <a href="javascript:;"
                                                    class="d-flex align-items-center justify-content-center {{ strtolower($key) }}-options {{ $key === 'Color' && $index === 0 ? 'default-selected' : '' }}"
                                                    data-{{ strtolower($key) }}="{{ $item }}"
                                                    data-attribute="{{ strtolower($key) }}"
                                                    data-value="{{ $item }}">{{ $item }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
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
                                <input class="horizontal-quantity form-control" name="qty" type="text">
                                <input type="text" hidden name="product_id" value="{{ $product->id }}">
                            </div>
                            <!-- End .product-single-qty -->

                            <button type="submit" class="btn btn-dark mr-2" title="Add to Cart"><i
                                    class="fas fa-cart-plus mr-2"></i>Add to
                                Cart</button>

                            <a href="cart.html" class="btn btn-gray view-cart d-none">View cart</a>
                        </div>
                    </form>
                    <!-- End .product-action -->

                    <hr class="divider mb-0 mt-0">

                    <div class="product-single-share mb-2">
                        <label class="sr-only">Share:</label>

                        <div class="social-icons mr-2">
                            <a href="#" class="social-icon social-facebook icon-facebook" target="_blank"
                                title="Facebook"></a>
                            <a href="#" class="social-icon social-twitter icon-twitter" target="_blank"
                                title="Twitter"></a>
                            <a href="#" class="social-icon social-linkedin fab fa-linkedin-in" target="_blank"
                                title="Linkedin"></a>
                            <a href="#" class="social-icon social-gplus fab fa-google-plus-g" target="_blank"
                                title="Google +"></a>
                            <a href="#" class="social-icon social-mail icon-mail-alt" target="_blank"
                                title="Mail"></a>
                        </div>
                        <!-- End .social-icons -->

                        <a href="wishlist.html" class="btn-icon-wish add-wishlist" title="Add to Wishlist"><i
                                class="icon-wishlist-2"></i><span>Add to
                                Wishlist</span></a>

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
                        role="tab" aria-controls="product-desc-content" aria-selected="true">Description</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="product-tab-tags" data-toggle="tab" href="#product-tags-content"
                        role="tab" aria-controls="product-tags-content" aria-selected="false">Additional
                        Information</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content"
                        role="tab" aria-controls="product-reviews-content" aria-selected="false">Reviews (1)</a>
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
                        <h3 class="reviews-title">1 review for Men Black Sports Shoes</h3>

                        <div class="comment-list">
                            <div class="comments">
                                <figure class="img-thumbnail">
                                    <img src="{{ asset('frontend/assets/images/blog/author.jpg') }}" alt="author"
                                        width="80" height="80">
                                </figure>

                                <div class="comment-block">
                                    <div class="comment-header">
                                        <div class="comment-arrow"></div>

                                        <div class="ratings-container float-sm-right">
                                            <div class="product-ratings">
                                                <span class="ratings" style="width:60%"></span>
                                                <!-- End .ratings -->
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <!-- End .product-ratings -->
                                        </div>

                                        <span class="comment-by">
                                            <strong>Joe Doe</strong> – April 12, 2018
                                        </span>
                                    </div>

                                    <div class="comment-content">
                                        <p>Excellent.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="add-product-review">
                            <h3 class="review-title">Add a review</h3>

                            <form action="#" class="comment-form m-0">
                                <div class="rating-form">
                                    <label for="rating">Your rating <span class="required">*</span></label>
                                    <span class="rating-stars">
                                        <a class="star-1" href="#">1</a>
                                        <a class="star-2" href="#">2</a>
                                        <a class="star-3" href="#">3</a>
                                        <a class="star-4" href="#">4</a>
                                        <a class="star-5" href="#">5</a>
                                    </span>

                                    <select name="rating" id="rating" required="" style="display: none;">
                                        <option value="">Rate…</option>
                                        <option value="5">Perfect</option>
                                        <option value="4">Good</option>
                                        <option value="3">Average</option>
                                        <option value="2">Not that bad</option>
                                        <option value="1">Very poor</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Your review <span class="required">*</span></label>
                                    <textarea cols="5" rows="6" class="form-control form-control-sm"></textarea>
                                </div>
                                <!-- End .form-group -->


                                <div class="row">
                                    <div class="col-md-6 col-xl-12">
                                        <div class="form-group">
                                            <label>Name <span class="required">*</span></label>
                                            <input type="text" class="form-control form-control-sm" required>
                                        </div>
                                        <!-- End .form-group -->
                                    </div>

                                    <div class="col-md-6 col-xl-12">
                                        <div class="form-group">
                                            <label>Email <span class="required">*</span></label>
                                            <input type="text" class="form-control form-control-sm" required>
                                        </div>
                                        <!-- End .form-group -->
                                    </div>

                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="save-name" />
                                            <label class="custom-control-label mb-0" for="save-name">Save my
                                                name, email, and website in this browser for the next time I
                                                comment.</label>
                                        </div>
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-primary" value="Submit">
                            </form>
                        </div>
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
            <h2 class="section-title">Related Products</h2>

            <div class="products-slider owl-carousel owl-theme dots-top dots-small">
                @foreach ($productRelated as $product)
                    <div class="product-default">
                        <figure>
                            <a href="product.html">
                                <img src="{{ Storage::url($product->image) }}" width="280" height="280"
                                    alt="product">
                                <img src="
                                @if (isset($product->ProductImageGalleries[0]->image)) {{ Storage::url($product->ProductImageGalleries[0]->image) }}
                                @else
                                {{ Storage::url($product->image) }} @endif
                                "
                                    width="280" height="280" alt="product">
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
                                <a href="product.html">{{ $product->name }}</a>
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
                            @if (checkDiscount($product))
                                <div class="price-box">
                                    <del class="old-price">{{ number_format($product->price) }} VND</del>
                                    <span class="product-price">{{ number_format($product->offer) }} VND</span>
                                </div>
                            @else
                                <div class="price-box">
                                    <span class="product-price">{{ number_format($product->price) }} VND</span>
                                </div>
                            @endif

                            <!-- End .price-box -->
                            <div class="product-action">
                                <a href="#" data-productid="{{ $product->id }}"
                                    class="btn-icon-wish {{ Auth::user()->wishlist()->where('product_id', $product->id)->exists()? 'added-wishlist': '' }}"
                                    title="wishlist"><i class="icon-heart"></i></a>
                                <a href="product.html" class="btn-icon btn-add-cart"><i
                                        class="fa fa-arrow-right"></i><span>SELECT
                                        OPTIONS</span></a>
                                <a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View"><i
                                        class="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                        <!-- End .product-details -->
                    </div>
                @endforeach
            </div>
            <!-- End .products-slider -->
        </div>
        <!-- End .products-section -->

        {{-- <hr class="mt-0 m-b-5" />

        <div class="product-widgets-container row pb-2">
            <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                <h4 class="section-sub-title">Featured Products</h4>
                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                <h4 class="section-sub-title">Best Selling Products</h4>
                <div class="product-default left-details product-widget">
                    <figure>
                        <a href="product.html">
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                            <img src="" width="74" height="74"
                                alt="product">
                            <img src="" width="74" height="74"
                                alt="product">
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
                                '<li><a href="javascript:;" class="d-flex align-items-center justify-content-center size-options" data-size="' +
                                size + '" data-attribute="size" data-value="' + size + '">' +
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

            // Xử lý sự kiện nhấp vào tùy chọn kích cỡ
            $('.config-size-list').on('click', '.size-options', function() {
                var ulElement = $(this).closest('.config-size-list');
                ulElement.find('.size-options').removeClass('selected');
                ulElement.find('li').removeClass('active');

                $(this).addClass('selected');
                var liElement = $(this).closest('li');
                liElement.addClass('active');
            });


            // Xử lý sự kiện nhấp vào nút Clear
            $('.clear-btn').click(function() {
                $('.color-options').removeClass('selected'); // Xóa class selected nếu cần
                console.log("Filters cleared");
            });

            function checkSelectOptions() {
                let totalFilter = $('.product-single-filter').length - 1;
                let selectedCount = $('.product-single-filter a.selected').length;

                return totalFilter === selectedCount;
            }

            $('#add-to-cart').on('submit', function(e) {
                e.preventDefault();

                if (!checkSelectOptions()) {
                    toastr.error('Vui lòng chọn biến thể sản phẩm');
                    return false;
                }

                // Đối tượng để lưu trữ các tùy chọn đã chọn
                let selectedOptions = {};

                // Lấy tất cả các tùy chọn đã chọn
                $('.product-single-filter a.selected').each(function() {
                    const attribute = $(this).data('attribute'); // Lấy tên thuộc tính (color, size)
                    const value = $(this).data('value'); // Lấy giá trị của thuộc tính

                    // Cập nhật vào đối tượng selectedOptions
                    selectedOptions[attribute] = value;
                });

                let formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('add-to-cart') }}",
                    method: 'POST',
                    data: {
                        formData: formData,
                        variants: selectedOptions,
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            toastr.success(data.message);
                        } else if (data.status === 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {

                    },
                })


                // In ra kết quả
                console.log(selectedOptions);
            })
        });
    </script>
@endpush
