@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Thêm mới nhà cung cấp
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
                            <h4>Thêm mới nhà cung cấp</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.suppliers.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Tên nhà cung cấp</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="number" name="phone" value="{{ old('phone') }}" class="form-control">
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
