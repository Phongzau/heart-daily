           <div class="header-middle sticky-header" data-sticky-options="{'mobile': true}">
               <div class="container">
                   <div class="header-left col-lg-2 w-auto pl-0">
                       <button class="mobile-menu-toggler text-primary mr-2" type="button">
                           <i class="fas fa-bars"></i>
                       </button>
                       <a href="{{ route('home') }}" class="logo">
                           <img src="{{ Storage::url(@$logoSetting->logo) }}" alt="Logo">
                       </a>
                   </div>
                   <!-- End .header-left -->

                   <div class="header-right w-lg-max">
                       <div
                           class="header-icon header-search header-search-inline header-search-category w-lg-max text-right mt-0">
                           <a href="#" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
                           <form action="#" method="get">
                               <div class="header-search-wrapper">
                                   <input type="search" class="form-control" name="q" id="q"
                                       placeholder="Search..." required>
                                   <div class="select-custom">
                                       <select id="cat" name="cat">
                                           <option value="">All Categories</option>
                                           <option value="4">Fashion</option>
                                           <option value="12">- Women</option>
                                           <option value="13">- Men</option>
                                           <option value="66">- Jewellery</option>
                                           <option value="67">- Kids Fashion</option>
                                           <option value="5">Electronics</option>
                                           <option value="21">- Smart TVs</option>
                                           <option value="22">- Cameras</option>
                                           <option value="63">- Games</option>
                                           <option value="7">Home &amp; Garden</option>
                                           <option value="11">Motors</option>
                                           <option value="31">- Cars and Trucks</option>
                                           <option value="32">- Motorcycles &amp; Powersports</option>
                                           <option value="33">- Parts &amp; Accessories</option>
                                           <option value="34">- Boats</option>
                                           <option value="57">- Auto Tools &amp; Supplies</option>
                                       </select>
                                   </div>
                                   <!-- End .select-custom -->
                                   <button class="btn icon-magnifier p-0" title="search" type="submit"></button>
                               </div>
                               <!-- End .header-search-wrapper -->
                           </form>
                       </div>
                       <!-- End .header-search -->

                       <i class="fa-solid fa-right-from-bracket"></i>
                       @if (Auth::check())

    <a href="{{ route('chat') }}" class="header-icon" title="chat">
        <i class="far fa-comment-dots" style="opacity: 0.95;"></i>
    </a>
    <a href="#" class="header-icon has-dropdown" title="login" data-toggle="dropdown">
        <i class="icon-user-2"></i>
    </a>
    <ul class="dropdown-menu">

        
        @if (Auth::user()->role_id == 1) <!-- Check if the user role is 1 -->
        <li style="font-size: 15px; align-items: center; display: flex; margin-left: 5px; margin-right: 5px">
            <a href="{{ route('user.dashboard') }}"><i class="fas fa-user"></i><span>MY Account</span></a>
        </li>
            <li style="font-size: 15px; align-items: center; display: flex; margin-left: 5px; margin-right: 5px">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-user-shield"></i><span>Admin</span></a>
            </li>
        @endif
        
        <li style="font-size: 15px; align-items: center; display: flex; margin-left: 5px; margin-right: 5px">
            <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </li>
    </ul>
@else
    <a href="#" class="header-icon has-dropdown" title="login" data-toggle="dropdown">
        <i class="icon-user-2"></i>
    </a>
    <ul class="dropdown-menu">
        <li style="font-size: 15px; align-items: center; display: flex; margin-left: 5px; margin-right: 5px">
            <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i><span>Login</span></a>
        </li>
    </ul>
@endif

                       <a href="{{ route('wishlist.index') }}" class="header-icon" title="wishlist"><i
                               class="icon-wishlist-2"></i></a>

                       <div class="dropdown cart-dropdown">
                           <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle"
                               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                               data-display="static">
                               <i class="minicart-icon"></i>
                               <span class="cart-count badge-circle">{{ count($carts) }}</span>
                           </a>

                           <div class="cart-overlay"></div>

                           <div class="dropdown-menu mobile-cart">
                               <a href="#" title="Close (Esc)" class="btn-close">×</a>

                               <div class="dropdownmenu-wrapper custom-scrollbar">
                                   <div class="dropdown-cart-header">Shopping Cart</div>
                                   <!-- End .dropdown-cart-header -->

                                   <div class="dropdown-cart-products">
                                       @foreach ($carts as $keyCart => $item)
                                           <div class="product">
                                               <div class="product-details">
                                                   <h4 class="product-title">
                                                       <a
                                                           href="{{ route('product.detail', ['slug' => $item['options']['slug']]) }}">{{ $item['name'] }}</a>
                                                   </h4>

                                                   <span class="cart-product-info">
                                                       <span class="cart-product-qty">{{ $item['qty'] }}</span> ×
                                                       {{ number_format($item['price']) }}
                                                       VND
                                                   </span>
                                               </div>
                                               <!-- End .product-details -->

                                               <figure class="product-image-container">
                                                   <a href="{{ route('product.detail', ['slug' => $item['options']['slug']]) }}"
                                                       class="product-image">
                                                       <img src="{{ Storage::url($item['options']['image']) }}"
                                                           alt="{{ $item['name'] }}" width="80" height="80">
                                                   </a>

                                                   <a href="{{ route('cart.remove-product', ['cartKey' => $keyCart]) }}"
                                                       class="btn-remove" title="Remove Product"><span>×</span></a>
                                               </figure>
                                           </div>
                                           <!-- End .product -->
                                       @endforeach
                                   </div>

                                   <!-- End .cart-product -->

                                   <div class="dropdown-cart-total">
                                       <span>SUBTOTAL:</span>

                                       <span class="cart-total-price float-right">{{ number_format(getCartTotal()) }}
                                           VND</span>
                                   </div>
                                   <!-- End .dropdown-cart-total -->

                                   <div class="dropdown-cart-action">
                                       <a href="{{ route('cart-details') }}"
                                           class="btn btn-gray btn-block view-cart">View
                                           Cart</a>
                                       <a href="{{ route('checkout') }}" class="btn btn-dark btn-block">Checkout</a>
                                   </div>
                                   <!-- End .dropdown-cart-total -->
                               </div>
                               <!-- End .dropdownmenu-wrapper -->
                           </div>
                           <!-- End .dropdown-menu -->
                       </div>
                       <!-- End .dropdown -->
                   </div>
                   <!-- End .header-right -->
               </div>
               <!-- End .container -->
           </div>
           <!-- End .header-middle -->
