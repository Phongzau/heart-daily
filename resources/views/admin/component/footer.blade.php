<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2024 <div class="bullet"></div> Heart Daily
    </div>
    <div class="footer-right">

    </div>
</footer>
</div>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('admin/assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/popper.js') }}"></script>
<script src="{{ asset('admin/assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="{{ asset('admin/assets/modules/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/chart.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('admin/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.min.js"></script> --}}
<script src="{{ asset('admin/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="//cdn.datatables.net/2.1.0/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.0/js/dataTables.bootstrap5.js"></script>
<script src="{{ asset('admin/assets/modules/cleave-js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('admin/assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('admin/assets/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('admin/assets/js/page/index.js') }}"></script>
<script src="{{ asset('admin/assets/js/page/forms-advanced-forms.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>


{{-- <!-- JS Libraies -->

<script src="{{ asset('admin/assets/modules/dropzonejs/min/dropzone.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('admin/assets/js/page/components-multiple-upload.js') }}"></script> --}}

<!-- Template JS File -->
<script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>
    // Nếu $errors tồn tại
    @if ($errors->any())
        // Duyệt qua tất cả mảng $errors qua biến $error
        @foreach ($errors->all() as $error)
            // Hiển thị lỗi qua toastr
            toastr.error('{{ $error }}');
        @endforeach
    @endif
</script>
<script>
    // Khi tài liệu HTML đã sẵn sàng (DOM đã được tải đầy đủ)
    $(document).ready(function() {

        // Thiết lập mặc định cho tất cả các yêu cầu AJAX để bao gồm CSRF token
        $.ajaxSetup({
            headers: {
                // Lấy giá trị CSRF token từ thẻ meta và gán vào header của yêu cầu
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Bắt sự kiện click trên các phần tử có class 'delete-item' bên trong body
        $('body').on('click', '.delete-item', function(event) {
            // Ngăn chặn hành động mặc định (ví dụ: không để trình duyệt điều hướng đến link)
            event.preventDefault();

            // Lấy URL từ thuộc tính href của phần tử vừa được click (đường dẫn xóa)
            let deleteUrl = $(this).attr('href');

            // Hiển thị hộp thoại xác nhận sử dụng SweetAlert2
            Swal.fire({
                title: "Are you sure?", // Tiêu đề hộp thoại
                text: "You won't be able to revert this!", // Nội dung thông báo
                icon: "warning", // Biểu tượng cảnh báo
                showCancelButton: true, // Hiển thị nút hủy
                confirmButtonColor: "#3085d6", // Màu của nút xác nhận
                cancelButtonColor: "#d33", // Màu của nút hủy
                confirmButtonText: "Yes, delete it!" // Văn bản của nút xác nhận
            }).then((result) => {
                // Nếu người dùng xác nhận xóa (click nút "Yes, delete it!")
                if (result.isConfirmed) {

                    // Thực hiện yêu cầu AJAX với phương thức DELETE đến URL đã lấy ở trên
                    $.ajax({
                        type: 'DELETE', // Sử dụng phương thức DELETE
                        url: deleteUrl, // Gửi yêu cầu đến URL deleteUrl

                        // Xử lý khi yêu cầu thành công
                        success: function(data) {
                            // Nếu server trả về kết quả thành công (status = 'success')
                            if (data.status == 'success') {
                                // Hiển thị thông báo "Deleted!" với SweetAlert2
                                Swal.fire({
                                    title: "Deleted!", // Tiêu đề thông báo
                                    text: data
                                        .message, // Nội dung thông báo trả về từ server
                                    icon: "success" // Biểu tượng thành công
                                });
                                // Reload lại trang sau 1 giây để cập nhật thay đổi
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);

                                // Nếu server trả về lỗi (status = 'error')
                            } else if (data.status == 'error') {
                                // Hiển thị thông báo lỗi
                                Swal.fire({
                                    title: "Can't Delete", // Tiêu đề thông báo lỗi
                                    text: data
                                        .message, // Nội dung lỗi trả về từ server
                                    icon: "error", // Biểu tượng lỗi
                                });
                            }
                        },
                        // Xử lý khi yêu cầu AJAX gặp lỗi
                        error: function(xhr, status, error) {
                            console.log(error); // In lỗi ra console để kiểm tra
                        }
                    });
                }
            });
        });
    });
</script>
@stack('scripts')
@yield('scripts')
</body>

</html>
