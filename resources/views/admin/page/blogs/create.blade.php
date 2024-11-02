@extends('layouts.admin')

@section('title')
    Heart Daily | Blogs Create
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Blogs</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card bg-light">
                        <div class="card-header bg-white">
                            <h4>Create Blogs</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="form-group">
                                                    <label for="">Title</label>
                                                    <input type="text" name="title" value="{{ old('title') }}"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Description</label>
                                                    <textarea name="description" class="form-control summernote" rows="5" required>{{ old('description') }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Blog Category Name</label>
                                                    <select name="blog_category_id" class="form-control">
                                                        <option value="" hidden>--Select--</option>
                                                        @foreach ($categories as $cate)
                                                            <option value="{{ $cate->id }}"
                                                                {{ old('blog_category_id') == $cate->id ? 'selected' : '' }}>
                                                                {{ $cate->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="inputState">Status</label>
                                                    <select id="inputState" name="status" class="form-control">
                                                        <option value="" hidden>--Select--</option>
                                                        <option {{ old('status') == '1' ? 'selected' : '' }} value="1">
                                                            Active</option>
                                                        <option {{ old('status') == '0' ? 'selected' : '' }} value="0">
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
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
