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
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Blogs</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description" class="form-control summernote" rows="5" required>{{ old('description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Blog Category Name</label>
                                    <select name="blog_category_id" class="form-control">
                                        <option value="" hidden>--Select--</option>
                                        @foreach($categories as $cate)
                                            <option value="{{ $cate->id }}" {{ old('blog_category_id') == $cate->id ? 'selected' : '' }}>
                                                {{ $cate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option value="" hidden>--Select--</option>
                                        <option {{old('status') == '1' ? 'selected' : ''}} value="1">Active</option>
                                        <option {{old('status') == '0' ? 'selected' : ''}} value="0">Inactive</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
