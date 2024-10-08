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
                            <form method="POST" action="{{ route('admin.blogs.update' , $blog->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Preview</label> <br>
                                    <img width="100px" src="{{ Storage::url($blog->image) }}" alt="">
                                </div>
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">title</label>
                                    <input type="text" name="title" value="{{ $blog->title }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">description</label>
                                    <textarea name="description" class="form-control" rows="5" required>{{ $blog->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">blog_categories_name</label>
                                    <input type="text" name="blog_categories_id" value="{{ $blog->blog_categories_id }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">user_id</label>
                                    <input type="text" name="user_id" value="{{ $blog->user_id }}" class="form-control">
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" name="status" class="form-control" value="{{ $blog->status }}">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
