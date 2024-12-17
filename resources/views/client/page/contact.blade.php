@extends('layouts.client')

@section('title')
    {{ $generalSettings->site_name }} || Liên hệ
@endsection

@section('section')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="demo4.html"><i class="icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Liên hệ với chúng tôi
                </li>
            </ol>
        </div>
    </nav>

    <div id="map" class="text-center">
        <iframe src="{{ $generalSettings->map }}" width="2000" height="500" style="border:0; padding:0; margin:0"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <div class="container contact-us-container">
        <div class="contact-info">
            <div class="row">
                <div class="col-12">
                    <h2 class="ls-n-25 m-b-1">
                        Công ty 5 thành viên xin chào
                    </h2>

                    <p>
                        Nếu có vấn đề gì có thể gọi điện hoặc gửi mail trực tiếp cho chúng tôi xin hân hạnh phục vụ quý
                        khách
                    </p>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="feature-box text-center">
                        <i class="sicon-location-pin"></i>
                        <div class="feature-box-content">
                            <h3>Địa chỉ</h3>
                            <h5>{{ $generalSettings->contact_address }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="feature-box text-center">
                        <i class="fa fa-mobile-alt"></i>
                        <div class="feature-box-content">
                            <h3>Số điện thoại</h3>
                            <h5>{{ $generalSettings->contact_phone }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="feature-box text-center">
                        <i class="far fa-envelope"></i>
                        <div class="feature-box-content">
                            <h3>Địa chỉ Email</h3>
                            <h5>{{ $generalSettings->contact_email }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="feature-box text-center">
                        <i class="far fa-calendar-alt"></i>
                        <div class="feature-box-content">
                            <h3>Thời gian mở cửa</h3>
                            <h5>Thứ 2 - Chủ nhật / 9h sáng - 20h tối </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- <div class="col-lg-6">
                <h2 class="mt-6 mb-2">Send Us a Message</h2>

                <form class="mb-0" action="#">
                    <div class="form-group">
                        <label class="mb-1" for="contact-name">Your Name
                            <span class="required">*</span></label>
                        <input type="text" class="form-control" id="contact-name" name="contact-name" required />
                    </div>

                    <div class="form-group">
                        <label class="mb-1" for="contact-email">Your E-mail
                            <span class="required">*</span></label>
                        <input type="email" class="form-control" id="contact-email" name="contact-email" required />
                    </div>

                    <div class="form-group">
                        <label class="mb-1" for="contact-message">Your Message
                            <span class="required">*</span></label>
                        <textarea cols="30" rows="1" id="contact-message" class="form-control" name="contact-message" required></textarea>
                    </div>

                    <div class="form-footer mb-0">
                        <button type="submit" class="btn btn-dark font-weight-normal">
                            Send Message
                        </button>
                    </div>
                </form>
            </div> --}}

            <div class="col-lg-12">
                <h2 class="mt-6 mb-1">Các câu hỏi thường hỏi</h2>
                <div id="accordion">
                    <!-- Câu hỏi 1 -->
                    <div class="card card-accordion">
                        <a class="card-header" href="#" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne">
                            Tôi có thể hủy hoặc thay đổi đơn hàng của mình không?
                        </a>
                        <div id="collapseOne" class="collapse show" data-parent="#accordion">
                            <p>Bạn có thể hủy hoặc thay đổi đơn hàng trước khi đơn hàng được xác nhận. Vui lòng liên hệ với
                                bộ phận chăm sóc khách hàng để được hỗ trợ.</p>
                        </div>
                    </div>

                    <!-- Câu hỏi 2 -->
                    <div class="card card-accordion">
                        <a class="card-header collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo">
                            Tôi có thể kiểm tra tình trạng đơn hàng của mình ở đâu?
                        </a>
                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                            <p>Bạn có thể theo dõi trạng thái đơn hàng bằng cách đăng nhập vào tài khoản của mình và chọn
                                mục “Theo dõi đơn hàng” hoặc kiểm tra email xác nhận.</p>
                        </div>
                    </div>

                    <!-- Câu hỏi 3 -->
                    <div class="card card-accordion">
                        <a class="card-header collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                            aria-expanded="false" aria-controls="collapseThree">
                            Tôi có thể đổi hoặc trả hàng không? Điều kiện như thế nào?
                        </a>
                        <div id="collapseThree" class="collapse" data-parent="#accordion">
                            <p>Chúng tôi chấp nhận đổi trả hàng trong vòng 7 ngày kể từ khi nhận được hàng, với điều kiện
                                sản phẩm chưa qua sử dụng và còn nguyên tem mác.</p>
                        </div>
                    </div>

                    <!-- Câu hỏi 4 -->
                    <div class="card card-accordion">
                        <a class="card-header collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
                            aria-expanded="false" aria-controls="collapseFour">
                            Phương thức thanh toán nào được hỗ trợ?
                        </a>
                        <div id="collapseFour" class="collapse" data-parent="#accordion">
                            <p>Chúng tôi hỗ trợ thanh toán qua COD (thanh toán khi nhận hàng), thẻ tín dụng/thẻ ghi nợ, và
                                các ví điện tử như Momo, ZaloPay.</p>
                        </div>
                    </div>

                    <!-- Câu hỏi 5 -->
                    <div class="card card-accordion">
                        <a class="card-header collapsed" href="#" data-toggle="collapse" data-target="#collapseFive"
                            aria-expanded="false" aria-controls="collapseFive">
                            Tôi có thể nhận hàng trong bao lâu sau khi đặt?
                        </a>
                        <div id="collapseFive" class="collapse" data-parent="#accordion">
                            <p>Thời gian giao hàng phụ thuộc vào địa chỉ nhận hàng. Thông thường, chúng tôi giao hàng trong
                                2-5 ngày làm việc đối với nội địa.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-8"></div>
@endsection
