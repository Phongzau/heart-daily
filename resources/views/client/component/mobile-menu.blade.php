@php
    $menuMobileItems = App\Models\MenuItem::whereHas('menu', function ($query) {
        $query->where('slug', 'menu-header');
    })
        ->where('status', 1)
        ->where('parent_id', 0) // Chỉ lấy các mục gốc
        ->orderBy('order')
        ->get();
    // Hàm đệ quy để hiển thị các mục con
    function renderMenuMobile($menuMobileItems, $type)
    {
        if ($type == 'menu-item') {
            echo '<ul>';
            foreach ($menuMobileItems as $menuMobileItem) {
                echo '<li>';
                echo '<a href="' . config('app.url') . $menuMobileItem->url . '">' . $menuMobileItem->title . '</a>';

                // Kiểm tra nếu mục này có con
                if ($menuMobileItem->children->count()) {
                    // Đệ quy hiển thị các mục con
                    renderMenuMobile($menuMobileItem->children, $type);
                }

                echo '</li>';
            }
            echo '</ul>';
        } elseif ($type == 'product') {
            echo '<ul>';
            foreach ($menuMobileItems as $menuMobileItem) {
                echo '<li>';
                echo '<a href="' .
                    config('app.url') .
                    '/' .
                    $type .
                    '/' .
                    $menuMobileItem->slug .
                    '">' .
                    $menuMobileItem->title .
                    '</a>';
                // Kiểm tra nếu mục này có con
                if ($menuMobileItem->children->count()) {
                    // Đệ quy hiển thị các mục con
                    renderMenuMobile($menuMobileItem->children, $type);
                }

                echo '</li>';
            }
            echo '</ul>';
        }
    }
@endphp
<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="fa fa-times"></i></span>
        <nav class="mobile-nav">
            <ul class="mobile-menu">

                @foreach ($menuMobileItems as $menuMobileItem)
                    <li>
                        <a href="{{ config('app.url') . $menuMobileItem->url }}">{{ $menuMobileItem->title }}</a>
                        @if ($menuMobileItem->slug === 'san-pham')
                            @php
                                $categories = App\Models\CategoryProduct::where('status', 1)
                                    ->where('parent_id', 0)
                                    ->orderBy('order', 'DESC')
                                    ->get();
                                renderMenuMobile($categories, 'product');
                            @endphp
                        @else
                        @endif

                        @if ($menuMobileItem->children->count())
                            @php
                                renderMenuMobile($menuMobileItem->children, 'menu-item');
                            @endphp
                        @endif
                    </li>
                @endforeach

            </ul>

            <ul class="mobile-menu">
                <li><a href="login.html">My Account</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="wishlist.html">My Wishlist</a></li>
                <li><a href="cart.html">Cart</a></li>
                <li><a href="login.html" class="login-link">Log In</a></li>
            </ul>
        </nav>
        <!-- End .mobile-nav -->

        <form class="search-wrapper mb-2" action="#">
            <input type="text" class="form-control mb-0" placeholder="Search..." required />
            <button class="btn icon-search text-white bg-transparent p-0" type="submit"></button>
        </form>

        <div class="social-icons">
            <a href="#" class="social-icon social-facebook icon-facebook" target="_blank">
            </a>
            <a href="#" class="social-icon social-twitter icon-twitter" target="_blank">
            </a>
            <a href="#" class="social-icon social-instagram icon-instagram" target="_blank">
            </a>
        </div>
    </div>
    <!-- End .mobile-menu-wrapper -->
</div>
