@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Thêm mới Popup
@endsection


@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Quảng cáo Popups</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card bg-light">
                        <div class="card-header bg-white">
                            <h4>Thêm Popups</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.popups.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="form-group">
                                                    <label for="">Tiêu đề</label>
                                                    <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Mô tả</label>
                                                    <input type="text" name="description" value="{{ old('description') }}"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputState">Trạng thái</label>
                                                    <select id="inputState" name="status" class="form-control">
                                                        <option value="" hidden>--chọn--</option>
                                                        <option value="1">Bật</option>
                                                        <option value="0">Tắt</option>
                                                    </select>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Thêm</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="customField">Ảnh chính</label>
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
                                                        <button class="btn btn-dark" id="uploadBtn">Tải ảnh lên...</button>
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
