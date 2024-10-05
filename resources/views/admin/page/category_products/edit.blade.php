@extends('layouts.admin')

@section('title')
    Heart Daily | Edit Category Product
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Edit Category Product</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Category Product</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.category_products.update', $categoryProduct->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" value="{{ $categoryProduct->title }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="status">Parent Category</label>
                                    <select name="parent_id" class="form-control">
                                    <option value="0">Danh Mục</option>
                                        @foreach($categoryProductAll as $key => $value)
                                        <option value="{{$value->id }}" {{ old('parent_id') == $value->id ? 'selected' : '' }}>{{$value->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <input type="number" readonly name="level" value="{{ $categoryProduct->level }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="order">Order</label>
                                    <input type="number" name="order" value="{{ $categoryProduct->order }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option value="" hidden>--Select--</option>
                                        <option {{ $categoryProduct->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $categoryProduct->status == 0 ? 'selected' : '' }} value="0">Inactive
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Edit</button>
                            </form>
                        </div> <!-- End of card-body -->
                    </div> <!-- End of card -->
                </div> <!-- End of col-md-12 -->
            </div> <!-- End of row -->
        </div> <!-- End of section-body -->
    </section>
@endsection
