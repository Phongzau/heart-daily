<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.payment-settings.paypal-setting.update', $paypal->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h5>PAYPAL</h5>
                <div class="form-group">
                    <label for="name" class="form-label">Paypal Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ @$paypal->name }}">
                </div>
                <div class="form-group">
                    <label for="">Trạng thái Paypal</label>
                    <select name="status" class="form-control" id="">
                        <option {{ @$paypal->status == 1 ? 'selected' : '' }} value="1">Duyệt</option>
                        <option {{ @$paypal->status == 0 ? 'selected' : '' }} value="0">Hủy</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Trạng thái tài khoản</label>
                    <select name="mode" class="form-control" id="">
                        <option {{ @$paypal->mode == 0 ? 'selected' : '' }} value="0">Sandbox</option>
                        <option {{ @$paypal->mode == 1 ? 'selected' : '' }} value="1">Live</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Loại tiền tệ</label>
                    <select name="currency_name" class="form-control" id="">
                        <option value="">Select</option>
                        @foreach (config('settings.currency_list') as $key => $currency)
                            <option {{ @$paypal->currency_name == $currency ? 'selected' : '' }}
                                value="{{ $currency }}">{{ $key }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Tỉ giá tiền tệ( Per USD )</label>
                    <input type="text" name="currency_rate" value="{{ @$paypal->currency_rate }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">MÃ khách hàng Paypal</label>
                    <input type="text" name="client_id" value="{{ @$paypal->client_id }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for=""> Khóa bảo mật Paypal</label>
                    <input type="text" name="secret_key" value="{{ @$paypal->secret_key }}" class="form-control">
                </div>
                @can('edit-payment-settings')
                    <button type="submit" class="btn btn-primary">Lưu</button>
                @endcan
            </form>
        </div>
    </div>
</div>
