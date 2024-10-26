@php
    $slug = 'menu-header'; // Slug của menu mà bạn muốn

    $menuItems = App\Models\MenuItem::whereHas('menu', function ($query) use ($slug) {
        $query->where('slug', $slug);
    })
        ->where('status', 1)
        ->where('parent_id', 0) // Chỉ lấy các mục gốc
        ->orderBy('order')
        ->get();

    // Hàm đệ quy để hiển thị các mục con
    function renderMenu($menuItems)
    {
        echo '<ul>';
        foreach ($menuItems as $menuItem) {
            echo '<li>';
            echo '<a href="' . $menuItem->url . '">' . $menuItem->title . '</a>';

            // Kiểm tra nếu mục này có con
            if ($menuItem->children->count()) {
                // Đệ quy hiển thị các mục con
                renderMenu($menuItem->children);
            }

            echo '</li>';
        }
        echo '</ul>';
    }
@endphp

<div class="header-bottom sticky-header d-none d-lg-block" data-sticky-options="{'mobile': false}">
    <div class="container">
        <nav class="main-nav w-100">
            <ul class="menu">
                @foreach ($menuItems as $menuItem)
                    <li class="{{ $menuItem->children->count() ? 'dropdown' : '' }}">
                        <a href="{{ config('app.url') . $menuItem->url }}">{{ $menuItem->title }}</a>

                        @if ($menuItem->children->count())
                            @php
                                // Gọi hàm đệ quy để hiển thị các cấp con
                                renderMenu($menuItem->children);
                            @endphp
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>
