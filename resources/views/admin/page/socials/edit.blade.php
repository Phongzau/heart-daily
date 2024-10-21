@extends('layouts.admin')

@section('title')
    Heart Daily | Socials Create
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Socials</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card ">
                        <div class="card-header ">
                            <h4>Update Socials</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.socials.update', $socials->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Icon</label>
                                    <div class="">
                                        <button class="btn btn-primary" data-selected-class="btn-danger"
                                            data-unselected-class="btn-primary" data-icon="{{ $socials->icon }}"
                                            name="icon" role="iconpicker"></button>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" value="{{ $socials->name }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Url</label>
                                    <input type="text" name="url" value="{{ $socials->url }}" class="form-control">
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option {{ $socials->status == '1' ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $socials->status == '0' ? 'selected' : '' }} value="0">Inactive
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
