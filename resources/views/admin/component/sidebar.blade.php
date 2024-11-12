<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="dashboard">HEART DAILY</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
        </div>
        <ul class="sidebar-menu">
            @can('view-dashboard')
                <li class="menu-header">Trang chủ</li>
                <li><a class="nav-link" href="{{ route('admin.dashboard.index') }}"><i class="fas fa-fire"></i><span>Trang
                            chủ</span></a></li>
            @endcan
            <li class="menu-header">Start Menu</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-brands fa-product-hunt"></i>
                    <span>Sản phẩm</span></a>
                <ul class="dropdown-menu">
                    @can('view-categories-products')
                        <li><a class="nav-link" href="{{ route('admin.category_products.index') }}">Danh mục sản phẩm</a>
                        </li>
                    @endcan
                    @can('view-products')
                        <li><a class="nav-link" href="{{ route('admin.products.index') }}">Sản phẩm</a>
                        </li>
                    @endcan
                    @can('view-brands')
                        <li><a class="nav-link" href="{{ route('admin.brands.index') }}">Thương hiệu</a>
                        </li>
                    @endcan
                    @can('view-categories-attributes')
                        <li><a class="nav-link" href="{{ route('admin.category_attributes.index') }}">Danh mục thuộc
                                tính</a>
                        </li>
                    @endcan
                    @can('view-attributes')
                        <li><a class="nav-link" href="{{ route('admin.attributes.index') }}">Thuộc tính</a>
                        </li>
                    @endcan
                    @can('view-coupons')
                        <li><a class="nav-link" href="{{ route('admin.coupons.index') }}">Mã giảm giá</a>
                        </li>
                    @endcan
                    @can('view-reviews')
                        <li><a class="nav-link" href="{{ route('admin.product_reviews.index') }}">Đánh giá</a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-solid fa-rectangle-ad"></i>
                    <span>Banners</span></a>
                <ul class="dropdown-menu">
                    @can('view-advertisements')
                        <li><a class="nav-link" href="{{ route('admin.advertisement.index') }}">
                                <span>Quảng cáo</span></a></li>
                    @endcan
                    @can('view-popups')
                        <li><a class="nav-link" href="{{ route('admin.popups.index') }}">
                                <span>Quảng cáo Popup</span></a></li>
                    @endcan
                    @can('view-banners')
                        <li><a class="nav-link" href="{{ route('admin.banners.index') }}">
                                <span>Banner Slide</span></a></li>
                    @endcan
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-solid fa-newspaper"></i>
                    <span>Bài viết</span></a>
                <ul class="dropdown-menu">
                    @can('view-blogs')
                        <li><a class="nav-link" href="{{ route('admin.blogs.index') }}">
                                <span>Bài viết</span></a></li>
                    @endcan
                    @can('view-blog-categories')
                        <li><a class="nav-link" href="{{ route('admin.blog_categories.index') }}">
                                <span>Danh mục bài viết</span></a></li>
                    @endcan
                    @can('view-blog-comments')
                        <li><a class="nav-link" href="{{ route('admin.blog_comments.index') }}">
                                <span>Bình luận</span></a></li>
                    @endcan
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-th-large"></i>
                    <span>Menus</span></a>
                <ul class="dropdown-menu">
                    @can('view-menus')
                        <li><a class="nav-link" href="{{ route('admin.menus.index') }}">
                                <span>Menu</span></a></li>
                    @endcan
                    @can('view-menu-items')
                        <li><a class="nav-link" href="{{ route('admin.menu_items.index') }}">
                                <span>Menu Items</span></a></li>
                    @endcan
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-shopping-cart"></i>
                    <span>Đơn hàng</span></a>
                <ul class="dropdown-menu">
                    @can('view-orders')
                        <li><a class="nav-link" href="{{ route('admin.orders.index') }}">
                                <span>Danh sách đơn hàng</span></a></li>
                    @endcan
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-user"></i>
                    <span>Tài khoản</span></a>
                <ul class="dropdown-menu">
                    @can('view-accounts')
                        <li><a class="nav-link" href="{{ route('admin.accounts.index') }}">
                                <span>Danh sách tài khoản</span></a></li>
                    @endcan
                    @if(auth()->user()->hasRole(['admin', 'super_admin']))
                        <li><a class="nav-link" href="{{ route('admin.roles.index') }}">
                                <span>Phân quyền</span></a></li>
                    @endif
                </ul>
            </li>
            @can('view-socials')
                <li><a class="nav-link" href="{{ route('admin.socials.index') }}"><i class="fa-solid fa-icons"></i>
                        <span>Mạng xã hội</span></a></li>
            @endcan
            @can('view-settings')
                <li><a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear"></i>
                        <span>Cấu hình</span></a></li>
            @endcan
            @can('view-tags')
                <li><a class="nav-link" href="{{ route('admin.tags.index') }}"><i class="fas fa-tags"></i>
                        <span>Tags</span></a></li>
            @endcan
            @can('view-abouts')
                <li><a class="nav-link" href="{{ route('admin.abouts.index') }}"><i class="fa-solid fa-info"></i>
                        <span>Giới thiệu</span></a></li>
            @endcan
            @can('view-payment-settings')
                <li><a class="nav-link" href="{{ route('admin.payment-settings.vnpay-setting.index') }}"><i
                            class="fa-solid fa-money-check-dollar"></i>
                        <span>Phương thức thanh toán</span></a></li>
            @endcan
        </ul>
    </aside>
</div>
