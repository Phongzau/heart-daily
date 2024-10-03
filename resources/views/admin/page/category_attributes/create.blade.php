@extends('layouts.admin')

@section('title')
    Heart Daily | Create Category Attribute
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Create Category Attribute</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Category Attribute</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.category_attributes.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" value="{{ old('slug') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="order">Order</label>
                                    <input type="number" name="order" value="{{ old('order') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
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
