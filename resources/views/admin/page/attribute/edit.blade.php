@extends('layouts.admin')

@section('title', 'Heart Daily | Edit Attribute')

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Edit Attribute</h1>
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('admin.attributes.update', $attribute->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $attribute->title) }}">
                </div>
        
                <div class="form-group">
                    <label for="">Category Attribute</label>
                    <select name="category_attribute_id" class="form-control" id="categorySelect">
                        @foreach ($categoryAttributes as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $attribute->category_attribute_id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="additionalInput" style="display: {{ $attribute->category_attribute_id == 2 ? 'block' : 'none' }};">
                    <label for="code">Code</label>
                    <div class="input-group colorpickerinput">
                        <input type="text" name="code" class="form-control" value="{{ old('code', $attribute->code) }}">
                        <div class="input-group-append" id="color-picker-trigger">
                            <div class="input-group-text">
                                <i class="fas fa-fill-drip" id="color-icon" style="color: {{ old('code', $attribute->code) }};"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="price_start">Price Start</label>
                    <input type="number" name="price_start" class="form-control"
                        value="{{ old('price_start', $attribute->price_start) }}">
                </div>
                <div class="form-group">
                    <label for="price_end">Price End</label>
                    <input type="number" name="price_end" class="form-control"
                        value="{{ old('price_end', $attribute->price_end) }}">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $attribute->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $attribute->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
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
