@extends('layouts.admin')

@section('title', 'Heart Daily | Edit Attribute')

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Create Attribute</h1>
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('admin.attributes.update', $attribute->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $attribute->title) }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $attribute->slug) }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="">Category Attribute</label>
                    <select name="category_attribute_id" class="form-control" required>
                        @foreach ($categoryAttributes as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $attribute->category_attribute_id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="price_start">Price Start</label>
                    <input type="number" name="price_start" class="form-control"
                        value="{{ old('price_start', $attribute->price_start) }}" required>
                </div>
                <div class="form-group">
                    <label for="price_end">Price End</label>
                    <input type="number" name="price_end" class="form-control"
                        value="{{ old('price_end', $attribute->price_end) }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="1" {{ $attribute->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $attribute->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </section>
@endsection
