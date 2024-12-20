@extends('layouts.client')
@section('title')
    {{ $generalSettings->site_name }} || Danh mục sản phẩm
@endsection
@section('css')
    <style>
        .cat-list li.active a .span,
        .brand-list li.active a {
            color: #2299dd;
        }

        .size-list li.active a {
            border-color: #08C;
            background-color: #2299dd;
            color: #fff;
            text-decoration: none;
        }
    </style>
@endsection
@php
    $product_page_banner_section = \App\Models\Advertisement::query()
        ->where('key', 'product_page_banner_section')
        ->first();
    $product_page_banner_section = json_decode($product_page_banner_section?->value);
    function renderCategoryTree($categories)
    {
        echo '<ul class="cat-list category-list">';
        foreach ($categories as $category) {
            echo '<li id="category-' . $category->id . '">';
            $hasChildren = $category->children->isNotEmpty();
            echo '<a href="#widget-category-' .
                $category->id .
                '" class="' .
                ($hasChildren ? 'collapsed' : '') .
                '" ' .
                ($hasChildren
                    ? 'data-toggle="collapse" role="button" aria-expanded="false" aria-controls="widget-category-' .
                        $category->id .
                        '"'
                    : '') .
                '>';

            echo '<span class="span" onclick="setFilter(\'category\', ' .
                $category->id .
                '); return false;">' .
                $category->title .
                '</span>';
            if ($hasChildren) {
                echo '<span class="toggle"></span>';
            }
            echo '</a>';
            echo '</li>';
            if ($category->children->isNotEmpty()) {
                echo '<div class="collapse" id="widget-category-' . $category->id . '">';
                echo '<ul class="cat-sublist category-list">';
                renderCategoryTree($category->children);
                echo '</ul>';
                echo '</div>';
            }
        }
        echo '</ul>';
    }
@endphp
@section('section')

        <div style="margin: 0px;
    padding: 0px;" class="category-banner banner text-uppercase">
            @if (isset($product_page_banner_section->banner_one) && $product_page_banner_section->banner_one->status)
                <div class="banner banner1 banner-sm-vw d-flex align-items-center appear-animate"
                    data-animation-name="fadeInLeftShorter" data-animation-delay="500">
                    <figure class="w-100">
                        <img src="{{ Storage::url($product_page_banner_section->banner_one->banner_image) }}" alt="Banner One"
                        style="max-height: 300px; max-width: 100%; height: auto; object-fit: cover;" />
                    </figure>
                    <div class="banner-layer">
                        <a href="{{ $product_page_banner_section->banner_one->banner_url }}" target="_blank">
                        </a>
                    </div>
                </div>
            @endif
        </div>


    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
                {{-- <li class="breadcrumb-item active" aria-current="page">Phụ kiện</li> --}}
            </ol>
        </nav>

        <nav class="toolbox sticky-header horizontal-filter mb-1" data-sticky-options="{'mobile': true}">
            <div class="toolbox-left">
                <a href="#" class="sidebar-toggle"><svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32"
                        xmlns="http://www.w3.org/2000/svg">
                        <line x1="15" x2="26" y1="9" y2="9" class="cls-1"></line>
                        <line x1="6" x2="9" y1="9" y2="9" class="cls-1"></line>
                        <line x1="23" x2="26" y1="16" y2="16" class="cls-1"></line>
                        <line x1="6" x2="17" y1="16" y2="16" class="cls-1"></line>
                        <line x1="17" x2="26" y1="23" y2="23" class="cls-1"></line>
                        <line x1="6" x2="11" y1="23" y2="23" class="cls-1"></line>
                        <path d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z" class="cls-2">
                        </path>
                        <path d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                        <path d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z" class="cls-3"></path>
                        <path d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z"
                            class="cls-2"></path>
                    </svg>
                    <span>Lọc</span>
                </a>

                <div class="toolbox-item filter-toggle d-none d-lg-flex">
                    <span>Lọc:</span>
                    <a href=#>&nbsp;</a>
                </div>
            </div>
            <!-- End .toolbox-left -->

            <div class="toolbox-item toolbox-sort ml-lg-auto">
                <label>Sắp xếp theo:</label>

                <div class="select-custom">
                    <select name="orderby" class="form-control" id="sort-by" onchange="loadProducts();">
                        <option value="menu_order" selected="selected">Mặc định</option>
                        <option value="date">Sản phẩm mới</option>
                        <option value="price">Giá: thấp đến cao</option>
                        <option value="price-desc">Giá: cao đến thấp</option>
                    </select>
                </div>
                <!-- End .select-custom -->
            </div>
            <!-- End .toolbox-item -->

            <div class="toolbox-item toolbox-show">
                <label>Xem:</label>
                <div class="select-custom">
                    <select name="count" class="form-control" id="product-count" onchange="loadProducts();">
                        <option value="12" {{ request('count') == 12 ? 'selected' : '' }}>12</option>
                        <option value="24" {{ request('count') == 24 ? 'selected' : '' }}>24</option>
                        <option value="36" {{ request('count') == 36 ? 'selected' : '' }}>36</option>
                    </select>
                </div>
            </div>
            <!-- End .toolbox-item -->
        </nav>

        <div class="row main-content-wrap">
            <div class="col-lg-9 main-content">

                <div class="row" id="product-list">
                    @include('client.page.product.product_list', ['products' => $products])
                </div>
                <!-- End .row -->
                <nav class="toolbox toolbox-pagination">
                    <div class="toolbox-item toolbox-show"></div>
                    <ul class="pagination toolbox-item" id="pagination-links">
                        {{ $products->links() }}
                    </ul>
                </nav>
            </div>
            <!-- End .col-lg-9 -->

            <div class="sidebar-overlay"></div>
            <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                <div class="sidebar-wrapper">
                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="false"
                                aria-controls="widget-body-2" class="collapsed">Danh Mục</a>
                        </h3>

                        <div class="collapse" id="widget-body-2">
                            <div class="widget-body">

                                @php
                                    renderCategoryTree($categories);
                                @endphp
                            </div>
                            <!-- End .widget-body -->

                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="false"
                                aria-controls="widget-body-3" class="collapsed">Thương hiệu</a>
                        </h3>

                        <div class="collapse" id="widget-body-3">
                            <div class="widget-body">
                                <ul class="cat-list brand-list">
                                    @foreach ($brands as $brand)
                                        <li id="brand-{{ $brand->id }}">
                                            <a href="#"
                                                onclick="setFilter('brand', {{ $brand->id }}); return false;">
                                                {{ $brand->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End .widget-body -->

                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-5" role="button" aria-expanded="false"
                                aria-controls="widget-body-5" class="collapsed">Khoảng Giá</a>
                        </h3>

                        <div class="collapse" id="widget-body-5">
                            <div class="widget-body pb-0">
                                <form id="price-filter-form" action="#" method="GET">
                                    <div class="shopee-price-range-filter__inputs">
                                        {{-- <div id="price-slider"></div> --}}
                                        <input type="number" class="shopee-price-range-filter__input" id="min-price"
                                            name="min_price" maxlength="13" placeholder="₫ TỪ" step="1000"
                                            min="0">
                                        <div class="shopee-price-range-filter__range-line"></div>
                                        <input type="number" class="shopee-price-range-filter__input" id="max-price"
                                            name="max_price" maxlength="13" placeholder="₫ ĐẾN" step="1000"
                                            min="1000000000">
                                        <!-- End #price-slider -->
                                    </div>
                                    <!-- End .price-slider-wrapper -->

                                    <div
                                        class="filter-price-action d-flex align-items-center justify-content-between flex-wrap">
                                        {{-- <div class="filter-price-text">
                                            Giá:
                                            <span id="filter-price-range"></span>
                                        </div> --}}
                                        <!-- End .filter-price-text -->

                                        <button type="button" style="width: 100%" class="btn btn-primary"
                                            onclick="applyPriceFilter()">Áp dụng</button>
                                    </div>
                                    <!-- End .filter-price-action -->
                                </form>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                    <div class="widget widget-color">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-4" role="button" aria-expanded="false"
                                aria-controls="widget-body-4" class="collapsed">MÀU</a>
                        </h3>

                        <div class="collapse" id="widget-body-4">
                            <div class="widget-body pb-0">
                                <ul class="config-swatch-list color-list">
                                    @foreach ($colors as $color)
                                        <li id="color-{{ $color->id }}">
                                            <a href="#" style="background-color: {{ $color->code }};"
                                                onclick="setFilter('color', {{ $color->id }}); return false;">

                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                    <div class="widget widget-size">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-6" role="button" aria-expanded="false"
                                aria-controls="widget-body-6" class="collapsed">Kích cỡ</a>
                        </h3>

                        <div class="collapse" id="widget-body-6">
                            <div class="widget-body pb-0">
                                <ul class="config-size-list size-list">
                                    @foreach ($sizes as $size)
                                        <li id="size-{{ $size->id }}">
                                            <a href="#"
                                                onclick="setFilter('size', {{ $size->id }}); return false;">
                                                {{ $size->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                </div>
                <!-- End .sidebar-wrapper -->

            </aside>
            <!-- End .col-lg-3 -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->

    <div class="mb-4"></div>
    <!-- margin -->

    <script>
        let filters = {
            category: null,
            brand: null,
            color: null,
            size: null,
            min_price: 0,
            max_price: 1000000000,
            search: ''
        };

        function setFilter(type, value) {
            if (filters[type] === value) {
                filters[type] = null;
                document.getElementById(`${type}-${value}`).classList.remove('active');
            } else {
                filters[type] = value;

                document.querySelectorAll(`.${type}-list li`).forEach(el => {
                    el.classList.remove('active');
                });

                document.getElementById(`${type}-${value}`).classList.add('active');
            }

            loadProducts();
        }

        function applyPriceFilter() {
            const minPrice = document.getElementById('min-price').value;
            const maxPrice = document.getElementById('max-price').value;

            filters.min_price = minPrice;
            filters.max_price = maxPrice;

            loadProducts();
        }

        //show
        function loadProducts(page = 1) {
            const count = document.getElementById('product-count').value;
            const orderby = document.querySelector('select[name="orderby"]').value;
            const searchParam = new URLSearchParams(window.location.search).get('search') || filters.search;
            const query = new URLSearchParams({
                count: count,
                orderby: orderby,
                page: page,
                category: filters.category || '',
                brand: filters.brand || '',
                color: filters.color || '',
                size: filters.size || '',
                min_price: filters.min_price,
                max_price: filters.max_price,
                search: searchParam
            });


            fetch(`{{ route('product.ajaxGetProducts') }}?${query.toString()}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);

                    const productList = document.getElementById('product-list');
                    let html = ''

                    data.products.data.forEach(product => {
                        let totalRate = 0;
                        product.reviews.forEach(review => {
                            totalRate += review.rate;
                        })
                        let ratings = totalRate / product.reviews.length;
                        let ratingWidth = (ratings / 5) * 100;
                        console.log(ratingWidth);
                        if (isNaN(ratingWidth)) {
                            ratingWidth = 0;
                        }
                        const brandName = product.brand ? product.brand.name : ' ';
                        const currentDate = new Date().toISOString().split('T')[0];
                        const hasDiscount = product.offer_price > 0 && currentDate >= product
                            .offer_start_date && currentDate <= product.offer_end_date;
                        const productDetailUrl = "{{ url('product/detail') }}/" + product.slug;
                        const wishlistProductIds = data.wishlistProductIds;
                        const isInWishlist = wishlistProductIds.includes(product.id) ? 'added-wishlist' : '';
                        const typeProduct = product.type_product == 'product_simple' ? 1 : 0;

                        html += `
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="product-default">
                            <figure height="220">
                                <a href="${productDetailUrl}">
                                    <img src="{{ asset('storage') }}/${product.image}" class="product-image" alt="${product.name}" />
                                </a>
                                <div class="label-group">
                                    <div class="product-label label-hot">HOT</div>

                                    ${hasDiscount  ? `
                                                <div class="product-label label-sale">
                                                    -${Math.round(((product.price - product.offer_price) / product.price) * 100)}%
                                                </div>
                                                ` : ''}
                                </div>
                            </figure>
                            <div class="product-details">
                                <div class="category-wrap">
                                    <div class="category-list">
                                        <a href="${productDetailUrl}" class="product-category">${brandName}</a>
                                    </div>
                                </div>
                                <h3 class="product-title"><a href="${productDetailUrl}">${product.name}</a></h3>
                                <div class="ratings-container">
                    <div class="product-ratings">
                        <span class="ratings" style="width: ${ratingWidth}%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                    </div>
                </div>
                    <div class="price-box">
                        ${hasDiscount  ? `
                                            <span class="old-price">${new Intl.NumberFormat().format(product.price)}</span>
                                            <span class="product-price">${new Intl.NumberFormat().format(product.offer_price)}{{ $generalSettings->currency_icon }}</span>
                                            ` : `
                                            <span class="product-price">${new Intl.NumberFormat().format(product.price)}{{ $generalSettings->currency_icon }}</span>
                                            `}
                    </div>
                    <div class="product-action">
                        <a href="javascript:void(0)" data-productid="${product.id}" class="btn-icon-wish ${isInWishlist}" title="wishlist"><i class="icon-heart"></i></a>
                        ${typeProduct ? `
                            <form class="shopping-cart-form">
                                <input name="qty" hidden value="1" type="number">
                                <input type="text" hidden name="product_id" value="${product.id}">
                                <button type="submit"
                                class="btn-icon add-to-cart-simple btn-add-cart product-type-simple"><i
                                class="icon-shopping-cart"></i><span>THÊM VÀO GIỎ</span></button>
                            </form>` : `<a href="${productDetailUrl}" class="btn-icon btn-add-cart"><i class="fa fa-arrow-right"></i><span>LỰA CHỌN LOẠI'</span></a>`}

                        <a href="ajax/product-quick-view.html" class="btn-quickview2" title="Quick View"><i class="fas fa-external-link-alt"></i></a>
                    </div>
                </div>
                </div>
                </div>
                `;
                    });

                    productList.innerHTML = html;

                    updatePagination(data.products);
                })
                .catch(error => console.error('Error loading products:', error));
        }

        function updatePagination(products) {
            const paginationLinks = document.getElementById('pagination-links');
            let paginationHtml = '';

            if (products.current_page > 1) {
                paginationHtml +=
                    `<li class="page-item"><a class="page-link" href="#" onclick="loadProducts(${products.current_page - 1})">Previous</a></li>`;
            }

            for (let i = 1; i <= products.last_page; i++) {
                paginationHtml +=
                    `<li class="page-item ${i === products.current_page ? 'active' : ''}"><a class="page-link" href="#" onclick="loadProducts(${i})">${i}</a></li>`;
            }

            if (products.current_page < products.last_page) {
                paginationHtml +=
                    `<li class="page-item"><a class="page-link" href="#" onclick="loadProducts(${products.current_page + 1})">Next</a></li>`;
            }

            paginationLinks.innerHTML = paginationHtml;
        }

        function loadPage(page) {
            loadProducts(page);
        }
    </script>
@endsection
