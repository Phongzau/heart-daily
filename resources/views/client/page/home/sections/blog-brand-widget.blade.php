            <section class="blog-section pb-0">
                <div class="container">
                    <h2 class="section-title heading-border border-0 appear-animate" data-animation-name="fadeInUp">Latest
                        News</h2>

                    <div class="owl-carousel owl-theme appear-animate" data-animation-name="fadeIn"
                        data-owl-options="{
                        'loop': false,
                        'margin': 20,
                        'autoHeight': true,
                        'autoplay': false,
                        'dots': false,
                        'items': 2,
                        'responsive': {
                            '0': {
                                'items': 1
                            },
                            '480': {
                                'items': 2
                            },
                            '576': {
                                'items': 3
                            },
                            '768': {
                                'items': 4
                            }
                        }
                    }">
                        @foreach ($blogs as $blog)
                            <article class="post">
                                <div class="post-media">
                                    <a href="{{ route('blog-details', $blog->slug) }}">
                                        <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}">
                                    </a>
                                    <div class="post-date">
                                        <span class="day">{{ $blog->created_at->format('d') }}</span>
                                        <span class="month">{{ $blog->created_at->format('M') }}</span>
                                    </div>
                                </div>
                                <!-- End .post-media -->

                                <div class="post-body">
                                    <h2 class="post-title">
                                        <a href="{{ route('blog-details', $blog->slug) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h2>
                                    <div class="post-content">
                                        <p>{{ limitTextDescription($blog->description, 160) }}</p>
                                    </div>
                                    <!-- End .post-content -->

                                </div>
                                <!-- End .post-body -->
                            </article>
                            <!-- End .post -->
                        @endforeach
                    </div>
                    <hr class="mt-0 m-b-5">
                    <div class="brands-slider owl-carousel owl-theme images-center appear-animate"
                        data-animation-name="fadeIn" data-animation-duration="500"
                        data-owl-options="{
					'margin': 0}">
                        @foreach ($brands as $brand)
                            <img src="{{ asset('storage/' . $brand->image) }}" width="130" height="56"
                                alt="{{ $brand->name }}">
                        @endforeach


                    </div>
                    <!-- End .brands-slider -->

                    <hr class="mt-4 m-b-5">

                    <div class="product-widgets-container row pb-2">
                        <div class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate"
                            data-animation-name="fadeInLeftShorter" data-animation-delay="200">
                            <h4 class="section-sub-title">Featured Products</h4>
                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="" width="84" height="84" alt="product">
                                        <img src="" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Ultimate 3D Bluetooth
                                            Speaker</a>
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
                                        <img src="" width="84" height="84" alt="product">
                                        <img src="" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Brown Women Casual HandBag</a>
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
                                        <img src="" width="84" height="84" alt="product">
                                        <img src="" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Circled Ultimate 3D
                                            Speaker</a>
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
                        </div>

                        <div class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate"
                            data-animation-name="fadeInLeftShorter" data-animation-delay="500">
                            <h4 class="section-sub-title">Best Selling Products</h4>
                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="" width="84" height="84" alt="product">
                                        <img src="" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Blue Backpack for the Young -
                                            S</a> </h3>

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
                                        <img src="" width="84" height="84" alt="product">
                                        <img src="" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Casual Spring Blue Shoes</a>
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
                                        <img src="" width="84" height="84" alt="product">
                                        <img src="" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Men Black Gentle Belt</a>
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
                        </div>

                        <div class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate"
                            data-animation-name="fadeInLeftShorter" data-animation-delay="800">
                            <h4 class="section-sub-title">Latest Products</h4>
                            @foreach ($products->take(3) as $product)
                                <div class="product-default left-details product-widget">
                                    <figure>
                                        <a href="product.html">
                                            <img src="{{ asset('storage/' . $product->image) }}" width="84"
                                                height="84" alt="{{ $product->name }}">
                                        </a>
                                    </figure>

                                    <div class="product-details">
                                        <h3 class="product-title"> <a href="product.html">{{ $product->name }}</a>
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
                                            @if ($product->offer_price)
                                                <span class="product-price">{{ number_format($product->offer_price) }}
                                                    VND</span>
                                            @else
                                                <span class="product-price">{{ number_format($product->price) }}
                                                    VND</span>
                                            @endif
                                        </div>
                                        <!-- End .price-box -->
                                    </div>
                                    <!-- End .product-details -->
                                </div>
                            @endforeach

                        </div>

                        <div class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate"
                            data-animation-name="fadeInLeftShorter" data-animation-delay="1100">
                            <h4 class="section-sub-title">Top Rated Products</h4>
                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="" width="84" height="84" alt="product">
                                        <img src="" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Basketball Sports Blue
                                            Shoes</a>
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
                                        <img src="" width="84" height="84" alt="product">
                                        <img src="" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Men Sports Travel Bag</a>
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
                                        <img src="" width="84" height="84" alt="product">
                                        <img src="" width="84" height="84" alt="product">
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
                    </div>
                    <!-- End .row -->

                    <div class="owl-carousel owl-theme appear-animate" data-animation-name="fadeIn"
                        data-owl-options="{
                        'loop': false,
                        'margin': 20,
                        'autoHeight': true,
                        'autoplay': false,
                        'dots': false,
                        'items': 2,
                        'responsive': {
                            '0': {
                                'items': 1
                            },
                            '480': {
                                'items': 2
                            },
                            '576': {
                                'items': 3
                            },
                            '768': {
                                'items': 4
                            }
                        }
                    }">
                        @foreach ($blogs as $blog)
                        <article class="post">
                            <div class="post-media">
                                <a href="{{ route('blog-details', $blog->slug) }}">
                                    <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}">
                                </a>
                                <div class="post-date">
                                    <span class="day">{{ $blog->created_at->format('d') }}</span>
                                    <span class="month">{{ $blog->created_at->format('M') }}</span>
                                </div>
                            </div>
                            <!-- End .post-media -->

                            <div class="post-body">
                                <h2 class="post-title">
                                    <a href="{{ route('blog-details', $blog->slug) }}">
                                        {{ $blog->title }}
                                    </a>
                                </h2>
                                <div class="post-content">
                                    <p>{{ limitTextDescription($blog->description, 160) }}</p>
                                </div>
                                <!-- End .post-content -->

                            </div>
                            <!-- End .post-body -->
                        </article>
                        <!-- End .post -->
                        @endforeach
                    </div>
                </div>
            </section>
