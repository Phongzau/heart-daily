@extends('layouts.admin')
@section('title')
    {{ $generalSettings->site_name }} || Thuộc tính
@endsection
@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Thuộc tính</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Danh sách thuộc tính</h4>
                            @can('create-attributes')
                                <div class="card-header-action">
                                    <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary">Thêm mới</a>
                                </div>
                            @endcan
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');
                console.log(id);

                $.ajax({
                    url: "{{ route('admin.attributes.change-status') }}",
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
