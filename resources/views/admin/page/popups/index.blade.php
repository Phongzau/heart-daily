@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Danh sách Popup
@endsection


@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Quảng cáo Popups</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">

                        <div class="card-header">
                            <h4>Danh sách</h4>
                            @if (!$popupExists)
                                @can('create-popups')
                                    <div class="card-header-action">
                                        <a href="{{ route('admin.popups.create') }}" class="btn btn-primary"><i
                                                class="fas fa-plus"></i> Thêm mới</a>
                                    </div>
                                @endcan
                            @endif
                        </div>

                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <hr>
    <section class="section">
        <div class="section-header">
            <h1>Người đăng ký nhận bản tin</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribers as $subscriber)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $subscriber->email }}</td>
                                            <td>{{ $subscriber->created_at }}</td>
                                            <td>
                                                @can('delete-subscribers')
                                                    <a class='btn btn-danger delete-item ml-2'
                                                        href={{ route('subscribers.destroy', $subscriber->id) }}><i
                                                            class='far fa-trash-alt'></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');
                console.log(id);

                $.ajax({
                    url: "{{ route('admin.popups.change-status') }}",
                    method: 'PUT',
                    data: {
                        status: isChecked,
                        id: id
                    },
                    success: function(data) {
                        toastr.success(data.message);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush
