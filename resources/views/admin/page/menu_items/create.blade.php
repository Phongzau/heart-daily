@extends('layouts.admin')

@section('title')
    Heart Daily | Menu Items Create
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Menu Items</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Menu Items</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.menu_items.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label for="">URL</label>
                                    <input type="text" name="url" value="/{{ old('URL') }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="status">Parent ID</label>
                                    <select name="parent_id" class="form-control parent">
                                        <option value="0">Danh Mục</option>
                                        @foreach ($menuItems as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ old('parent_id') == $value->id ? 'selected' : '' }}>{{ $value->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Order</label>
                                    <input type="text" name="order" value="{{ $maxOrder }}" readonly
                                        class="form-control order">
                                </div>

                                {{-- <div class="form-group">
                                    <label for="">Slug</label>
                                    <input type="text" name="slug" value="{{ old('slug') }}" class="form-control">
                                </div> --}}

                                <div class="form-group">
                                    <label for=""> Menu Id</label>
                                    <select id="inputState" name="menu_id" class="form-control main-category">
                                        <option value="" hidden>Select</option>
                                        @foreach ($menu as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="">Userid_created</label>
                                    <input type="text" name="userid_created" value="{{ old('userid_created') }}"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Userid_updated</label>
                                    <input type="text" name="userid_updated" value="{{ old('userid_updated') }}"
                                        class="form-control">
                                </div> --}}

                                <button class="btn btn-primary" type="submit">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('body').on('change', '.parent', function() {
                let id = $(this).val();

                $.ajax({
                    url: "{{ route('admin.menu_items.get-parent') }}",
                    method: 'GET',
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        console.log(data.order);
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