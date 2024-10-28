<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">HEART DAILY</a>

        </div>
        <div class="sidebar-brand sidebar-brand-sm">

        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown active">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="index-0.html">General Dashboard</a></li>
                    <li class=active><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
                </ul>
            </li>
            <li class="menu-header"> Start Menu</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-brands fa-product-hunt"></i>
                    <span>Products</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.products.index') }}">Product</a>
                    </li>
                    <li><a class="nav-link" href="{{ route('admin.category_products.index') }}">Category Product</a>
                    </li>
                    <li><a class="nav-link" href="{{ route('admin.brands.index') }}">
                            <span>Brands</span></a></li>
                    <li><a class="nav-link" href="{{ route('admin.category_attributes.index') }}">Category Attribute</a>
                    </li>
                    <li><a class="nav-link" href="{{ route('admin.attributes.index') }}">Attribute</a></li>

                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-solid fa-rectangle-ad"></i>
                    <span>Banners</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.advertisement.index') }}">
                            <span>Advertisement</span></a></li>
                    <li><a class="nav-link" href="{{ route('admin.popups.index') }}">
                            <span>Newlett Popup</span></a></li>
                    <li><a class="nav-link" href="{{ route('admin.banners.index') }}">
                            <span>Banner</span></a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-user"></i>
                    <span>Accounts</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.accounts.index') }}">
                            <span>List Account</span></a></li>
                    <li><a class="nav-link" href="{{ route('admin.roles.index') }}">
                            <span>Role</span></a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-th-large"></i>
                    <span>Menus</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.menus.index') }}">
                            <span>Menu</span></a></li>
                    <li><a class="nav-link" href="{{ route('admin.menu_items.index') }}">
                            <span>Menu Items</span></a></li>
                </ul>
            </li>

            <li><a class="nav-link" href="{{ route('admin.abouts.index') }}"><i class="fa-solid fa-info"></i>
                    <span>Abouts</span></a></li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fa-solid fa-newspaper"></i>
                    <span>Blogs</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.blogs.index') }}">
                            <span>Blog</span></a></li>
                    <li><a class="nav-link" href="{{ route('admin.blog_categories.index') }}">
                            <span>Blog_categories</span></a></li>
                    <li><a class="nav-link" href="{{ route('admin.blog_comments.index') }}">
                            <span>Blog Comment</span></a></li>
                </ul>
            </li>
            <li><a class="nav-link" href="{{ route('admin.payment-settings.index') }}"><i class="fa-solid fa-money-check-dollar"></i>
                <span>Payment settings</span></a></li>
            <li><a class="nav-link" href="{{ route('admin.coupons.index') }}"><i class="fa-solid fa-ticket"></i>
                    <span>Coupons</span></a></li>
            <li><a class="nav-link" href="{{ route('admin.socials.index') }}"><i class="fa-solid fa-icons"></i>
                    <span>Socials</span></a></li>
            <li><a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear"></i>
                    <span>Settings</span></a></li>
            <li><a class="nav-link" href="{{ route('admin.payment-settings.index') }}"><i class="fa-solid fa-gear"></i>
                    <span>Payment settings</span></a></li>
            <li><a class="nav-link" href="{{ route('admin.tags.index') }}"><i class="fas fa-tags"></i>
                    <span>Tags</span></a></li>


        </ul>
    </aside>
</div>
