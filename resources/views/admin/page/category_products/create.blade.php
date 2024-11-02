@extends('layouts.admin')

@section('title')
    Heart Daily | Create Category Product
@endsection

@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Create Category Product</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Category Product</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.category_products.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="status">Parent Category</label>
                                    <select name="parent_id" class="form-control parent">
                                        <option value="0">Danh Mục Cha</option>
                                        @foreach ($categoryProduct as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ old('parent_id') == $value->id ? 'selected' : '' }}>{{ $value->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="order">Order</label>
                                    <input type="number" name="order" value="{{ $maxOrder }}" readonly
                                        class="form-control order">
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
                        </div> <!-- End of card-body -->
                    </div> <!-- End of card -->
                </div> <!-- End of col-md-12 -->
            </div> <!-- End of row -->
        </div> <!-- End of section-body -->
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('body').on('change', '.parent', function() {
                let id = $(this).val();

                $.ajax({
                    url: "{{ route('admin.category_products.get-parent') }}",
                    method: 'GET',
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.order === undefined || data.order === null) {
                            $('.order').val(0);
                        } else {
                            $('.order').val(data.order + 1);
                        }
                    },
                    error: function(error) {
                        console.log(data);
                    },
                })
            })
        })
    </script>
@endpush
