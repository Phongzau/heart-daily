@extends('layouts.client')
@section('title')
    Danh mục sản phẩm
@endsection
@section('section')
    <div class="category-banner-container bg-gray">
        <div class="category-banner banner text-uppercase"
            style="background: no-repeat 60%/cover url({{ asset('frontend/assets/images/banners/banner-top.jpg') }});">
            <div class="container position-relative">
                <div class="row">
                    <div class="pl-lg-5 pb-5 pb-md-0 col-md-5 col-xl-4 col-lg-4 offset-1">
                        <h3>Electronic<br>Deals</h3>
                        <a href="#" class="btn btn-dark">Get Yours!</a>
                    </div>
                    <div class="pl-lg-3 col-md-4 offset-md-0 offset-1 pt-3">
                        <div class="coupon-sale-content">
                            <h4 class="m-b-1 coupon-sale-text bg-white text-transform-none">Exclusive COUPON
                            </h4>
                            <h5 class="mb-2 coupon-sale-text d-block ls-10 p-0"><i class="ls-0">UP TO</i><b
                                    class="text-dark">$100</b> OFF</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Product</a></li>
                {{-- <li class="breadcrumb-item active" aria-current="page">Accessories</li> --}}
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
                    <span>Filter</span>
                </a>

                <div class="toolbox-item filter-toggle d-none d-lg-flex">
                    <span>Filters:</span>
                    <a href=#>&nbsp;</a>
                </div>
            </div>
            <!-- End .toolbox-left -->

            <div class="toolbox-item toolbox-sort ml-lg-auto">
                <label>Sort By:</label>

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
                <label>Show:</label>
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
                            <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true"
                                aria-controls="widget-body-2">Danh Mục</a>
                        </h3>

                        <div class="collapse show" id="widget-body-2">
                            <div class="widget-body">
                                <ul class="cat-list">
                                    @foreach ($categories as $category)
                                        <li id="category-{{ $category->id }}">
                                            <a href="#"
                                                onclick="setFilter('category', {{ $category->id }}); return false;">
                                                {{ $category->title }}
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
                            <a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="true"
                                aria-controls="widget-body-3">Brand</a>
                        </h3>

                        <div class="collapse show" id="widget-body-3">
                            <div class="widget-body">
                                <ul class="cat-list">
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
                            <a data-toggle="collapse" href="#widget-body-5" role="button" aria-expanded="true"
                                aria-controls="widget-body-5">Khoảng Giá</a>
                        </h3>

                        <div class="collapse show" id="widget-body-5">
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
                                            Price:
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
                            <a data-toggle="collapse" href="#widget-body-4" role="button" aria-expanded="true"
                                aria-controls="widget-body-4">Color</a>
                        </h3>

                        <div class="collapse show" id="widget-body-4">
                            <div class="widget-body pb-0">
                                <ul class="config-swatch-list">
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
                            <a data-toggle="collapse" href="#widget-body-6" role="button" aria-expanded="true"
                                aria-controls="widget-body-6">Sizes</a>
                        </h3>

                        <div class="collapse show" id="widget-body-6">
                            <div class="widget-body pb-0">
                                <ul class="config-size-list">
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
            max_price: 1000000000
        };

        function setFilter(type, value) {
            if (filters[type] === value) {
                filters[type] = null; // Bỏ chọn bộ lọc
                document.getElementById(`${type}-${value}`).classList.remove('active'); // Xóa class "active"
            } else {
                filters[type] = value;

                if (type === 'category') {
                    document.querySelectorAll('.cat-list a').forEach(el => el.classList.remove('active'));
                    document.getElementById(`category-${value}`).classList.add('active');
                }
                if (type === 'brand') {
                    document.querySelectorAll('.brand-list a').forEach(el => el.classList.remove('active'));
                    document.getElementById(`brand-${value}`).classList.add('active');
                }
                if (type === 'color') {
                    document.querySelectorAll('.color-list a').forEach(el => el.classList.remove('active'));
                    document.getElementById(`color-${value}`).classList.add('active');
                }
                if (type === 'size') {
                    document.querySelectorAll('.size-list a').forEach(el => el.classList.remove('active'));
                    document.getElementById(`size-${value}`).classList.add('active');
                }
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
            const query = new URLSearchParams({
                count: count,
                orderby: orderby,
                page: page,
                category: filters.category || '',
                brand: filters.brand || '',
                color: filters.color || '',
                size: filters.size || '',
                min_price: filters.min_price,
                max_price: filters.max_price
            });
            fetch(`{{ route('product.ajaxGetProducts') }}?count=${count}&${query.toString()}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const productList = document.getElementById('product-list');
                    let html = ''

                    data.products.data.forEach(product => {
                        const brandName = product.brand ? product.brand.name : ' ';
                        const currentDate = new Date().toISOString().split('T')[0];
                        const hasDiscount = product.offer_price > 0 && currentDate >= product
                            .offer_start_date && currentDate <= product.offer_end_date;
                        const productDetailUrl = "{{ url('product') }}/" + product.slug;
                        const wishlistProductIds = data.wishlistProductIds;
                        const isInWishlist = wishlistProductIds.includes(product.id) ? 'added-wishlist' : '';
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
                        <span class="ratings" style="width:100%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                    </div>
                </div>
                    <div class="price-box">
                        ${hasDiscount  ? `
                        <span class="old-price">${new Intl.NumberFormat().format(product.price)}</span>
                        <span class="product-price">${new Intl.NumberFormat().format(product.offer_price)} VND</span>
                        ` : `
                        <span class="product-price">${new Intl.NumberFormat().format(product.price)} VND</span>
                        `}
                    </div>
                    <div class="product-action">
                        <a href="javascript:void(0)" data-productid="${product.id}" class="btn-icon-wish ${isInWishlist}" title="wishlist"><i class="icon-heart"></i></a>
                        <a href="${productDetailUrl}" class="btn-icon btn-add-cart"><i class="fa fa-arrow-right"></i><span>SELECT OPTIONS</span></a>
                        <a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View"><i class="fas fa-external-link-alt"></i></a>
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
