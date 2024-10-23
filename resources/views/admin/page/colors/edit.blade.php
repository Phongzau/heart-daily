@extends('layouts.admin')
@section('title')
    Sửa màu
@endsection
@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.colors.update', $color->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Tên Color</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $color->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="code">Mã Color</label>
                                    <div class="input-group colorpickerinput">
                                        <input type="text" class="form-control" id="code" name="code"
                                            value="{{ $color->code }}" required>
                                        <div class="input-group-append" id="color-picker-trigger">
                                            <div class="input-group-text">
                                                <i class="fas fa-fill-drip" id="color-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                        value="{{ $color->slug }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật Color</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
