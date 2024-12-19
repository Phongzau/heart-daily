@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Danh mục yêu cầu trả hàng
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Các đơn hàng yêu cầu trả</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tất cả đơn hàng</h4>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Modal -->
    <div id="videoModal" class="modal fade" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Video Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video id="orderVideo" controls style="width: 100%; height: auto;">
                        <source src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.view-video', function() {
                // Lấy video path từ data attribute
                const videoPath = $(this).data('video-path');

                // Gán video path vào thẻ video
                $('#orderVideo').attr('src', videoPath);

                // Hiển thị modal
                $('#videoModal').modal('show');
            });

            // Đóng modal thì xóa video path để dừng video
            $('#videoModal').on('hidden.bs.modal', function() {
                $('#orderVideo').attr('src', '');
            });

            // Change approve status
            $('body').on('change', '.is_approve', function() {
                let value = $(this).val();
                let id = $(this).data('id');
                let currentSelect = $(this);
                $.ajax({
                    url: "{{ route('admin.orders.return.change-approve-status') }}",
                    method: 'PUT',
                    data: {
                        value: value,
                        id: id
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            toastr.success(data.message);
                        } else if (data.status == 'error') {
                            toastr.error(data.message);
                            currentSelect.val(data.current_status);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })

            })
        })
    </script>
@endpush
