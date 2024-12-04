@php
    $slug = 'menu-footer'; // Slug của menu mà bạn muốn

    $menuItems = App\Models\MenuItem::whereHas('menu', function ($query) use ($slug) {
        $query->where('slug', $slug);
    })
        ->where('status', 1)
        ->where('parent_id', 0) // Chỉ lấy các mục gốc
        ->orderBy('order')
        ->get();
    $socials = \App\Models\Social::query()->where('status', 1)->get();
    $tags = \App\Models\Tag::query()->where('status', 1)->get();

@endphp
<footer class="footer bg-dark">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="widget">
                        <img src="{{ Storage::url(@$logoSetting->logo_footer) }}" alt="Logo" class="widget-logo mb-3"
                            style="width: 100px; height: auto;">
                        <h4 class="widget-title">Thông tin liên hệ</h4>
                        <ul class="contact-info">
                            <li>
                                <span class="contact-info-label">Địa chỉ:</span>
                                <i class="fas fa-map-marker-alt fa-sm"></i>
                                {{ @$generalSettings->contact_address }}
                            </li>
                            <li>
                                <span class="contact-info-label">Điện thoại:</span>
                                <a href="tel:{{ @$generalSettings->contact_phone }}">
                                    <i class="fas fa-phone fa-rotate-90 fa-sm"></i>
                                    {{ @$generalSettings->contact_phone }}
                                </a>
                            </li>
                            <li>
                                <span class="contact-info-label">Email:</span>
                                <a href="tel:{{ @$generalSettings->contact_email }}">
                                    <i class="fas fa-envelope fa-sm"></i> {{ @$generalSettings->contact_email }}
                                </a>
                            </li>
                            <!-- <li>
                              <span class="contact-info-label">Working Days/Hours:</span> Mon - Sun / 9:00
                              AM
                              - 8:00 PM
                          </li> -->
                        </ul>
                        <div class="social-icons">
                            <!-- <a href="" class="social-icon social-facebook icon-facebook" target="_blank"
                              title="Facebook"></a>
                          <a href="#" class="social-icon social-twitter icon-twitter" target="_blank"
                              title="Twitter"></a>
                          <a href="" class="social-icon social-instagram icon-instagram"
                              target="_blank" title="Instagram"></a> -->

                            @foreach ($socials as $social)
                                <a href="{{ $social->url }}" class="social-icon" target="_blank">
                                    <i class="{{ @$social->icon }}"></i>
                                </a>
                            @endforeach
                        </div>
                        <!-- End .social-icons -->
                    </div>
                    <!-- End .widget -->
                </div>
                <!-- End .col-lg-3 -->

                <div class="col-lg-3 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">Dịch vụ khách hàng</h4>
                        <ul class="links">
                            @foreach ($menuItems as $key => $value)
                                <li> <a href="{{ config('app.url') . $value->url }}">{{ $value->title }}</a></li>
                            @endforeach
                            {{--  <li><a href="#">Help & FAQs</a></li>
                          <li><a href="#">Order Tracking</a></li>
                          <li><a href="#">Shipping & Delivery</a></li>
                          <li><a href="#">Orders History</a></li>
                          <li><a href="#">Advanced Search</a></li>
                          <li><a href="dashboard.html">My Account</a></li>
                          <li><a href="#">Careers</a></li>
                          <li><a href="about.html">About Us</a></li>
                          <li><a href="#">Corporate Sales</a></li>
                          <li><a href="#">Privacy</a></li>  --}}
                        </ul>
                    </div>
                    <!-- End .widget -->
                </div>
                <!-- End .col-lg-3 -->

                <div class="col-lg-3 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">Thẻ phổ biến</h4>
                        <div class="tagcloud">
                            @foreach ($tags as $tag)
                                <a href="{{ route('product.getProducts', ['tag_id' => $tag->id]) }}" class="tag-link">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>

                    </div>
                    <!-- End .widget -->
                </div>
                <!-- End .col-lg-3 -->

                <div class="col-lg-3 col-sm-6">
                    <div class="widget widget-newsletter">
                        <h4 class="widget-title">Đăng ký nhận bản tin</h4>
                        <p>Nhận tất cả các thông tin mới nhất về các sự kiện, bán hàng và cung cấp. Đăng ký nhận bản
                            tin:
                        </p>
                        <form action="#" class="mb-0">

                            <input type="email" class="form-control m-b-3" placeholder="Địa chỉ email của bạn"
                                required>

                            <input type="submit" class="btn btn-primary shadow-none" value="ĐĂNG KÝ">
                        </form>
                        <br>

                    </div>
                    <!-- End .widget -->
                </div>
                <!-- End .col-lg-3 -->
            </div>
            <!-- End .row -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End .footer-middle -->

    <div class="container">
        <div class="footer-bottom">
            <div class="container d-sm-flex align-items-center">
                <div class="footer-left">
                    <span class="footer-copyright">© Heart Daily E.Commerce. 2024. All Rights Reserved</span>
                </div>

                <div class="footer-right ml-auto mt-1 mt-sm-0">
                    <div class="payment-icons">
                        <span class="payment-icon visa"
                            style="background-image: url({{ asset('frontend/assets/images/payments/payment-visa.svg') }})"></span>
                        <span class="payment-icon paypal"
                            style="background-image: url({{ asset('frontend/assets/images/payments/payment-paypal.svg') }})"></span>
                        <span class="payment-icon stripe"
                            style="background-image: url({{ asset('frontend/assets/images/payments/payment-stripe.png') }})"></span>
                        <span class="payment-icon verisign"
                            style="background-image:  url({{ asset('frontend/assets/images/payments/payment-verisign.svg') }})"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- End .footer-bottom -->
    </div>
    <!-- End .container -->
</footer>
<!-- End .footer -->

</div>
<!-- End .page-wrapper -->

<div class="loading-overlay">
    <div class="bounce-loader">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<div class="mobile-menu-overlay"></div>
<!-- End .mobil-menu-overlay -->

@include('client.component.mobile-menu')
<!-- End .mobile-menu-container -->

<div class="sticky-navbar">
    <div class="sticky-info">
        <a href="{{ url('/') }}">
            <i class="icon-home"></i>Trang chủ
        </a>
    </div>
    <div class="sticky-info">
        <a href="{{ route('product.getProducts') }}" class="">
            <i class="icon-bars"></i>Sản phẩm
        </a>
    </div>
    <div class="sticky-info">
        <a href="{{ route('wishlist.index') }}" class="">
            <i class="icon-wishlist-2"></i>Yêu thích
        </a>
    </div>
    <div class="sticky-info">
        <a href="{{ route('user.dashboard') }}" class="">
            <i class="icon-user-2"></i>Tài khoản
        </a>
    </div>
    <div class="sticky-info">
        <a href="{{ route('cart-details') }}" class="">
            <i class="icon-shopping-cart position-relative">
                <span class="cart-count badge-circle">{{ count($carts) }}</span>
            </i>Giỏ hàng
        </a>
    </div>
</div>


<script>
    @if (Auth::check())
        window.userId = "{{ Auth::user()->id }}";
    @endif
</script>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
@livewireScripts
<!-- Plugins JS File -->
<script data-cfasync="false" src="{{ asset('frontend/assets/js/email-decode.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/nouislider.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/optional/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.appear.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- Main JS File -->
<script src="{{ asset('frontend/assets/js/main.min.js') }}"></script>
@vite('resources/js/app.js')

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@yield('js-chat')


<script>
    // Nếu $errors tồn tại
    @if ($errors->any())
        // Duyệt qua tất cả mảng $errors qua biến $error
        @foreach ($errors->all() as $error)
            // Hiển thị lỗi qua toastr
            toastr.error('{{ $error }}');
        @endforeach
    @endif
    @if (Auth::check())
        window.userId = "{{ Auth::user()->id }}";
    @endif
</script>
<script>
    totalWishlist();

    function totalWishlist() {
        $.ajax({
            type: 'GET',
            url: '{{ route('wishlist.totalWishlist') }}',
            success: function(response) {
                var response = JSON.parse(response);
                $('.total_wishlist').text(response);
            }
        })
    }
    var user_id = "{{ Auth::id() }}";
    $(document).ready(function() {
        $(document).on('click', '.btn-icon-wish', function(e) {
            e.preventDefault();
            var heartIcon = $(this).find('i');
            var button = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            var product_id = button.data('productid');
            // alert(product_id);
            $.ajax({
                type: 'POST',
                url: '{{ route('wishlist.updateWishlist') }}',
                data: {
                    product_id: product_id,
                    user_id: user_id,
                },
                success: function(response) {
                    console.log(response);
                    if (response.action == 'add') {
                        totalWishlist();
                        button.addClass('added-wishlist');
                    } else if (response.action == 'remove') {
                        totalWishlist();
                        button.removeClass('added-wishlist');
                    } else if (response.action == 'not_logged_in') {
                        toastr.error('Bạn cần đăng nhập để thực hiện hành động này.');
                    }

                },
                error: function(xhr, status, error) {
                    console.error(error); // Ghi lỗi vào console để xử lý
                    if (xhr.status === 403) {
                        toastr.error('Bạn cần đăng nhập để thực hiện hành động này.');
                    } else {
                        toastr.error('Có lỗi xảy ra!');
                    }
                }
            });
        });
    });
</script>
@include('client.component.scripts')
@stack('scripts')
</body>


<!-- Mirrored from portotheme.com/html/porto_ecommerce/demo4.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Sep 2024 16:14:51 GMT -->

</html>
