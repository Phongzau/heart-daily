@php

@endphp
@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Chi tiết đơn rút
@endsection

@section('section')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Chi Tiết Đơn Rút</h1>
        </div>
        <div class="section-body">
            <!-- Card Chi Tiết -->
            <div class="card">
                <div class="card-header">
                    <h4>Thông Tin Chi Tiết Đơn Rút</h4>
                </div>
                <div class="card-body">
                    <!-- Thông Tin Ngân Hàng -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Ngân Hàng</label>
                            <p>{{ $withdrawRequest->bank_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Chủ Tài Khoản</label>
                            <p>{{ $withdrawRequest->account_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Số Tài Khoản</label>
                            <p>{{ $withdrawRequest->bank_account }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Thời Gian Yêu Cầu</label>
                            <p>{{ $withdrawRequest->created_at->format('d/m/Y - H:i') }}</p>
                        </div>
                    </div>
                    <!-- Thông Tin Yêu Cầu -->
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Số Tiền Rút</label>
                            <p>{{ number_format($withdrawRequest->equivalent_money, 0, ',', '.') }}
                                {{ $generalSettings->currency_icon }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Trạng Thái</label>
                            <select style="width: 30%;" id="status-select" class="form-control">
                                <option value="processing" {{ $withdrawRequest->status == 'processing' ? 'selected' : '' }}>
                                    Đang
                                    xử lý</option>
                                <option value="complete" {{ $withdrawRequest->status == 'complete' ? 'selected' : '' }}>
                                    Chuyển tiền thành công</option>
                                <option value="rejected" {{ $withdrawRequest->status == 'rejected' ? 'selected' : '' }}>Từ
                                    chối</option>
                            </select>
                        </div>
                    </div>
                    <!-- Nội Dung Phản Hồi -->
                    <div id="admin-feedback-card" class="card mt-4 @if ($withdrawRequest->status != 'rejected') d-none @endif ">
                        <div class="">
                            <h4>Gửi Phản Hồi Cho Khách</h4>
                        </div>
                        <div class="">
                            <textarea id="admin-feedback" rows="4" class="form-control" placeholder="Nhập nội dung phản hồi...">{{ @$withdrawRequest->admin_feedback }}</textarea>
                            <button id="send-feedback" class="btn btn-danger mt-3">Gửi Phản Hồi</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    {{-- <section class="section">
        <div class="section-body">
            <!-- Card Chi Tiết -->
            <div class="card">
                <div class="card-header">
                    <h4>Thông Tin Chi Tiết Đơn Rút</h4>
                </div>
                <div class="card-body">
                    <!-- Thông Tin Ngân Hàng -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Ngân Hàng</label>
                            <p>{{ $withdrawRequest->bank_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Chủ Tài Khoản</label>
                            <p>{{ $withdrawRequest->account_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Số Tài Khoản</label>
                            <p>{{ $withdrawRequest->bank_account }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Thời Gian Yêu Cầu</label>
                            <p>{{ $withdrawRequest->created_at->format('d/m/Y - H:i') }}</p>
                        </div>
                    </div>
                    <!-- Thông Tin Yêu Cầu -->
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Số Tiền Rút</label>
                            <p>{{ number_format($withdrawRequest->equivalent_money, 0, ',', '.') }}
                                {{ $generalSettings->currency_icon }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Trạng Thái</label>
                            <select style="width: 30%;" id="status-select" class="form-control">
                                <option value="processing"
                                    {{ $withdrawRequest->status == 'processing' ? 'selected' : '' }}>
                                    Đang
                                    xử lý</option>
                                <option value="complete" {{ $withdrawRequest->status == 'complete' ? 'selected' : '' }}>
                                    Chuyển tiền thành công</option>
                                <option value="rejected" {{ $withdrawRequest->status == 'rejected' ? 'selected' : '' }}>Từ
                                    chối</option>
                            </select>
                        </div>
                    </div>
                    <!-- Nội Dung Phản Hồi Từ Admin -->
                    @if ($withdrawRequest->status == 'rejected')
                        <hr>
                        <div class="mb-3">
                            <label class="font-weight-bold text-danger">Nội Dung Phản Hồi Từ Admin</label>
                            <p class="text-danger">{{ $withdrawRequest->admin_feedback }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section> --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let previousStatus = $('#status-select').val();
            $('#status-select').on('change', function() {
                let currentStatus = $(this).val();
                let id = "{{ $withdrawRequest->id }}";

                // Hiển thị/ẩn feedback dựa trên trạng thái hiện tại
                if (currentStatus === 'rejected') {
                    $('#admin-feedback-card').removeClass('d-none').slideDown();
                } else {
                    $('#admin-feedback-card').slideUp(function() {
                        $(this).addClass('d-none');
                    });
                }

                $.ajax({
                    url: "{{ route('admin.withdraws.change-status') }}",
                    method: 'GET',
                    data: {
                        status: currentStatus,
                        id: id,
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            toastr.success(data.message);
                            previousStatus = currentStatus;
                        } else if (data.status == 'error') {
                            toastr.error(data.message);

                            // Khôi phục trạng thái trước đó
                            $('#status-select').val(previousStatus);
                            // Quản lý hiển thị lại feedback nếu trạng thái trước là "rejected"
                            if (previousStatus === 'rejected') {
                                $('#admin-feedback-card').removeClass('d-none').slideDown();
                            } else {
                                $('#admin-feedback-card').slideUp(function() {
                                    $(this).addClass('d-none');
                                });
                            }
                        }
                    },
                    error: function(data) {
                        toastr.error('Có lỗi xảy ra. Vui lòng thử lại.');

                        $('#status-select').val(previousStatus);
                        // currentStatus = previousStatus;
                        if (previousStatus === 'rejected') {
                            $('#admin-feedback-card').removeClass('d-none').slideDown();
                        } else {
                            $('#admin-feedback-card').slideUp(function() {
                                $(this).addClass('d-none');
                            });
                        }
                    }
                })

            });

            // Gửi phản hồi qua AJAX
            $('#send-feedback').on('click', function() {
                let feedback = $('#admin-feedback').val();
                let requestId = "{{ $withdrawRequest->id }}";

                if (feedback.trim() === '') {
                    toastr.error('Vui lòng nhập nội dung phản hồi.');
                    return;
                }


                $.ajax({
                    url: "{{ route('send-feedback') }}",
                    method: "POST",
                    data: {
                        id: requestId,
                        feedback: feedback
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            toastr.success(response.message);
                            location.reload(); // Reload để cập nhật giao diện
                        } else if (response.status == 'error') {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        alert('Lỗi kết nối đến server!');
                    }
                });
            });
        })
    </script>
@endpush
