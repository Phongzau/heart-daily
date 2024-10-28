<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.paypal-setting.update', 1) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Paypal Status</label>
                    <select name="status" class="form-control" id="">
                        <option {{ @$paypalSetting->status == 1 ? 'selected' : '' }} value="1">Enable</option>
                        <option {{ @$paypalSetting->status == 0 ? 'selected' : '' }} value="0">Disable</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Account Mode</label>
                    <select name="mode" class="form-control" id="">
                        <option {{ @$paypalSetting->mode == 0 ? 'selected' : '' }} value="0">Sandbox</option>
                        <option {{ @$paypalSetting->mode == 1 ? 'selected' : '' }} value="1">Live</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Currency name</label>
                    <select name="currency_name" class="form-control select2" id="">
                        <option value="">Select</option>
                        @foreach (config('settings.currency_list') as $key => $currency)
                            <option {{ @$paypalSetting->currency_name == $currency ? 'selected' : '' }}
                                value="{{ $currency }}">{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Currency rate ( Per USD )</label>
                    <input type="text" name="currency_rate" value="{{ @$paypalSetting->currency_rate }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Paypal Client Id</label>
                    <input type="text" name="client_id" value="{{ @$paypalSetting->client_id }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Paypal Secret Key</label>
                    <input type="text" name="secret_key" value="{{ @$paypalSetting->secret_key }}"
                        class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
