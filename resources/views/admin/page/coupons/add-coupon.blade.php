@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Thêm mã giảm giá cho người dùng
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Thêm mã giảm giá cho người dùng</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Thêm mã giảm giá cho người dùng</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.coupons.add-coupon') }}">
                                @csrf
                                <div class="form-group ">
                                    <label for="inputState">Đối tượng khách hàng</label>
                                    <select id="eventSelect" name="customer_object" class="form-control select2">
                                        <option value="" hidden>--Chọn đối tượng--</option>
                                        <option value="sinh_nhat">Sinh nhật</option>
                                        <option value="khach_hang_moi">Khách hàng mới</option>
                                        <option value="khach_hang_mua_nhieu">Khách hàng mua nhiều</option>
                                        <option value="khach_hang_mua_it">Khách hàng mua ít</option>
                                        <option value="khach_hang_trung_thanh">Khách hàng trung thành</option>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Mã giảm giá</label>
                                    <select id="couponSelect" name="coupon_id" class="form-control select2">
                                        <option value="">--Chọn mã giảm giá--</option>
                                        @foreach ($coupons as $coupon)
                                            <option value="{{ $coupon->id }}">{{ $coupon->name }}
                                            </option>
                                        @endforeach
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
            $('.select2').select2();

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
