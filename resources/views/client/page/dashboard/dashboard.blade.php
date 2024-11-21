@extends('layouts.client')

@section('css')
    <style>
        /* Kiểu dáng cho phần lọc */
        .filter-section {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        /* Căn chỉnh button sang bên phải */
        .button-container {
            margin-left: auto;
            /* Đẩy nút sang bên phải */
        }

        .filter-section label {
            font-weight: 500;
            color: #333;
        }

        .filter-section select,
        .filter-section input[type="date"] {
            padding: 8px 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            font-size: 14px;
            color: #555;
            background-color: #fff;
            transition: border-color 0.3s;
        }

        .filter-section select:focus,
        .filter-section input[type="date"]:focus {
            border-color: #007bff;
        }

        .filter-section button {
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .filter-section button:hover {
            background-color: #0056b3;
        }

        .order-content {
            border: 1px solid #eaeaea;
            padding: 20px;
            background-color: #fff;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            padding-bottom: 10px;
            border-bottom: 1px solid #eaeaea;
            margin-bottom: 10px;
        }

        .hidden {
            display: none;
        }

        .hidden-product {
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        hr {
            margin: 0;
            /* Xóa khoảng cách margin */
            padding: 0;
            /* Xóa khoảng cách padding */
            border: none;
            /* Xóa đường viền mặc định của hr */
            border-top: 1px solid #ddd;
            /* Tạo đường viền trên */
        }

        .order-shop {
            color: #0088cc;
        }

        .order-status {
            color: #ee4d2d;
        }

        .order-body {
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        .order-body:last-child {
            border-bottom: none;
        }

        .order-product {
            display: flex;
            flex-grow: 1;
        }

        .order-footer {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        .total-label {
            font-size: 16px;
            color: #333;
        }

        .order-buttons {
            display: flex;
            gap: 10px;
        }

        .product-image {
            width: 18% !important;
            height: 70px !important;
            object-fit: cover !important;
            border-radius: 10px;
            border: 1px solid #bdb3b3;
            margin-right: 15px;
        }

        .product-details {
            flex-grow: 1;
            width: 90%;
        }

        .product-name {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .product-quantity {
            font-size: 14px;
            color: #999;
        }

        .btn-return {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 12px;
            cursor: pointer;
            margin-top: 10px;
        }

        .product-price {
            text-align: right;
        }

        .original-price {
            color: #999;
            font-size: 14px;
        }

        .discounted-price {
            color: rgb(45, 44, 44);
            font-size: 16px;
            font-weight: bold;
        }

        .order-summary {
            text-align: right;
            font-size: 16px;
        }

        .total-price {
            color: rgb(45, 44, 44);
            font-size: 18px;
            font-weight: bold;
        }

        .order-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        .order-buttons .btn {
            border-radius: 5px;
        }

        .btn-confirm,
        .btn-cancel,
        .btn-contact {
            padding: 8px 12px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            color: #fff;
        }

        .btn-confirm {
            background-color: #4CAF50;
        }

        .btn-cancel {
            background-color: #ff9f00;
        }

        .btn-contact {
            background-color: #ee4d2d;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 25%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
@endsection

@section('section')
    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="demo4.html">TRang chủ</a></li>
                        <li class="breadcrumb-item"><a href="category.html">Cửa hàng</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tài khoản của bạn
                        </li>
                    </ol>
                </div>
            </nav>

            <h1>Tài khoản của bạn</h1>
        </div>
    </div>

    <div class="container account-container custom-account-container">
        <div class="row">
            <div class="sidebar widget widget-dashboard mb-lg-0 mb-3 col-lg-3 order-0">
                <!-- <h2 class="text-uppercase">Tài khoản của bạn</h2> -->
                <ul class="nav nav-tabs list flex-column mb-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab"
                            aria-controls="dashboard" aria-selected="true">Trang tổng quan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="order-tab" data-toggle="tab" href="#order" role="tab"
                            aria-controls="order" aria-selected="true">Đơn đặt hàng</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="download-tab" data-toggle="tab" href="#download" role="tab"
                            aria-controls="download" aria-selected="false">Tải xuống</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab"
                            aria-controls="address" aria-selected="false">Địa chỉ</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab"
                            aria-controls="edit" aria-selected="false">
                            Thông tin tài khoản</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="shop-address-tab" data-toggle="tab" href="#shipping" role="tab"
                            aria-controls="edit" aria-selected="false">Địa chỉ mua sắm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('wishlist.index') }}">Yêu thích</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Đăng xuất</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9 order-lg-last order-1 tab-content dashboard-section">
                @include('client.page.dashboard.sections.dashboard')

                @include('client.page.dashboard.sections.order')

                @include('client.page.dashboard.sections.download')

                @include('client.page.dashboard.sections.address')

                @include('client.page.dashboard.sections.account-details')

                @include('client.page.dashboard.sections.billing-address')

                @include('client.page.dashboard.sections.shipping-address')
            </div><!-- End .tab-content -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div id="myModalCancelOrder" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>

            <h4>Chọn lý do hủy đơn hàng</h4>

            <select id="cancelReason" class="form-control">
                <option value="">Chọn lý do...</option>
                <option value="khong_muon_mua_nua">Không muốn mua nữa</option>
                <option value="gia_re_hon_o_noi_khac">Giá rẻ hơn ở nơi khác</option>
                <option value="thay_doi_dia_chi_giao_hang">Thay đổi địa chỉ giao hàng</option>
                <option value="thay_doi_phuong_thuc_thanh_toan">Thay đổi phương thức thanh toán</option>
                <option value="thay_doi_ma_giam_gia">Thay đổi mã giảm giá</option>
                <option value="ly_do_khac">Lý do khác</option>
            </select>

            <!-- Ô nhập lý do khác -->
            <div id="otherReasonDiv" style="display: none;">
                <textarea id="otherReason" class="form-control" placeholder="Nhập lý do của bạn..."></textarea>
            </div>

            <br>
            <!-- Nút hủy đơn hàng -->
            <button id="cancelOrderButton" class="btn btn-danger">Hủy đơn hàng</button>
        </div>
    </div>

    <div id="myModalReturnOrder" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>

            <h4>Chọn lý do trả hàng</h4>

            <select id="returnReason" class="form-control">
                <option value="">Chọn lý do...</option>
                <option value="san_pham_loi">Sản phẩm bị lỗi</option>
                <option value="giao_sai_san_pham">Giao sai sản phẩm</option>
                <option value="san_pham_khong_giong_quang_cao">Sản phẩm không giống quảng cáo</option>
                <option value="giao_hang_tre_hon_du_kien">Giao hàng trễ hơn dự kiến</option>
                <option value="khong_con_nhu_cau">Không còn nhu cầu</option>
                <option value="ly_do_khac">Lý do khác</option>
            </select>

            <!-- Ô nhập lý do khác -->
            <div id="otherReasonOrderDiv" style="display: none;">
                <textarea id="otherOrderReason" class="form-control" placeholder="Nhập lý do của bạn..."></textarea>
            </div>

            <br>

            <!-- Input tải video -->
            <label for="returnVideo">Tải lên video sản phẩm: <code>(Tối đa: 50MB)</code></label>
            <input type="file" id="returnVideo" class="form-control" accept="video/*">

            <!-- Hiển thị video xem trước -->
            <video id="videoPreview" controls
                style="display: none; width: 100%; max-height: 300px; margin-top: 10px;"></video>

            <br>
            <!-- Cảnh báo dung lượng quá lớn -->
            <div id="fileSizeWarning" style="display: none; color: red; margin-top: 0px; margin-bottom: 10px;">
                Video quá lớn! Vui lòng chọn
                video có dung lượng dưới 50MB.</div>
            <!-- Nút gửi yêu cầu trả hàng -->
            <button id="returnOrderButton" class="btn btn-primary">Gửi yêu cầu trả hàng</button>
        </div>
    </div>
    <div class="mb-5"></div><!-- margin -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            $(document).on('click', '#myBtnCancelOrder', function() {
                $('#myModalCancelOrder').fadeIn();
                let orderId = $(this).data('order-id');
                $('#cancelOrderButton').data('id-order', orderId);
            })

            $(".close").click(function() {
                $("#myModalCancelOrder").fadeOut();
            });

            $(window).click(function(event) {
                if ($(event.target).is("#myModalCancelOrder")) {
                    $("#myModalCancelOrder").fadeOut();
                }
            });

            $(document).on('click', '#myBtnReturnOrder', function() {
                $('#myModalReturnOrder').fadeIn();
                let orderId = $(this).data('order-id');
                $('#returnOrderButton').data('id-order', orderId);
            })

            $(".close").click(function() {
                $("#myModalReturnOrder").fadeOut();
            });

            $(window).click(function(event) {
                if ($(event.target).is("#myModalReturnOrder")) {
                    $("#myModalReturnOrder").fadeOut();
                }
            });

            $("#returnVideo").on("change", function() {
                const file = this.files[0];
                const videoPreview = $("#videoPreview");
                const fileSizeWarning = $("#fileSizeWarning");

                if (file) {
                    // Kiểm tra dung lượng video không quá 50MB (50MB = 50 * 1024 * 1024 byte)
                    if (file.size > 50 * 1024 * 1024) {
                        // Nếu video vượt quá 50MB, ẩn video preview và hiển thị cảnh báo
                        videoPreview.hide();
                        fileSizeWarning.show();
                        $("#returnVideo").val(""); // Reset input
                    } else {
                        // Nếu video dưới 50MB, hiển thị video xem trước
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            videoPreview.attr("src", e.target.result).show();
                            fileSizeWarning.hide(); // Ẩn cảnh báo
                        };
                        reader.readAsDataURL(file);
                    }
                } else {
                    videoPreview.hide();
                    fileSizeWarning.hide();
                    $("#returnVideo").val(""); // Reset input
                }
            });

            $(document).on('click', '#returnOrderButton', function() {
                var orderId = $(this).data('id-order');

                var returnReason = $('#returnReason').val();
                var otherOrderReason = $('#otherOrderReason').val();
                var videoFile = $('#returnVideo')[0].files[0]; // Lấy file video từ input
                console.log(videoFile);

                // Kiểm tra nếu chưa chọn lý do hủy
                if (returnReason === '') {
                    toastr.error("Vui lòng chọn lý do hủy.");
                    return;
                }

                // Kiểm tra lý do hủy và tiến hành hủy đơn hàng
                if (returnReason === 'ly_do_khac' && otherOrderReason.trim() === '') {
                    toastr.error("Vui lòng nhập lý do của bạn.");
                    return;
                }

                // Kiểm tra nếu không có video được chọn hoặc video không phải là file hợp lệ
                if (videoFile) {
                    // Kiểm tra loại file có phải là video không
                    if (!videoFile.type.startsWith('video/')) {
                        toastr.error("Vui lòng chọn một file video hợp lệ.");
                        return;
                    }
                } else {
                    toastr.error("Vui lòng tải lên video.");
                    return;
                }

                // Lấy số trang hiện tại từ link phân trang cuối cùng trong danh sách
                var currentPage = $('#pagination-links .page-item.active .page-link').text() || 1;
                var status = $('#status').val(); // Lấy trạng thái đã chọn
                var fromDate = $('#from_date').val(); // Lấy ngày bắt đầu
                var toDate = $('#to_date').val(); // Lấy ngày kết thúc

                Swal.fire({
                    title: "Bạn có chắc không?", // Tiêu đề hộp thoại
                    text: "Bạn sẽ không thể quay trở lại khi thực hiện", // Nội dung thông báo
                    icon: "warning", // Biểu tượng cảnh báo
                    showCancelButton: true, // Hiển thị nút hủy
                    confirmButtonColor: "#3085d6", // Màu của nút xác nhận
                    cancelButtonColor: "#d33", // Màu của nút hủy
                    confirmButtonText: "Đồng ý ", // Văn bản của nút xác nhận
                    cancelButtonText: "Hủy", // Văn bản của nút hủy
                }).then((result) => {
                    // Nếu người dùng xác nhận xóa (click nút "Đồng ý ")
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('orderId', orderId);
                        formData.append('page', currentPage);
                        formData.append('status', status);
                        formData.append('from_date', fromDate);
                        formData.append('to_date', toDate);
                        formData.append('returnReason', returnReason === 'ly_do_khac' ?
                            otherOrderReason : returnReason);
                        formData.append('videoPath', videoFile);

                        $.ajax({
                            url: "{{ route('return-order') }}",
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                if (data.status === 'success') {
                                    Swal.fire({
                                        title: "Đã gửi đơn hoàn hàng!",
                                        text: data
                                            .message,
                                        icon: "success"
                                    });
                                    $('#order-list').html(data
                                        .updatedOrderHtml);
                                    $('#pagination-links a').each(function() {
                                        var newUrl = $(this).attr('href')
                                            .replace(
                                                '/return-order',
                                                '/user/dashboard');
                                        $(this).attr('href', newUrl);
                                    });
                                    $("#myModalReturnOrder").fadeOut();
                                    // Reset tất cả input và video preview
                                    $('#returnReason').val('');
                                    $('#otherOrderReason').val('');
                                    $('#returnVideo').val('');
                                    $('#videoPreview').hide().attr('src', '');
                                    $('#fileSizeWarning').hide();
                                    $('#otherReasonOrderDiv').hide();
                                } else if (data.status === 'error') {
                                    toastr.error(data.message);
                                }
                            },
                            error: function(data) {
                                toastr.error(data.message);
                            }
                        })
                    }
                });
            });

            // $("#returnVideo").on("change", function() {
            //     const file = this.files[0];
            //     const videoPreview = $("#videoPreview");

            //     if (file && file.type.startsWith("video/")) {
            //         const reader = new FileReader();
            //         reader.onload = function(e) {
            //             videoPreview.attr("src", e.target.result).show();
            //             // Kiểm tra độ dài video
            //             const videoElement = document.createElement('video');
            //             videoElement.src = e.target.result;

            //             videoElement.onloadedmetadata = function() {
            //                 const duration = videoElement
            //                     .duration; // Thời gian video tính bằng giây
            //                 if (duration > 60) { // Kiểm tra video có dài hơn 1 phút không
            //                     alert("Video phải có độ dài dưới 1 phút.");
            //                     $("#returnVideo").val(""); // Reset input
            //                     videoPreview.hide(); // Ẩn video preview
            //                 }
            //             };
            //         };
            //         reader.readAsDataURL(file);
            //     } else {
            //         videoPreview.hide().attr("src", "");
            //     }
            // });

            // Khi người dùng chọn lý do "Lý do khác"
            $('#returnReason').change(function() {
                if ($(this).val() === 'ly_do_khac') {
                    $('#otherReasonOrderDiv').show();
                } else {
                    $('#otherReasonOrderDiv').hide();
                }
            });

            // Khi người dùng chọn lý do "Lý do khác"
            $('#cancelReason').change(function() {
                if ($(this).val() === 'ly_do_khac') {
                    $('#otherReasonDiv').show();
                } else {
                    $('#otherReasonDiv').hide();
                }
            });

            $(document).on('click', '#cancelOrderButton', function() {
                var orderId = $(this).data('id-order');
                console.log(orderId);

                var cancelReason = $('#cancelReason').val();
                var otherReason = $('#otherReason').val();

                // Kiểm tra nếu chưa chọn lý do hủy
                if (cancelReason === '') {
                    toastr.error("Vui lòng chọn lý do hủy.");
                    return;
                }

                // Kiểm tra lý do hủy và tiến hành hủy đơn hàng
                if (cancelReason === 'ly_do_khac' && otherReason.trim() === '') {
                    toastr.error("Vui lòng nhập lý do của bạn.");
                    return;
                }

                // Lấy số trang hiện tại từ link phân trang cuối cùng trong danh sách
                var currentPage = $('#pagination-links .page-item.active .page-link').text() || 1;
                var status = $('#status').val(); // Lấy trạng thái đã chọn
                var fromDate = $('#from_date').val(); // Lấy ngày bắt đầu
                var toDate = $('#to_date').val(); // Lấy ngày kết thúc

                Swal.fire({
                    title: "Bạn có chắc không?", // Tiêu đề hộp thoại
                    text: "Bạn sẽ không thể quay trở lại khi thực hiện", // Nội dung thông báo
                    icon: "warning", // Biểu tượng cảnh báo
                    showCancelButton: true, // Hiển thị nút hủy
                    confirmButtonColor: "#3085d6", // Màu của nút xác nhận
                    cancelButtonColor: "#d33", // Màu của nút hủy
                    confirmButtonText: "Đồng ý ", // Văn bản của nút xác nhận
                    cancelButtonText: "Hủy", // Văn bản của nút hủy
                }).then((result) => {
                    // Nếu người dùng xác nhận xóa (click nút "Đồng ý ")
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('cancel-order') }}",
                            method: "POST",
                            data: {
                                orderId: orderId,
                                page: currentPage,
                                status: status,
                                from_date: fromDate,
                                to_date: toDate,
                                cancelReason: cancelReason === 'ly_do_khac' ? otherReason :
                                    cancelReason,
                            },
                            success: function(data) {
                                if (data.status === 'success') {
                                    Swal.fire({
                                        title: "Đã hủy!",
                                        text: data
                                            .message,
                                        icon: "success"
                                    });
                                    $('#order-list').html(data
                                        .updatedOrderHtml);
                                    $('#pagination-links a').each(function() {
                                        var newUrl = $(this).attr('href')
                                            .replace(
                                                '/cancel-order',
                                                '/user/dashboard');
                                        $(this).attr('href', newUrl);
                                    });
                                    $("#myModalCancelOrder").fadeOut();
                                } else if (data.status === 'error') {
                                    toastr.error(data.message);
                                }
                            },
                            error: function(data) {
                                toastr.error(data.message);
                            }
                        })
                    }
                });
            });

            // Gán sự kiện click cho nút "Hiển thị thêm sản phẩm" ngay cả khi nó được tạo mới
            $(document).on('click', '.show-more', function() {
                var hiddenProducts = $(this).closest('.order-content').find('.hidden-products');

                hiddenProducts.toggleClass('hidden'); // Hiện/Ẩn sản phẩm

                // Cập nhật nội dung của nút
                if (hiddenProducts.hasClass('hidden')) {
                    $(this).html(
                        'Hiển thị thêm sản phẩm<i style="margin-left: 5px;" class="fas fa-chevron-down"></i>'
                    );
                } else {
                    $(this).html(
                        'Ẩn bớt sản phẩm<i style="margin-left: 5px;" class="fas fa-chevron-up"></i>'
                    );
                }
            });

            $(document).on('click', '.cancel-order-return', function() {
                var orderId = $(this).data('order-id');

                Swal.fire({
                    title: "Bạn có chắc không?", // Tiêu đề hộp thoại
                    text: "Bạn sẽ không thể quay trở lại khi thực hiện", // Nội dung thông báo
                    icon: "warning", // Biểu tượng cảnh báo
                    showCancelButton: true, // Hiển thị nút hủy
                    confirmButtonColor: "#3085d6", // Màu của nút xác nhận
                    cancelButtonColor: "#d33", // Màu của nút hủy
                    confirmButtonText: "Đồng ý ", // Văn bản của nút xác nhận
                    cancelButtonText: "Hủy", // Văn bản của nút hủy
                }).then((result) => {
                    // Nếu người dùng xác nhận xóa (click nút "Đồng ý ")
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('cancel-order-return') }}",
                            method: "POST",
                            data: {
                                orderId: orderId,
                            },
                            success: function(data) {
                                if (data.status === 'success') {
                                    Swal.fire({
                                        title: "Đã hủy!",
                                        text: data
                                            .message,
                                        icon: "success"
                                    });
                                    $('#order-list').html(data
                                        .updatedOrderHtml);
                                    $('#pagination-links a').each(function() {
                                        var newUrl = $(this).attr('href')
                                            .replace(
                                                '/cancel-order-return',
                                                '/user/dashboard');
                                        $(this).attr('href', newUrl);
                                    });
                                } else if (data.status === 'error') {
                                    toastr.error(data.message);
                                }
                            },
                            error: function(data) {
                                toastr.error(data.message);
                            }
                        })
                    }
                });
            });

            $(document).on('click', '.reorder-button', function() {
                var orderId = $(this).data('order-id');

                Swal.fire({
                    title: "Bạn có chắc không?", // Tiêu đề hộp thoại
                    text: "Bạn sẽ không thể quay trở lại khi thực hiện", // Nội dung thông báo
                    icon: "warning", // Biểu tượng cảnh báo
                    showCancelButton: true, // Hiển thị nút hủy
                    confirmButtonColor: "#3085d6", // Màu của nút xác nhận
                    cancelButtonColor: "#d33", // Màu của nút hủy
                    confirmButtonText: "Đồng ý ", // Văn bản của nút xác nhận
                    cancelButtonText: "Hủy", // Văn bản của nút hủy
                }).then((result) => {
                    // Nếu người dùng xác nhận xóa (click nút "Đồng ý ")
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('re-order') }}",
                            method: "POST",
                            data: {
                                orderId: orderId,
                            },
                            success: function(data) {
                                if (data.status === 'success') {
                                    window.location.href = data.url;
                                } else if (data.status === 'error') {
                                    toastr.warning(data.message);
                                }
                            },
                            error: function(data) {
                                toastr.error(data.message);
                            }
                        })
                    }
                });
            });


            $(document).on('click', '.confirm-order-button', function() {
                var orderId = $(this).data('order-id');
                // Lấy số trang hiện tại từ link phân trang cuối cùng trong danh sách
                var currentPage = $('#pagination-links .page-item.active .page-link').text() || 1;
                var status = $('#status').val(); // Lấy trạng thái đã chọn
                var fromDate = $('#from_date').val(); // Lấy ngày bắt đầu
                var toDate = $('#to_date').val(); // Lấy ngày kết thúc

                $.ajax({
                    url: "{{ route('confirm-order') }}",
                    method: "POST",
                    data: {
                        orderId: orderId,
                        page: currentPage,
                        status: status,
                        from_date: fromDate,
                        to_date: toDate
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            $('#order-list').html(data
                                .updatedOrderHtml);
                            $('#pagination-links a').each(function() {
                                var newUrl = $(this).attr('href').replace(
                                    '/confirm-order', '/user/dashboard');
                                $(this).attr('href', newUrl);
                            });
                        } else if (data.status === 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        console.log(data);

                        toastr.error('Có lỗi rồi');
                    }
                })
            });

            // Cập nhật sự kiện click cho phân trang sau khi AJAX tải lại
            $(document).on('click', '#pagination-links a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#order-list').html(data);

                        // // Lặp lại phần cập nhật URL phân trang
                        // $('#pagination-links a').each(function() {
                        //     var newUrl = $(this).attr('href').replace('/cancel-order',
                        //         '/user/dashboard');
                        //     $(this).attr('href', newUrl);
                        // });
                    }
                });
            });

            $('#btn-search-order').click(function() {
                // Lấy các giá trị từ form lọc
                var status = $('#status').val();
                var fromDate = $('#from_date').val();
                var toDate = $('#to_date').val();
                console.log(status, fromDate, toDate);

                // Tạo đối tượng dữ liệu để gửi đi
                var data = {
                    status: status,
                    from_date: fromDate,
                    to_date: toDate,
                    page: 1 // Trang mặc định, có thể thay đổi nếu cần
                };

                // Gửi yêu cầu AJAX
                $.ajax({
                    url: "{{ route('user.dashboard') }}",
                    method: 'GET', // Hoặc 'POST' nếu cần
                    data: data,
                    success: function(html) {
                        // Cập nhật danh sách đơn hàng trên giao diện
                        $('#order-list').html(html);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching data:', textStatus, errorThrown);
                    }
                });
            });
        });
    </script>
@endpush
