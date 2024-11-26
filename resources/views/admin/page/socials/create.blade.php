@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Thêm mới mạng xã hội
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Mạng xã hội</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card ">
                        <div class="card-header ">
                            <h4>Thêm mới mạng xã hội</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.socials.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Biểu tượng</label>
                                    <div class="">
                                        <button class="btn btn-primary" data-selected-class="btn-danger"
                                            data-unselected-class="btn-primary" name="icon" role="iconpicker"></button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Tên</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Đường dẫn</label>
                                    <input type="text" name="url" value="{{ old('url') }}" class="form-control">
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Trạng thái</label>
                                    <select id="inputState" name="status" value="{{ old('status') }}" class="form-control">
                                        <option value="1">Bật</option>
                                        <option value="0">Tắt</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Thêm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
