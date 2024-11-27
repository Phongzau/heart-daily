@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Chỉnh sửa nhà cung cấp
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
                            <h4>Chỉnh sửa nhà cung cấp</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.suppliers.update', $supplier->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Tên nhà cung cấp</label>
                                    <input type="text" name="name" value="{{ old('name', $supplier->name) }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $supplier->email) }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="number" name="phone" value="{{ old('phone', $supplier->phone) }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $supplier->status == 1 ? 'selected' : '' }}>Bật</option>
                                        <option value="0" {{ $supplier->status == 0 ? 'selected' : '' }}>Tắt</option>
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
