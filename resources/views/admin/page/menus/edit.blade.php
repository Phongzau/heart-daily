@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Chỉnh sửa menu
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Menus</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Chỉnh sửa Menus</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.menus.update',$menu->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Tiêu đề</label>
                                    <input type="text" name="title" value="{{ $menu->title }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <select name="status" class="form-control" value="{{ $menu->status }}">
                                        <option value="1">Bật</option>
                                        <option value="0">Tắt</option>
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
