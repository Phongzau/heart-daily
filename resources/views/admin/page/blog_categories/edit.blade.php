@extends('layouts.admin')


@section('title')
    {{ $generalSettings->site_name }} || Chỉnh sửa danh mục bài viết
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Chỉnh sửa</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Chỉnh sửa danh mục</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.blog_categories.update', $blogCategory->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Tên</label>
                                    <input type="text" name="name" value="{{ old('name', $blogCategory->name) }}"
                                        class="form-control" required>
                                </div>


                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1" {{ $blogCategory->status == 1 ? 'selected' : '' }}>Bật
                                        </option>
                                        <option value="0" {{ $blogCategory->status == 0 ? 'selected' : '' }}>Tắt
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
