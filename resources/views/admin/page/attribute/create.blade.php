@extends('layouts.admin')

@section('title', 'Heart Daily | Create Attribute')

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Create Attribute</h1>
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('admin.attributes.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                </div>
                <div class="form-group">
                    <label for="category_attribute_id">Category Attribute</label>
                    <select name="category_attribute_id" class="form-control">
                        <option value="" hidden>Select Category</option>
                        @foreach ($categoryAttributes as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_attribute_id', $attribute->category_attribute_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="price_start">Price Start</label>
                    <input type="number" name="price_start" class="form-control" value="{{ old('price_start') }}">
                </div>
                <div class="form-group">
                    <label for="price_end">Price End</label>
                    <input type="number" name="price_end" class="form-control" value="{{ old('price_end') }}">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </section>
@endsection
