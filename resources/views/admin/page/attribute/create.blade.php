@extends('layouts.admin')

@section('title', 'Heart Daily | Create Attribute')

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Thêm mới</h1>
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('admin.attributes.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label for="category_attribute_id">Danh mục thuộc tính</label>
                    <select name="category_attribute_id" class="form-control" id="categorySelect">
                        <option value="" hidden>Chọn danh mục</option>
                        @foreach ($categoryAttributes as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_attribute_id', $attribute->category_attribute_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="additionalInput" style="display: none;">
                    <label for="code">Mã</label>
                    <div class="input-group colorpickerinput">
                        
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                        <div class="input-group-append" id="color-picker-trigger">
                            <div class="input-group-text">
                                <i class="fas fa-fill-drip" id="color-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="price_start">Giá gốc</label>
                    <input type="number" name="price_start" class="form-control" value="{{ old('price_start') }}">
                </div>
                <div class="form-group">
                    <label for="price_end">Giá ưu đãi</label>
                    <input type="number" name="price_end" class="form-control" value="{{ old('price_end') }}">
                </div>
                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1">Bật</option>
                        <option value="0">Tắt</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categorySelect').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue == 2) {
                    $('#additionalInput').show(); // Hiện input khi giá trị là 2
                } else {
                    $('#additionalInput').hide(); // Ẩn input nếu không phải là 2
                }
            });
        });
    </script>
@endsection
