@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Chỉnh sửa danh mục thuộc tính
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
                            <h4>Chỉnh sửa danh mục thuộc tính</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.category_attributes.update', $categoryAttribute->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="title">Tiêu đề</label>
                                    <input type="text" name="title" value="{{ old('title', $categoryAttribute->title) }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="order">Vị trí</label>
                                    <input type="number" name="order" value="{{ old('order', $categoryAttribute->order) }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $categoryAttribute->status == 1 ? 'selected' : '' }}>Bật</option>
                                        <option value="0" {{ $categoryAttribute->status == 0 ? 'selected' : '' }}>Tắt</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
