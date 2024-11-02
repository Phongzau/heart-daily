@extends('layouts.admin')

@section('title')
    Heart Daily | Brands Create
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
                            <h4>Create brands</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.brands.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label class="fw-bold">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        value="{{ old('name') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="fw-bold">Description</label>
                                                    <input type="text" class="form-control" name="description"
                                                        value="{{ old('description') }}">
                                                </div>

                                                <div class="form-group ">
                                                    <label for="inputState">Status</label>
                                                    <select id="inputState" name="status" class="form-control"
                                                        value="{{ old('status') }}">
                                                        <option value="" hidden>--Select--</option>
                                                        <option {{ old('status') === '1' ? 'selected' : '' }}
                                                            value="1">Active
                                                        </option>
                                                        <option {{ old('status') === '0' ? 'selected' : '' }}
                                                            value="0">
                                                            Inactive
                                                        </option>
                                                    </select>
                                                </div>

                                                <button class="btn btn-primary" type="submit">Create</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="customField">Image Main</label>
                                                    <!-- Hình ảnh đại diện -->
                                                    <div class="image-placeholder"
                                                        style="width: 100%; height: 300px; background-color: #e9ecef; display: flex; justify-content: center; align-items: center;">
                                                        <img id="previewImage"
                                                            src="{{ asset('admin/assets/img/news/img01.jpg') }}"
                                                            alt="Ảnh đại diện" style="max-width: 100%; max-height: 100%;" />
                                                    </div>

                                                    <!-- Nút Upload và Select -->
                                                    <div class="d-flex justify-content-around mt-3">
                                                        <input type="file" id="imageUpload" name="image" class="d-none"
                                                            accept="image/*">
                                                        <button class="btn btn-dark" id="uploadBtn">Upload
                                                            file...</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                {{-- <div class="form-group">
                                    <label class="fw-bold">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label class="fw-bold">Image:</label>
                                    <input type="file" class="form-control" id="imageUpload" name="image"
                                        accept="image/*">
                                </div>

                                <!-- Thẻ img để hiển thị ảnh đã chọn -->
                                <div class="form-group">
                                    <img id="imageDisplay" src="" alt="Image preview"
                                        style="max-width: 300px; display: none;">
                                </div>

                                <div class="form-group">
                                    <label class="fw-bold">Description</label>
                                    <input type="text" class="form-control" name="description"
                                        value="{{ old('description') }}">
                                </div>

                                <div class="form-group ">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" name="status" class="form-control" value="{{ old('status') }}">
                                        <option value="" hidden>--Select--</option>
                                        <option {{ old('status') === '1' ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ old('status') === '0' ? 'selected' : '' }} value="0">Inactive
                                        </option>
                                    </select>
                                </div> --}}


                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- <!-- JavaScript để khởi tạo và sử dụng FileReader -->
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Lấy file người dùng đã chọn
            if (file) {
                const reader = new FileReader(); // Khởi tạo đối tượng FileReader

                // Khi file đã được đọc xong
                reader.onload = function(e) {
                    const imageDisplay = document.getElementById('imageDisplay'); // Thẻ img hiển thị ảnh
                    imageDisplay.src = e.target.result; // Gán kết quả đọc được vào thẻ img
                    imageDisplay.style.display = 'block'; // Hiển thị ảnh
                };

                reader.readAsDataURL(file); // Đọc file ảnh dưới dạng URL
            }
        });
    </script> --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#uploadBtn').on('click', function(event) {
                event.preventDefault(); // Ngăn việc submit form
                $('#imageUpload').click();
            });

            $('#imageUpload').on('change', function() {
                const files = $(this)[0].files;
                if (files.length > 0) {
                    const file = files[0];
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        $('#previewImage').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                } else {
                    console.log("No file selected.");
                }
            })
        })
    </script>
@endpush
