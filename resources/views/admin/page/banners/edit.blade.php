@extends('layouts.admin')

@section('title')
    Heart Daily | Banners Edit
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
                            <h4>Edit Banner</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.banners.update', $banner->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Preview</label> <br>
                                    <img width="100px" src="{{ Storage::url($banner->image) }}" alt="">
                                </div>
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Url</label>
                                    <input type="text" name="url" value="{{ $banner->url }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <input type="text" name="description" value="{{ $banner->description }}"
                                        class="form-control">
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option value="" hidden>--Select--</option>
                                        <option {{ $banner->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $banner->status == 0 ? 'selected' : '' }} value="0">Inactive
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
