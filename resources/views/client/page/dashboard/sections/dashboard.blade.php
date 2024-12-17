<div class="tab-pane fade show active" id="dashboard" role="tabpanel">
    <div class="dashboard-content">
        <p>
            Xin chào <strong class="text-dark">{{ Auth::user()->name }}!</strong> (không
            <strong class="text-dark">{{ Auth::user()->name }}!</strong>?
            <a href="{{ route('register') }}" class="btn btn-link ">Đăng xuất</a>)
        </p>

        <p>
            Từ bảng điều khiển tài khoản của bạn, bạn có thể xem
            <a class="btn btn-link link-to-tab" href="#order">đơn đặt hàng gần đây</a>,
            quản lý của bạn
            <a class="btn btn-link link-to-tab" href="#address">địa chỉ giao hàng và thanh toán
            </a>, và
            <a class="btn btn-link link-to-tab" href="#edit">chỉnh sửa mật khẩu và chi tiết tài khoản của bạn.</a>
        </p>

        <div class="mb-4"></div>

        <div class="row row-lg">
            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="#order" class="link-to-tab"><i class="sicon-social-dropbox"></i></a>
                    <div class="feature-box-content">
                        <h3>ĐƠN HÀNG</h3>
                    </div>
                </div>
            </div>

            {{-- <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="#download" class="link-to-tab"><i class="sicon-cloud-download"></i></a>
                    <div class=" feature-box-content">
                        <h3>TẢI XUỐNG</h3>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="#address" class="link-to-tab"><i class="sicon-location-pin"></i></a>
                    <div class="feature-box-content">
                        <h3>ĐỊA CHỈ</h3>
                    </div>
                </div>
            </div> --}}

            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="#edit" class="link-to-tab"><i class="icon-user-2"></i></a>
                    <div class="feature-box-content p-0">
                        <h3>CHI TIẾT TÀI KHOẢN</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="#withdraw" class="link-to-tab"><i class="fas fa-wallet"></i></a>
                    <div class="feature-box-content">
                        <h3>RÚT ĐIỂM</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="{{ route('wishlist.index') }}"><i class="sicon-heart"></i></a>
                    <div class="feature-box-content">
                        <h3>DANH SÁCH ƯA THÍCH</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="{{ route('login') }}"><i class="sicon-logout"></i></a>
                    <div class="feature-box-content">
                        <h3>ĐĂNG XUẤT</h3>
                    </div>
                </div>
            </div>
        </div><!-- End .row -->
    </div>
</div><!-- End .tab-pane -->
