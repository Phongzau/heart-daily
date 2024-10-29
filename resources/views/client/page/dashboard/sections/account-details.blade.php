<div class="tab-pane fade" id="edit" role="tabpanel">
    <h3 class="account-sub-title d-none d-md-block mt-0 pt-1 ml-1"><i
            class="icon-user-2 align-middle mr-3 pr-1"></i>Account Details</h3>
    <div class="account-content">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" style="display: flex; flex-direction: column;">
                        <!-- Hiển thị ảnh cũ -->
                        <div style="width: 200px; display: flex; flex-direction: column; align-items: center;">
                            <label style="width: 100%; text-align: center" for="">Profile Picture</label>
                            <br>
                            <img id="currentImage" style="width: 100%; padding: 0 10px;max-height: 300px; border-radius: 50%"
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
                                    style="padding: 0.5rem 1rem; margin-bottom: unset !important; border-radius: 10px; background-color: black; color: #fff; display: flex; justify-content: center; align-items: center">Upload
                                    Image</label>
                                <input type="file" name="image" id="imageUpload" class="form-control"
                                    accept="image/*" style="display: none">

                                <!-- Nút xóa ảnh mới, mặc định sẽ ẩn -->
                                <button type="button" id="deleteImageButton" class="btn btn-danger"
                                    style="display: none; padding: 0.5rem 1rem; border-radius: 10px; background-color:red; color: #fff;">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="acc-name">First name <span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="Editor" id="first_name"
                            name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" required />
                    </div>
                </div>
                <br>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="acc-lastname">Last name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="{{ old('last_name', Auth::user()->last_name) }}"required />
                    </div>
                </div>
            </div>

            <div class="form-group mb-2">
                <label for="display_name">Display name <span class="required">*</span></label>
                <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Editor"
                    value="{{ old('display_name', Auth::user()->display_name) }}" required />
                <p>This will be how your name will be displayed in the account section and
                    in
                    reviews</p>
            </div>

            <div class="form-group mb-2">
                <label for="acc-email">Email address <span class="required">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="editor@gmail.com"
                    readonly value="{{ old('email', Auth::user()->email) }}" required />
            </div>
            <button type="submit" class="btn btn-dark mr-0 mb-4">
                Save changes
            </button>
        </form>
        <form method="POST" action="{{ route('reset.password.submit') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="change-password">
                <h3 class="text-uppercase mb-2">Password Change</h3>

                <div class="form-group">
                    <label for="password">Current Password (leave blank to leave
                        unchanged)</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" />
                </div>

                <div class="form-group">
                    <label for="password">New Password (leave blank to leave
                        unchanged)</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" />
                </div>

                <div class="form-group">
                    <label for="password">Confirm New Password</label>
                    <input type="password" class="form-control" id="new_password_confirmation"
                        name="new_password_confirmation" />
                </div>
            </div>

            <div class="form-footer mt-3 mb-0">
                <button type="submit" class="btn btn-dark mr-0">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</div><!-- End .tab-pane -->

<!-- JavaScript để hiển thị ảnh preview và xử lý nút "Remove New Image" -->
<script>
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
