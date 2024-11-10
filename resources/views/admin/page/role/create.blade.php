@extends('layouts.admin')

@section('title')
    Heart Daily | Role Create
@endsection

@section('section')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Role</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Role</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.roles.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
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
                                                            value="{{ $permission->name }}">
                                                        <label>
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
