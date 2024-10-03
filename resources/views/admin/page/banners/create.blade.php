@extends('layouts.admin')

@section('title')
    Heart Daily | Banners Create
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Banners</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Banners</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Url</label>
                                    <input type="text" name="url" value="{{ old('url') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <input type="text" name="description" value="{{ old('description') }}"
                                        class="form-control">
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option value="" hidden>--Select--</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
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
