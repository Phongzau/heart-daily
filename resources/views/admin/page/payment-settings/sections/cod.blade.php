<div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.payment-settings.vnpay-setting.update', $cod->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h5>COD</h5>
                <div class="form-group">
                    <label for="name" class="form-label">COD Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ $cod->name }}">
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">COD Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{ $cod->status ? 'selected' : '' }}>Enable</option>
                        <option value="0" {{ !$cod->status ? 'selected' : '' }}>Disable</option>
                    </select>
                </div>

                @can('edit-payment-settings')
                    <button type="submit" class="btn btn-primary">Save</button>
                @endcan
            </form>
        </div>
    </div>
</div>
