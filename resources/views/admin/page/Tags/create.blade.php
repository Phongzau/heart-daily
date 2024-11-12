@extends('layouts.admin')

@section('title')
    Heart Daily | Tags Create
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Tags</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card ">
                        <div class="card-header ">
                            <h4>Create Tags</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.tags.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                </div>

                                <div class="form-group ">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" name="status" value="{{ old('status') }}" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
