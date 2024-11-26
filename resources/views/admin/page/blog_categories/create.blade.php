@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Tạo mới danh mục bài viết
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Thêm mới</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Thêm mới danh mục bài viết</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.blog_categories.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Tên</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                </div>


                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Bật</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Tắt</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Thêm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
