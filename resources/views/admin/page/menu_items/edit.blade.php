@extends('layouts.admin')

@section('title')
    Heart Daily | Menu Items Update
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
                            <h4>Update Menu Items</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.menu_items.update', $menuItems->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" value="{{ $menuItems->title }}"
                                        class="form-control">
                                </div>
 
                                <div class="form-group">
                                    <label for="">URL</label>
                                    <input type="text" name="url"  value="/{{ $menuItems->url }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="status">Parent ID</label>
                                    <select name="parent_id" class="form-control parent">
                                        <option value="0">Danh Mục</option>
                                        @foreach ($menuItemAll as $key => $value)
                                            <option {{ $menuItems->parent_id == $value->id ? 'selected' : '' }}
                                                value="{{ $value->id }}">
                                                {{ $value->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="order">Order</label>
                                    <input type="number" name="order" value="{{ $menuItems->order }}"
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
                                            <option {{$menuItems->menu_id == $menu->id ? 'selected' : ''}} value="{{ $menu->id }}">{{ $menu->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option value="" hidden>--Select--</option>
                                        <option {{ $menuItems->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $menuItems->status == 0 ? 'selected' : '' }} value="0">
                                            Inactive
                                        </option>
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

                                <button class="btn btn-primary" type="submit">Update</button>
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
            let originalOrder = $('.order').val();
            let originalParentId = $('.parent').val();

            $('body').on('change', '.parent', function() {
                let id = $(this).val();

                // Nếu người dùng chọn lại đúng danh mục cha gốc, giữ nguyên order gốc
                if (id == originalParentId) {
                    $('.order').val(originalOrder);
                } else {
                    $.ajax({
                        url: "{{ route('admin.menu_items.get-parent') }}",
                        method: 'GET',
                        data: {
                            id: id,
                        },
                        success: function(data) {

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
                }
            })
        })
    </script>
@endpush
