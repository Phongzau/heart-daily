@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Thêm mới menu
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
                            <h4>Thêm mới Menus</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.menus.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="">Tiêu đề</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option value="" hidden>--Select--</option>
                                        <option {{ old('status') === '1' ? 'selected' : '' }} value="1">Bật</option>
                                        <option {{ old('status') === '0' ? 'selected' : '' }} value="0">Tắt</option>
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
