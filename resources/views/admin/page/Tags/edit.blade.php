@extends('layouts.admin')

@section('title')
    Heart Daily | Chỉnh sửa
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Thẻ</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card ">
                        <div class="card-header ">
                            <h4>Chỉnh sửa</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.tags.update', $tags->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Tên</label>
                                    <input type="text" name="name" value="{{ $tags->name }}" class="form-control">
                                </div>

                                <div class="form-group ">
                                    <label for="inputState">Trạng thái</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option {{ $tags->status == '1' ? 'selected' : '' }} value="1">Bật
                                        </option>
                                        <option {{ $tags->status == '0' ? 'selected' : '' }} value="0">Tắt
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
