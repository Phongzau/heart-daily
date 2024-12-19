<div class="tab-pane fade" id="edit" role="tabpanel">
    <h3 class="account-sub-title d-none d-md-block mt-0 pt-1 ml-1"><i class="icon-user-2 align-middle mr-3 pr-1"></i>Chi
        tiết</h3>
    <div class="account-content">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" style="display: flex; flex-direction: column;">
                        <!-- Hiển thị ảnh cũ -->
                        <div style="width: 200px; display: flex; flex-direction: column; align-items: center;">
                            <label style="width: 100%; text-align: center" for="">Ảnh hồ sơ</label>
                            <br>
                            <img id="currentImage"
                                style="width: 100%; padding: 0 10px;max-height: 300px; border-radius: 50%"
                                src="{{ Storage::url(Auth::user()->image) }}">

                            <!-- Hiển thị ảnh preview cho ảnh mới, mặc định sẽ ẩn -->
                            <img id="imagePreview"
                                style="width: 100%; padding: 0 10px;max-height: 300px; display: none; border-radius: 50%"
                                alt="New Image Preview">
                        </div>

                        <!-- Nút upload ảnh và remove -->
                        <div class="form-group">
                            <div style="display: flex; gap: 10px; margin: 10px;" id="deleteImageButtonContainer">
                                <!-- Nút upload ảnh mới -->
                                <label for="imageUpload"
                                    style="padding: 0.5rem 1rem; margin-bottom: unset !important; border-radius: 10px; background-color: black; color: #fff; display: flex; justify-content: center; align-items: center">
                                    Tải ảnh lên...</label>
                                <input type="file" name="image" id="imageUpload" class="form-control"
                                    accept="image/*" style="display: none">

                                <!-- Nút xóa ảnh mới, mặc định sẽ ẩn -->
                                <button type="button" id="deleteImageButton" class="btn btn-danger"
                                    style="display: none; padding: 0.5rem 1rem; border-radius: 10px; background-color:red; color: #fff;">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="acc-name">Tên<span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="Nhập tên của bạn" id="first_name"
                            name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" required />
                    </div>
                </div>
                <br>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="acc-lastname">Họ<span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="Nhập họ của bạn" id="last_name"
                            name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}"required />
                    </div>
                </div>
            </div>

            <div class="form-group mb-2">
                <label for="display_name">Họ & tên<span class="required">*</span></label>
                <input type="text" class="form-control" id="display_name" name="display_name"
                    placeholder="Nhập đầy đủ họ & tên" value="{{ old('display_name', Auth::user()->display_name) }}"
                    required />
                <p>Đây sẽ là tên của bạn hiển thị trong phần tài khoản và trong đánh giá</p>
            </div>

            <div class="form-group mb-2">
                <label for="acc-email">Địa chỉ email<span class="required">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="editor@gmail.com"
                    readonly value="{{ old('email', Auth::user()->email) }}" required />
            </div>
            <button type="submit" class="btn btn-dark mr-0 mb-4">
                Lưu thay đổi
            </button>
        </form>
        <hr>
        <div class="row ml-1">
            <h3 class="text-uppercase">2FA</h3>
        </div>
        <div class="form-footer mb-1">
            @if(auth()->user()->google2fa_enabled == 1)
            <button type="button" class="btn btn-dark mr-0" data-toggle="modal" data-target="#disable2FAModal">
                Tắt
            </button>
            @else
            <button type="button" class="btn btn-dark mr-0" data-toggle="modal" data-target="#enable2FAModal">
                Bật
            </button>
            @endif
        </div>

        <form method="POST" action="{{ route('reset.password.submit') }}" enctype="multipart/form-data" id="resetPasswordForm">
            @csrf
            @method('PUT')
            <div class="change-password">
                <h3 class="text-uppercase mb-2">Thay đổi mật khẩu</h3>

                <div class="form-group">
                    <label for="password">Mật khẩu hiện tại</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" />
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" />
                </div>

                <div class="form-group">
                    <label for="password">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" id="new_password_confirmation"
                        name="new_password_confirmation" />
                </div>
                <input type="hidden" id="two_factor_code_hidden" name="two_factor_code" />
            </div>

            <div class="form-footer mt-3 mb-0">
                <button type="button" class="btn btn-dark mr-0" id="resetPasswordButton">
                    Lưu thay đổi
                </button>
            </div>
        </form>



    </div>

</div><!-- End .tab-pane -->
<!-- Modal Xác Nhận 2FA -->
<div class="modal fade" id="verify2FAModal" tabindex="-1" role="dialog" aria-labelledby="verify2FAModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verify2FAModalLabel">Xác nhận 2FA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="verify2FAForm">
                    <div class="form-group">
                        <label for="two_factor_code">Mã xác thực 2FA</label>
                        <input type="text" class="form-control" id="two_factor_code" name="two_factor_code" required />
                    </div>
                    <button type="button" class="btn btn-primary" id="submit2FA">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal tắt 2FA -->
<div class="modal fade" id="disable2FAModal" tabindex="-1" role="dialog" aria-labelledby="disable2FAModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disable2FAModalLabel">Tắt xác thực 2 yếu tố</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.disable2fa') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="one_time_password">Nhập mã từ ứng dụng:</label>
                        <input type="text" class="form-control" name="one_time_password" id="one_time_password" placeholder="Nhập mã OTP" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal bật 2FA -->
<div class="modal fade" id="enable2FAModal" tabindex="-1" role="dialog" aria-labelledby="enable2FAModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enable2FAModalLabel">Kích hoạt xác thực 2 yếu tố</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Quét mã QR</h5>
                <p>Sử dụng ứng dụng xác thực như Google Authenticator để quét mã QR dưới đây:</p>
                <div class="text-center">{!! $qrCodeUrl !!}</div>


                <h5 class="mt-2">Hoặc nhập mã thủ công</h5>
                <p>Nếu bạn không thể quét mã QR, hãy nhập mã thủ công dưới đây vào ứng dụng:</p>
                <p><strong>Mã thủ công (Secret Key):</strong> <code>{{ $secret }}</code></p>
                <ul>
                    <li>Mở ứng dụng Google Authenticator.</li>
                    <li>Nhấn vào nút <strong>"+"</strong>, chọn <strong>"Nhập khóa thiết lập"</strong>.</li>
                    <li>Nhập tên tài khoản (VD: Laravel hoặc email của bạn).</li>
                    <li>Nhập mã khóa: <code>{{ $secret }}</code>.</li>
                    <li>Chọn loại mã: <strong>Time-based (Thời gian)</strong>.</li>
                </ul>
                <form action="{{ route('user.verify2fa') }}" method="POST">
                    @csrf
                    <input type="text" class="form-control" name="one_time_password" id="one_time_password"
                        placeholder="Nhập mã từ ứng dụng" required autocomplete="off" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary" id="enable2FABtn">Kích hoạt</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript để hiển thị ảnh preview và xử lý nút "Remove New Image" -->
<script>
document.getElementById('resetPasswordButton').addEventListener('click', function () {
    fetch('{{ route('check.2fa.status') }}')
        .then(response => response.json())
        .then(data => {
            if (data.two_fa_enabled) {
                // Reset giá trị của input mã 2FA
                document.getElementById('two_factor_code').value = '';

                // Hiển thị modal
                $('#verify2FAModal').modal('show');
            } else {
                // Nếu không bật 2FA, submit form trực tiếp
                document.getElementById('resetPasswordForm').submit();
            }
        });
});

document.getElementById('submit2FA').addEventListener('click', function () {
    const code = document.getElementById('two_factor_code').value;
    if (code) {
        // Gán giá trị mã 2FA vào input ẩn
        document.getElementById('two_factor_code_hidden').value = code;

        // Ẩn modal
        $('#verify2FAModal').modal('hide');

        // Submit form
        document.getElementById('resetPasswordForm').submit();
    } else {
        alert('Vui lòng nhập mã 2FA!');
    }
});

// Reset trạng thái modal khi đóng (optional)
$('#verify2FAModal').on('hidden.bs.modal', function () {
    document.getElementById('two_factor_code').value = '';
});


    
    document.getElementById('imageUpload').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Lấy file người dùng chọn
        if (file) {
            const reader = new FileReader(); // Khởi tạo đối tượng FileReader

            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview'); // Thẻ img preview
                const currentImage = document.getElementById('currentImage'); // Thẻ img hiện tại
                const deleteButton = document.getElementById('deleteImageButton'); // Nút xóa ảnh

                // Gán kết quả vào thẻ img preview
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Hiển thị ảnh preview
                currentImage.style.display = 'none'; // Ẩn ảnh cũ
                deleteButton.style.display = 'inline-block'; // Hiển thị nút xóa
            };

            reader.readAsDataURL(file); // Đọc file và chuyển thành URL
        }
    });

    // Xử lý nút "Remove New Image"
    document.getElementById('deleteImageButton').addEventListener('click', function() {
        const imageUploadInput = document.getElementById('imageUpload'); // Input upload file
        const imagePreview = document.getElementById('imagePreview'); // Thẻ img preview
        const currentImage = document.getElementById('currentImage'); // Thẻ img hiện tại
        const deleteButton = document.getElementById('deleteImageButton'); // Nút xóa ảnh

        // Reset input file và ẩn ảnh mới, hiện lại ảnh cũ
        imageUploadInput.value = '';
        imagePreview.style.display = 'none'; // Ẩn ảnh mới
        currentImage.style.display = 'block'; // Hiển thị lại ảnh cũ
        deleteButton.style.display = 'none'; // Ẩn nút xóa
    });
</script>
