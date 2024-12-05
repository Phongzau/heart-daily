@php
    $slug = 'menu-header'; // Slug của menu mà bạn muốn

    $menuItems = App\Models\MenuItem::whereHas('menu', function ($query) use ($slug) {
        $query->where('slug', $slug);
    })
        ->where('status', 1)
        ->where('parent_id', 0) // Chỉ lấy các mục gốc
        ->orderBy('order')
        ->get();
    // dd($menuItems);
    // Hàm đệ quy để hiển thị các mục con
    function renderMenu($menuItems, $type)
    {
        // echo '<ul>';
        // foreach ($menuItems as $menuItem) {
        //     echo '<li>';
        //     echo '<a href="' . $menuItem->url . '">' . $menuItem->title . '</a>';

        //     // Kiểm tra nếu mục này có con
        //     if ($menuItem->children->count()) {
        //         // Đệ quy hiển thị các mục con
        //         renderMenu($menuItem->children);
        //     }

        //     echo '</li>';
        // }
        // echo '</ul>';

        if ($type == 'menu-item') {
            echo '<ul>';
            foreach ($menuItems as $menuItem) {
                echo '<li>';
                echo '<a href="' . config('app.url') . $menuItem->url . '">' . $menuItem->title . '</a>';

                // Kiểm tra nếu mục này có con
                if ($menuItem->children->count()) {
                    // Đệ quy hiển thị các mục con
                    renderMenu($menuItem->children, $type);
                }

                echo '</li>';
            }
            echo '</ul>';
        } elseif ($type == 'product') {
            echo '<ul>';
            foreach ($menuItems as $menuItem) {
                if ($menuItem->children->count()) {
                    echo '<li class="dropdown">';
                } else {
                    echo '<li>';
                }

                echo '<a href="' .
                    config('app.url') .
                    '/' .
                    $type .
                    '/' .
                    $menuItem->slug .
                    '">' .
                    $menuItem->title .
                    '</a>';
                // Kiểm tra nếu mục này có con
                if ($menuItem->children->count()) {
                    // Đệ quy hiển thị các mục con
                    renderMenu($menuItem->children, $type);
                }

                echo '</li>';
            }
            echo '</ul>';
        }
    }
@endphp

<div class="header-bottom sticky-header d-none d-lg-block" data-sticky-options="{'mobile': false}">
    <div class="container">
        <nav class="main-nav w-100">
            <ul class="menu">

                @foreach ($menuItems as $menuItem)
                    {{-- @dump($menuItem->url); --}}
                    <li
                        class="{{ $menuItem->children->count() ? 'dropdown' : '' }} {{ checkActiveClient($menuItem->url) }}">
                        <a href="{{ config('app.url') . $menuItem->url }}">{{ $menuItem->title }}</a>

                        @if ($menuItem->slug === 'san-pham')
                            @php
                                $categories = App\Models\CategoryProduct::where('status', 1)
                                    ->where('parent_id', 0)
                                    ->orderBy('order', 'DESC')
                                    ->get();
                                renderMenu($categories, 'product');
                            @endphp
                        @else
                        @endif

                        @if ($menuItem->children->count())
                            @php
                                renderMenu($menuItem->children, 'menu-item');
                            @endphp
                        @endif
                    </li>
                @endforeach

                {{-- <li class="dropdown">
                    <a href="">Product</a>
                    <ul>
                        <li>
                            <a href="">Nike</a>
                        </li>
                        <li>
                            <a href="">Adidas</a>
                        </li>
                        <li>
                            <a href="">Puma</a>
                        </li>
                        <li>
                            <a href="">ADLV</a>
                        </li>
                        <li>
                            <a href="">Jordan</a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </nav>
    </div>
</div>
