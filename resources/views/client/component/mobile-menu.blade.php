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

        </nav>
        <!-- End .mobile-nav -->
        
        <div class="social-icons">
         @foreach ($socials as $social)
            <a href="{{ $social->url }}" class="social-icon" target="_blank">
                <i class="{{ @$social->icon }}"></i>
            </a>
         @endforeach
        </div>
    </div>
    <!-- End .mobile-menu-wrapper -->
</div>
