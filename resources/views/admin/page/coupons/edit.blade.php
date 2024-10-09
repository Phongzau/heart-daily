@extends('layouts.admin')

@section('title')
    Heart Daily | Coupons Edit
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Coupons</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Coupon</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.coupons.update', $coupon->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" value="{{ $coupon->name }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Code</label>
                                    <input type="text" name="code" value="{{ $coupon->code }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Quantity</label>
                                    <input type="text" name="quantity" value="{{ $coupon->quantity }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Max Use Per Person</label>
                                    <input type="text" name="max_use" value="{{ $coupon->max_use }}"
                                        class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Start Date</label>
                                            <input type="text" name="start_date" value="{{ $coupon->start_date }}"
                                                class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">End Date</label>
                                            <input type="text" name="end_date" value="{{ $coupon->end_date }}"
                                                class="form-control datepicker">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="inputState">Discount Type</label>
                                            <select id="inputState" name="discount_type" class="form-control">
                                                <option value="" hidden>Select</option>
                                                <option {{ $coupon->discount_type == 'percent' ? 'selected' : '' }}
                                                    value="percent">Percentage (%)</option>
                                                <option {{ $coupon->discount_type == 'amount' ? 'selected' : '' }}
                                                    value="amount">Amount (đ)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Discount Value
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
                                </div>
                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <!-- Tab "Not Available" -->
                                        <a class="nav-link
                                        @if ($coupon->min_order_value == 0) active @endif
                                        "
                                            id="not-available-tab" data-toggle="tab" href="#not-available" role="tab"
                                            aria-controls="not-available" aria-selected="true">Not available</a>
                                    </li>
                                    <li class="nav-item">
                                        <!-- Tab "Minimum Order Value" -->
                                        <a class="nav-link ml-1
                                        @if ($coupon->min_order_value > 0) active @endif
                                        "
                                            id="min-order-value-tab" data-toggle="tab" href="#min-order-value"
                                            role="tab" aria-controls="min-order-value" aria-selected="false">Minimum
                                            order value</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade @if ($coupon->min_order_value == 0) show active @endif "
                                        id="not-available" role="tabpanel" aria-labelledby="not-available-tab">
                                        <label for="">Minium order value <code>(đ)</code></label>
                                        <input type="number" readonly id="min_order_value" name="min_order_value"
                                            value="0" class="form-control">
                                    </div>
                                    <div class="tab-pane fade @if ($coupon->min_order_value > 0) show active @endif"
                                        id="min-order-value" role="tabpanel" aria-labelledby="min-order-value-tab">
                                        <label for="">Minium order value <code>(đ)</code></label>
                                        <input type="number" id="min_order_value_edit" name="min_order_value"
                                            value="{{ $coupon->min_order_value }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option {{ $coupon->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $coupon->status == 0 ? 'selected' : '' }} value="0">Inactive
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
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
