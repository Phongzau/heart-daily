@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Chỉnh sửa mã giảm giá
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Chỉnh sửa</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Chỉnh sửa mã giảm giá</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.coupons.update', $coupon->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Tên</label>
                                    <input type="text" name="name" value="{{ $coupon->name }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Mã</label>
                                    <input type="text" name="code" value="{{ $coupon->code }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Số lượng</label>
                                    <input type="text" name="quantity" value="{{ $coupon->quantity }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Lượt dùng</label>
                                    <input type="text" name="max_use" value="{{ $coupon->max_use }}"
                                        class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">NGày bắt đầu</label>
                                            <input type="text" name="start_date" value="{{ $coupon->start_date }}"
                                                class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Ngày hết hạn</label>
                                            <input type="text" name="end_date" value="{{ $coupon->end_date }}"
                                                class="form-control datepicker">
                                        </div>
                                    </div>
                                </div>
                                <div id="discount-row" class="row">
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="inputState">Loại giảm giá</label>
                                            <select id="inputState" name="discount_type" class="form-control">
                                                <option value="" hidden>Chọn</option>
                                                <option {{ $coupon->discount_type == 'percent' ? 'selected' : '' }}
                                                    value="percent">Tỉ lệ (%)</option>
                                                <option {{ $coupon->discount_type == 'amount' ? 'selected' : '' }}
                                                    value="amount">Mức giảm (đ)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="discount-div"
                                        class="@if ($coupon->discount_type) col-md-4 @else col-md-8 @endif ">
                                        <div class="form-group">
                                            <label>Giá trị chiết khấu
                                                @if ($coupon->discount_type === 'percent')
                                                    <code id="discount-label">
                                                        (%) (Không được vượt quá 100%)
                                                    </code>
                                                @else
                                                    <code id="discount-label">
                                                        (đ)
                                                    </code>
                                                @endif
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text" id="discount-unit">
                                                        @if ($coupon->discount_type === 'percent')
                                                            <code id="discount-label">
                                                                (%) (Không được vượt quá 100%)
                                                            </code>
                                                        @else
                                                            <code id="discount-label">
                                                                (đ)
                                                            </code>
                                                        @endif
                                                    </div>
                                                </div>
                                                <input id="discount_value" type="number" name="discount"
                                                    value="{{ $coupon->discount }}" class="form-control currency">
                                            </div>
                                        </div>
                                    </div>
                                    @if ($coupon->discount_type === 'percent')
                                        <div id="max-discount-col" class="col-md-4">
                                            <div class="form-group">
                                                <label>Giảm tối đa</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">đ</div>
                                                    </div>
                                                    <input type="number" name="max_discount_percent"
                                                        value="{{ $coupon->max_discount_percent }}"
                                                        class="form-control currency" placeholder="Nhập giảm tối đa">
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label for="">Giá trị đơn hàng tối thiểu <code>(đ)</code></label>
                                    <input type="number" id="min_order_value_edit" name="min_order_value"
                                        value="{{ $coupon->min_order_value }}" class="form-control">
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
                                        <option {{ $coupon->status == 1 ? 'selected' : '' }} value="1">Bật
                                        </option>
                                        <option {{ $coupon->status == 0 ? 'selected' : '' }} value="0">Tắt
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
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
                    $('#discount-label').text('(' + unit + ')' + ' (không được vượt quá 100%)');
                } else {
                    $('#discount-label').text('(' + unit + ')');
                }
            }

            function toggleMaxDiscountInput() {
                var selectedType = $('#inputState').val();

                if (selectedType === 'percent') {
                    // Thay đổi `col-md-8` thành `col-md-4`
                    $('#discount-div').removeClass('col-md-8').addClass('col-md-4');

                    // Tạo trường "Giảm tối đa"
                    var maxDiscountCol = `
                    <div id="max-discount-col" class="col-md-4">
                        <div class="form-group">
                            <label>Giảm tối đa</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">đ</div>
                                </div>
                                <input type="number" name="max_discount_percent" value="{{ old('min_order_value') }}" class="form-control currency" placeholder="Nhập giảm tối đa">
                            </div>
                        </div>
                    </div>
                `;
                    $('#discount-row').append(maxDiscountCol);
                } else {
                    // Trả lại `col-md-4` thành `col-md-8`

                    // Xóa trường "Giảm tối đa" nếu đã tồn tại
                    $('#max-discount-col').remove();

                    $('#discount-div').removeClass('col-md-4').addClass('col-md-8');
                }
            }

            // Khởi tạo
            updateDiscountUnit();
            // toggleMaxDiscountInput();

            // Sự kiện thay đổi giá trị trong dropdown
            $('#inputState').on('change', function() {
                $('#discount_value').removeAttr('disabled').val('');
                updateDiscountUnit();
                toggleMaxDiscountInput();
            });

            // Kiểm tra giá trị nhập vào discount_value
            $('#discount_value').on('input change', function() {
                var selectedType = $('#inputState').val();
                var discountValue = $(this).val();

                if (selectedType === 'percent' && discountValue > 100) {
                    $(this).val('');
                    toastr.error('Giá trị phần trăm không được vượt quá 100%');
                }
            });
        });
    </script>

    {{-- <script>
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
    </script> --}}
@endpush
