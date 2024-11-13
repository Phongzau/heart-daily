@extends('layouts.admin')

@section('title')
    Heart Daily | Coupons Create
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Thêm mới</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Thêm mã giảm giá</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.coupons.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="">Tên</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Mã</label>
                                    <input type="text" name="code" value="{{ old('code') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Số lượng</label>
                                    <input type="text" name="quantity" value="{{ old('quantity') }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Lượt dùng</label>
                                    <input type="text" name="max_use" value="{{ old('name') }}" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Ngày bắt đầu</label>
                                            <input type="text" name="start_date" class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Ngày hết hạn</label>
                                            <input type="text" name="end_date" class="form-control datepicker">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="inputState">
                                            Loại giảm giá</label>
                                            <select id="inputState" name="discount_type" class="form-control">
                                                <option value="" hidden>Chọn</option>
                                                <option {{ old('discount_type') == 'percent' ? 'selected' : '' }}
                                                    value="percent">Tỉ lệ (%)</option>
                                                <option {{ old('discount_type') == 'amount' ? 'selected' : '' }}
                                                    value="amount">Mức giảm (đ)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Giá trị chiết khấu<code id="discount-label">(?)</code></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text" id="discount-unit">
                                                        ?
                                                    </div>
                                                </div>
                                                <input disabled id="discount_value" type="number" name="discount"
                                                    value="{{ old('discount') }}" class="form-control currency">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <!-- Tab "Not Available" -->
                                        <a class="nav-link active" id="not-available-tab" data-toggle="tab"
                                            href="#not-available" role="tab" aria-controls="not-available"
                                            aria-selected="true">Không có sẵn</a>
                                    </li>
                                    <li class="nav-item">
                                        <!-- Tab "Minimum Order Value" -->
                                        <a class="nav-link ml-1" id="min-order-value-tab" data-toggle="tab"
                                            href="#min-order-value" role="tab" aria-controls="min-order-value"
                                            aria-selected="false">Giá trị đơn hàng tối thiểu</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="not-available" role="tabpanel"
                                        aria-labelledby="not-available-tab">
                                        <label for="">Giá trị đơn hàng tối thiểu <code>(đ)</code></label>
                                        {{-- <input type="number" readonly id="min_order_value" name="min_order_value"
                                            value="0" class="form-control"> --}}
                                        <input type="number" readonly id="min_order_value_display" value="0"
                                            class="form-control">

                                        <!-- Input ẩn để gửi giá trị thực tế khi form submit -->
                                        <input type="hidden" id="min_order_value" name="min_order_value" value="0">
                                    </div>
                                    <div class="tab-pane fade" id="min-order-value" role="tabpanel"
                                        aria-labelledby="min-order-value-tab">
                                        <label for="">Giá trị đơn hàng tối thiểu <code>(đ)</code></label>
                                        <input type="number" id="min_order_value_edit" name="min_order_value"
                                            value="{{ old('min_order_value') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="inputState">Công khai</label> <br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline1" name="is_publish" checked
                                            value="1" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline1">Có</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="is_publish" value="0"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline2">Không</label>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Trạng thái</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option {{ old('status') == '1' ? 'selected' : '' }} value="1">Bật
                                        </option>
                                        <option {{ old('status') == '0' ? 'selected' : '' }} value="0">Tắt
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Thêm</button>
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

            function updateDiscountUnit() {
                var selectedType = $('#inputState').val();
                var unit = selectedType === 'percent' ? '%' : (selectedType === 'amount' ? 'đ' : '?');
                $('#discount-unit').text(unit);
                if (selectedType === 'percent') {
                    $('#discount-label').text('(' + unit + ')' + '(' + 'không được vượt quá 100%' + ')');
                } else {
                    $('#discount-label').text('(' + unit + ')');
                }
            }

            updateDiscountUnit();

            $('#discount_value').on('input change', function() {

                var selectedType = $('#inputState').val();
                var discountValue = $(this).val();
                console.log(selectedType, discountValue);

                if (selectedType === 'percent' && discountValue > 100) {
                    $(this).val('');
                    toastr.error('Giá trị phần trăm không được vượt quá 100%');
                }
            })

            $('#inputState').on('change', function() {
                $('#discount_value').removeAttr('disabled');
                $('#discount_value').val('');
                updateDiscountUnit();
            })

            $('#not-available-tab').on('shown.bs.tab', function() {
                $('#min_order_value_edit').attr('disabled', true);
                $('#min_order_value').removeAttr('disabled');
            })
            $('#min-order-value-tab').on('shown.bs.tab', function() {
                $('#min_order_value').attr('disabled', true);
                $('#min_order_value_edit').removeAttr('disabled');
            })
        })
    </script>
@endpush
