@extends('layouts.admin')

@section('title')
    Heart Daily | Brands Create
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Brands</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create brands</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.brands.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="fw-bold">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label class="fw-bold">Image:</label>
                                    <input type="file" class="form-control" id="image" name="image" >
                                </div>
                                <div class="form-group">
                                    <label class="fw-bold">Description</label>
                                    <input type="text" class="form-control" name="description" value="{{ old('description') }}">
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" name="status" class="form-control" value="{{ old('status') }}">
                                        <option value="" hidden>--Select--</option>
                                        <option {{old('status') === '1' ? 'selected' : ''}} value="1">Active</option>
                                        <option {{old('status') === '0' ? 'selected' : ''}} value="0">Inactive</option>
                                    </select>
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
