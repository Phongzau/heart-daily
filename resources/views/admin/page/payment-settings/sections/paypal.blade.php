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
                    <label for="">Paypal Status</label>
                    <select name="status" class="form-control" id="">
                        <option {{ @$paypal->status == 1 ? 'selected' : '' }} value="1">Enable</option>
                        <option {{ @$paypal->status == 0 ? 'selected' : '' }} value="0">Disable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Account Mode</label>
                    <select name="mode" class="form-control" id="">
                        <option {{ @$paypal->mode == 0 ? 'selected' : '' }} value="0">Sandbox</option>
                        <option {{ @$paypal->mode == 1 ? 'selected' : '' }} value="1">Live</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Currency name</label>
                    <select name="currency_name" class="form-control" id="">
                        <option value="">Select</option>
                        @foreach (config('settings.currency_list') as $key => $currency)
                            <option {{ @$paypal->currency_name == $currency ? 'selected' : '' }}
                                value="{{ $currency }}">{{ $key }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Currency rate ( Per USD )</label>
                    <input type="text" name="currency_rate" value="{{ @$paypal->currency_rate }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Paypal Client Id</label>
                    <input type="text" name="client_id" value="{{ @$paypal->client_id }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Paypal Secret Key</label>
                    <input type="text" name="secret_key" value="{{ @$paypal->secret_key }}" class="form-control">
                </div>
                @can('edit-payment-settings')
                    <button type="submit" class="btn btn-primary">Save</button>
                @endcan
            </form>
        </div>
    </div>
</div>
