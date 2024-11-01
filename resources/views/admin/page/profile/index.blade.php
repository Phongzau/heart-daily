@extends('layouts.admin')

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">{{-- d-flex justify-content-center --}}
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data"
                            class="needs-validation" novalidate="">
                            @csrf
                            {{-- @method('PUT') --}}
                            <div class="card-header">
                                <h4>Update Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="display: flex; flex-direction: column;">
                                            <!-- Hiển thị ảnh cũ -->
                                            <div
                                                style="width: 200px; display: flex; flex-direction: column; align-items: center;">
                                                <label style="width: 100%; text-align: center" for="">Profile
                                                    Picture</label>
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
                                                <div style="display: flex; gap: 10px; margin: 10px;"
                                                    id="deleteImageButtonContainer">
                                                    <!-- Nút upload ảnh mới -->
                                                    <label for="imageUpload"
                                                        style="padding: 0.5rem 1rem; margin-bottom: unset !important; border-radius: 10px; background-color: black; color: #fff; display: flex; justify-content: center; align-items: center">Upload
                                                        Image</label>
                                                    <input type="file" name="image" id="imageUpload"
                                                        class="form-control" accept="image/*" style="display: none">

                                                    <!-- Nút xóa ảnh mới, mặc định sẽ ẩn -->
                                                    <button type="button" id="deleteImageButton" class="btn btn-danger"
                                                        style="display: none; padding: 0.5rem 1rem; border-radius: 10px; background-color:red; color: #fff;">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" readonly
                                            value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-sm-4">{{-- d-flex justify-content-center --}}
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" action="{{ route('admin.password.update') }}" class="needs-validation"
                            novalidate="">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>Update Password</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Current Password</label>
                                        <input type="password" class="form-control" name="current_password">
                                    </div>
                                    <div class="form-group col-12">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" name="new_password">
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="new_password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>

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
@endsection
