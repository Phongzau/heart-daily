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
                <li class="{{ checkActive(['admin.dashboard.index']) }}"><a class="nav-link"
                        href="{{ route('admin.dashboard.index') }}"><i class="fa-regular fa-chart-mixed"></i><span>Trang
                            chủ</span></a></li>
            @endcan
            <li class="menu-header">Start Menu</li>
            <li
                class="dropdown {{ checkActive(['admin.category_products.*', 'admin.products.*', 'admin.brands.*', 'admin.category_attributes.*', 'admin.attributes.*', 'admin.coupons.*', 'admin.product_reviews.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-regular fa-shirt"></i>
                    <span>Sản phẩm</span></a>
                <ul class="dropdown-menu">
                    @can('view-categories-products')
                        <li class="{{ checkActive(['admin.category_products.*']) }}"><a class="nav-link"
                                href="{{ route('admin.category_products.index') }}">Danh mục sản phẩm</a>
                        </li>
                    @endcan
                    @can('view-products')
                        <li class="{{ checkActive(['admin.products.*']) }}"><a class="nav-link"
                                href="{{ route('admin.products.index') }}">Sản phẩm</a>
                        </li>
                    @endcan
                    @can('view-brands')
                        <li class="{{ checkActive(['admin.brands.*']) }}"><a class="nav-link"
                                href="{{ route('admin.brands.index') }}">Thương hiệu</a>
                        </li>
                    @endcan
                    @can('view-categories-attributes')
                        <li class="{{ checkActive(['admin.category_attributes.*']) }}"><a class="nav-link"
                                href="{{ route('admin.category_attributes.index') }}">Danh mục thuộc
                                tính</a>
                        </li>
                    @endcan
                    @can('view-attributes')
                        <li class="{{ checkActive(['admin.attributes.*']) }}"><a class="nav-link"
                                href="{{ route('admin.attributes.index') }}">Thuộc tính</a>
                        </li>
                    @endcan
                    @can('view-coupons')
                        <li class="{{ checkActive(['admin.coupons.*']) }}"><a class="nav-link"
                                href="{{ route('admin.coupons.index') }}">Mã giảm giá</a>
                        </li>
                    @endcan
                    @can('view-reviews')
                        <li class="{{ checkActive(['admin.product_reviews.*']) }}"><a class="nav-link"
                                href="{{ route('admin.product_reviews.index') }}">Đánh giá</a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="dropdown {{ checkActive(['admin.advertisement.*', 'admin.popups.*', 'admin.banners.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-regular fa-rectangle-ad"></i>
                    <span>Banners</span></a>
                <ul class="dropdown-menu">
                    @can('view-advertisements')
                        <li class="{{ checkActive(['admin.advertisement.*']) }}"><a class="nav-link"
                                href="{{ route('admin.advertisement.index') }}">
                                <span>Quảng cáo</span></a></li>
                    @endcan
                    @can('view-popups')
                        <li class="{{ checkActive(['admin.popups.*']) }}"><a class="nav-link"
                                href="{{ route('admin.popups.index') }}">
                                <span>Quảng cáo Popup</span></a></li>
                    @endcan
                    @can('view-banners')
                        <li class="{{ checkActive(['admin.banners.*']) }}"><a class="nav-link"
                                href="{{ route('admin.banners.index') }}">
                                <span>Banner Slide</span></a></li>
                    @endcan
                </ul>
            </li>
            <li
                class="dropdown {{ checkActive(['admin.blogs.*', 'admin.blog_categories.*', 'admin.blog_comments.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-light fa-newspaper"></i>
                    <span>Bài viết</span></a>
                <ul class="dropdown-menu">
                    @can('view-blogs')
                        <li class="{{ checkActive(['admin.blogs.*']) }}">
                            <a class="nav-link" href="{{ route('admin.blogs.index') }}">
                                <span>Bài viết</span></a>
                        </li>
                    @endcan
                    @can('view-blog-categories')
                        <li class="{{ checkActive(['admin.blog_categories.*']) }}">
                            <a class="nav-link" href="{{ route('admin.blog_categories.index') }}">
                                <span>Danh mục bài viết</span></a>
                        </li>
                    @endcan
                    @can('view-blog-comments')
                        <li class="{{ checkActive(['admin.blog_comments.*']) }}"><a class="nav-link"
                                href="{{ route('admin.blog_comments.index') }}">
                                <span>Bình luận</span></a></li>
                    @endcan
                </ul>
            </li>
            <li class="dropdown {{ checkActive(['admin.menus.*', 'admin.menu_items.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-light fa-list"></i>
                    <span>Menus</span></a>
                <ul class="dropdown-menu">
                    @can('view-menus')
                        <li class="{{ checkActive(['admin.menus.*']) }}">
                            <a class="nav-link" href="{{ route('admin.menus.index') }}">
                                <span>Menu</span></a>
                        </li>
                    @endcan
                    @can('view-menu-items')
                        <li class="{{ checkActive(['admin.menu_items.*']) }}"><a class="nav-link"
                                href="{{ route('admin.menu_items.index') }}">
                                <span>Menu Items</span></a></li>
                    @endcan
                </ul>
            </li>
            <li class="dropdown {{ checkActive(['admin.orders.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-regular fa-cart-shopping-fast"></i>
                    <span>Đơn hàng</span></a>
                <ul class="dropdown-menu">
                    @can('view-orders')
                        <li class="{{ checkActive(['admin.orders.index']) }}"><a class="nav-link"
                                href="{{ route('admin.orders.index') }}">
                                <span>Danh sách đơn hàng</span></a></li>
                        <li class="{{ checkActive(['admin.orders.return-order']) }}"><a class="nav-link"
                                href="{{ route('admin.orders.return-order') }}">
                                <span>Danh sách trả hàng</span></a></li>
                        <li class="{{ checkActive(['admin.order.transaction']) }}"><a class="nav-link"
                                href="{{ route('admin.orders.transaction') }}">
                                <span>Thông tin giao dịch</span></a></li>
                    @endcan
                </ul>
            </li>
            <li class="dropdown {{ checkActive(['admin.inventory.*', 'admin.suppliers.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-light fa-warehouse"></i>
                    <span>Kho hàng</span></a>
                <ul class="dropdown-menu">
                    @can('view-inventory')
                        <li class="{{ checkActive(['admin.inventory.index']) }}">
                            <a href="{{ route('admin.inventory.index') }}" class="nav-link">
                                <span>Kho hàng</span></a>
                        </li>
                    @endcan
                    @can('view-suppliers')
                        <li class="{{ checkActive(['admin.suppliers.index']) }}">
                            <a href="{{ route('admin.suppliers.index') }}" class="nav-link">
                                <span>Nhà cung cấp</span></a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="dropdown {{ checkActive(['admin.accounts.*', 'admin.roles.*', 'admin.withdraws.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-regular fa-user-pen"></i>
                    <span>Tài khoản</span></a>
                <ul class="dropdown-menu">
                    @can('view-accounts')
                        <li class="{{ checkActive(['admin.accounts.*']) }}"><a class="nav-link"
                                href="{{ route('admin.accounts.index') }}">
                                <span>Danh sách tài khoản</span></a></li>
                    @endcan
                    @if (auth()->user()->hasRole(['admin', 'super_admin']))
                        <li class="{{ checkActive(['admin.roles.*']) }}"><a class="nav-link"
                                href="{{ route('admin.roles.index') }}">
                                <span>Phân quyền</span></a></li>
                    @endif
                    <li class="{{ checkActive(['admin.withdraws.*']) }}"><a class="nav-link"
                            href="{{ route('admin.withdraws.index') }}">
                            <span>Yêu cầu rút tiền</span></a></li>
                </ul>
            </li>
            @can('view-socials')
                <li class="{{ checkActive(['admin.socials.*']) }}"><a class="nav-link"
                        href="{{ route('admin.socials.index') }}"><i class="fa-light fa-icons"></i>
                        <span>Mạng xã hội</span></a></li>
            @endcan
            @can('view-settings')
                <li class="{{ checkActive(['admin.settings.*']) }}"><a class="nav-link"
                        href="{{ route('admin.settings.index') }}"><i class="fa-regular fa-gear"></i>
                        <span>Cấu hình</span></a></li>
            @endcan
            @can('view-tags')
                <li class="{{ checkActive(['admin.tags.*']) }}"><a class="nav-link"
                        href="{{ route('admin.tags.index') }}"><i class="fa-regular fa-tag"></i>
                        <span>Tags</span></a></li>
            @endcan
            @can('view-abouts')
                <li class="{{ checkActive(['admin.abouts.*']) }}"><a class="nav-link"
                        href="{{ route('admin.abouts.index') }}"><i class="fa-regular fa-circle-info"></i>
                        <span>Giới thiệu</span></a></li>
            @endcan
            @can('view-payment-settings')
                <li class="{{ checkActive(['admin.payment-settings.*']) }}"><a class="nav-link"
                        href="{{ route('admin.payment-settings.vnpay-setting.index') }}"><i
                            class="fa-regular fa-money-check-dollar-pen"></i>
                        <span>Phương thức thanh toán</span></a></li>
            @endcan
        </ul>
    </aside>
</div>
