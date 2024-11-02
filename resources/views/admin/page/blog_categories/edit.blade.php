@extends('layouts.admin')

@section('title')
    Heart Daily | Edit Blog Category
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Create Blog Category</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Blog Category</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.blog_categories.update', $blogCategory->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">name</label>
                                    <input type="text" name="name" value="{{ old('name', $blogCategory->name) }}"
                                        class="form-control" required>
                                </div>


                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1" {{ $blogCategory->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $blogCategory->status == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
