@extends('layouts.admin')

@section('title')
    Heart Daily | Account Edit
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Account</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Account</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.accounts.update', $listAccounts->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" value="{{ $listAccounts->name }}" readonly class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label> <br>
                                    <input type="email" name="email" value="{{ $listAccounts->email }}" readonly class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Role</label>
                                    <select id="inputState" name="role_id" class="form-control main-category">
                                        <option value="" hidden>Select</option>
                                        @foreach ($role as $role)
                                            <option {{$listAccounts->role_id == $role->id ? 'selected' : ''}} value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option value="" hidden>--Select--</option>
                                        <option {{ $listAccounts->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $listAccounts->status == 0 ? 'selected' : '' }} value="0">Inactive
                                        </option>
                                    </select>
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
