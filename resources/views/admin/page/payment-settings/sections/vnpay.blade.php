<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.payment-settings.vnpay-setting.update', $vnpay->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h5>VNPAY</h5>
                <div class="form-group">
                    <label for="name" class="form-label">VNPay Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ $vnpay->name }}">
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">VNPay Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{ $vnpay->status ? 'selected' : '' }}>Enable</option>
                        <option value="0" {{ !$vnpay->status ? 'selected' : '' }}>Disable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vnp_tmncode" class="form-label">VNPay Terminal Code</label>
                    <input type="text" name="vnp_tmncode" id="vnp_tmncode" class="form-control"
                        value="{{ $vnpay->vnp_tmncode }}">
                </div>

                <div class="form-group">
                    <label for="vnp_hashsecret" class="form-label">VNPay Hash Secret</label>
                    <input type="text" name="vnp_hashsecret" id="vnp_hashsecret" class="form-control"
                        value="{{ $vnpay->vnp_hashsecret }}">
                </div>

                <div class="form-group">
                    <label for="vnp_url" class="form-label">VNPay URL</label>
                    <input type="text" name="vnp_url" id="vnp_url" class="form-control"
                        value="{{ $vnpay->vnp_url }}">
                </div>
                @can('edit-payment-settings')
                    <button type="submit" class="btn btn-primary">Save</button>
                @endcan
            </form>
        </div>
    </div>
</div>
