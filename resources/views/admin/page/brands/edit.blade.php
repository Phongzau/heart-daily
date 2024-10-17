@extends('layouts.admin')

@section('title')
    Heart Daily | Brands Edit
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Brands</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card bg-light">
                        <div class="card-header bg-white">
                            <h4>Edit Brands</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.brands.update', $brands->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="">Name</label>
                                                    <input type="text" name="name" value="{{ $brands->name }}"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Description</label>
                                                    <input type="text" name="description"
                                                        value="{{ $brands->description }}" class="form-control">
                                                </div>
                                                <div class="form-group ">
                                                    <label for="inputState">Status</label>
                                                    <select id="inputState" name="status" class="form-control">
                                                        <option value="" hidden>--Select--</option>
                                                        <option {{ $brands->status == 1 ? 'selected' : '' }} value="1">
                                                            Active
                                                        </option>
                                                        <option {{ $brands->status == 0 ? 'selected' : '' }} value="0">
                                                            Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group"
                                                    style="display: flex; flex-direction: column; align-items: center;">
                                                    <!-- Hiển thị ảnh cũ -->
                                                    <div
                                                        style="width: 200px; display: flex; flex-direction: column; align-items: center;">
                                                        <label style="width: 100%; text-align: center"
                                                            for="">Image</label>
                                                        <br>
                                                        <img id="currentImage"
                                                            style="width: 100%; padding: 0 10px;max-height: 300px;"
                                                            src="{{ Storage::url($brands->image) }}">

                                                        <!-- Hiển thị ảnh preview cho ảnh mới, mặc định sẽ ẩn -->
                                                        <img id="imagePreview"
                                                            style="width: 100%; padding: 0 10px;max-height: 300px; display: none;"
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
                                                            <button type="button" id="deleteImageButton"
                                                                class="btn btn-danger"
                                                                style="display: none; padding: 0.5rem 1rem; border-radius: 10px; background-color:red; color: #fff;">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
