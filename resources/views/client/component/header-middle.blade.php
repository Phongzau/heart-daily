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
                                   {{-- <div class="select-custom">
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
                                   </div> --}}
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
                           <a href="#" class="header-icon notification-icon" title="notification"
                               data-toggle="dropdown">
                               <i class="far fa-bell"></i>
                           </a>

                           @livewire('notification-component')

                           <a href="#" class="header-icon login-icon" title="login" data-toggle="dropdown">
                               <i class="icon-user-2"></i>
                           </a>
                           <ul id="login-dropdown" class="dropdown-menu"
                               style="min-width: 200px; padding: 10px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);top: 70%;
    left: 871px;">

                               {{-- min-width: 17%;
    padding: 10px;
    border-radius: 8px;
    box-shadow: rgba(0, 0, 0, 0.15) 0px 4px 10px;
    top: 70%;
    left: 72%;
    display: block; --}}
                               <li style="padding: 8px 10px; display: flex; align-items: center;">
                                   <a href="{{ route('user.dashboard') }}"
                                       style="text-decoration: none; color: #333; font-size: 15px; display: flex; align-items: center;">
                                       <i class="fas fa-user" style="margin-right: 8px; color: #007bff;"></i>
                                       <span>My Account</span>
                                   </a>
                               </li>
                               <li style="padding: 8px 10px; display: flex; align-items: center;">
                                   <a href="{{ route('admin.dashboard.index') }}"
                                       style="text-decoration: none; color: #333; font-size: 15px; display: flex; align-items: center;">
                                       <i class="fas fa-bell" style="margin-right: 8px; color: #333;"></i>
                                       <span>Notifications</span>
                                   </a>
                               </li>

                               @if (Auth::user()->role_id == 1)
                                   <!-- Check if the user role is 1 -->
                                   @can('view-dashboard')
                                       <li style="padding: 8px 10px; display: flex; align-items: center;">
                                           <a href="{{ route('admin.dashboard.index') }}"
                                               style="text-decoration: none; color: #333; font-size: 15px; display: flex; align-items: center;">
                                               <i class="fas fa-user-shield" style="margin-right: 8px; color: #dc3545;"></i>
                                               <span>Admin</span>
                                           </a>
                                       </li>
                                   @endcan
                               @endif

                               <li style="padding: 8px 10px; display: flex; align-items: center;">
                                   <a href="{{ route('logout') }}"
                                       style="text-decoration: none; color: #333; font-size: 15px; display: flex; align-items: center;">
                                       <i class="fas fa-sign-out-alt" style="margin-right: 8px; color: #28a745;"></i>
                                       <span>Logout</span>
                                   </a>
                               </li>
                           </ul>
                       @else
                           <a href="#" class="header-icon has-dropdown" title="Login" data-toggle="dropdown">
                               <i class="icon-user-2"></i>
                           </a>
                           <ul class="dropdown-menu"
                               style="min-width: 200px; padding: 10px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);">
                               <li style="padding: 8px 10px; display: flex; align-items: center;">
                                   <a href="{{ route('login') }}"
                                       style="text-decoration: none; color: #333; font-size: 15px; display: flex; align-items: center;">
                                       <i class="fas fa-sign-in-alt" style="margin-right: 8px; color: #007bff;"></i>
                                       <span>Login</span>
                                   </a>
                               </li>
                               <li style="padding: 8px 10px; display: flex; align-items: center;">
                                   <a href="{{ route('register') }}"
                                       style="text-decoration: none; color: #333; font-size: 15px; display: flex; align-items: center;">
                                       <i class="fas fa-user-plus" style="margin-right: 8px; color: #17a2b8;"></i>
                                       <span>Register</span>
                                   </a>
                               </li>
                           </ul>
                       @endif


                       <a href="{{ route('wishlist.index') }}" class="header-icon" title="wishlist"><i
                               class="icon-wishlist-2"></i><span class=" badge-circle total_wishlist"></span></a>

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
                                           <div class="product item-{{ $keyCart }}">
                                               <div class="product-details">
                                                   <h4 class="product-title">
                                                       <a
                                                           href="{{ route('product.detail', ['slug' => $item['options']['slug']]) }}">{{ $item['name'] }}
                                                           @if (isset($item['options']['variants']))
                                                               ({{ implode(' - ', $item['options']['variants']) }})
                                                           @endif
                                                       </a>
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

                                                   <a href="" data-id="{{ $keyCart }}"
                                                       class="remove_sidebar_product btn-remove"
                                                       title="Remove Product"><span>×</span></a>
                                               </figure>
                                           </div>
                                           <!-- End .product -->
                                       @endforeach
                                       @if (count($carts) === 0)
                                           <li class="text-center"
                                               style="font-size: 25px;padding: 10px;color: darkgrey;">Cart Is Empty!
                                           </li>
                                       @endif
                                   </div>

                                   <!-- End .cart-product -->

                                   <div class="dropdown-cart-total @if (count($carts) === 0) d-none @endif">
                                       <span>SUBTOTAL:</span>

                                       <span class="cart-total-price float-right">{{ number_format(getCartTotal()) }}
                                           VND</span>
                                   </div>
                                   <!-- End .dropdown-cart-total -->

                                   <div class="dropdown-cart-action @if (count($carts) === 0) d-none @endif">
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
