@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Nhà cung cấp
@endsection



@section('section')
    <section class="section">
        <div class="section-header">
            <h1>Nhà cung cấp</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Danh sách nhà cung cấp</h4>
                            @can('create-categories-attributes')
                                <div class="card-header-action">
                                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Thêm mới
                                    </a>
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
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');
                console.log(id);

                $.ajax({
                    url: "{{ route('admin.suppliers.change-status') }}",
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