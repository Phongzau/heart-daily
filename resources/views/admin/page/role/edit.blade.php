@extends('layouts.admin')
@section('title')
    {{ $generalSettings->site_name }} || Chỉnh sửa vai trò
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Vai trò</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Chỉnh sửa vai trò</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Tên</label>
                                    <input type="text" name="name" value="{{ $role->name }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Quyền hạn</label>
                                    <hr>
                                    <div class="row">
                                        @foreach ($permissions as $group => $groupPermissions)
                                            <div class="col-lg-4">
                                                <h4>{{ $group }}</h4>
                                                @foreach ($groupPermissions as $permission)
                                                    <div class="checkbox">
                                                        <input type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}"
                                                            {{ $role->permissions && $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                                        <label>
                                                            {{ $permission->display_name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
