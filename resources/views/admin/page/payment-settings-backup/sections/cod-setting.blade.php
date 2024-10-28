{{-- <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.cod-settings.update', 1) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">COD Status</label>
                    <select name="status" class="form-control" id="">
                        <option {{ @$codSetting->status == 1 ? 'selected' : '' }} value="1">Enable</option>
                        <option {{ @$codSetting->status == 0 ? 'selected' : '' }} value="0">Disable</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div> --}}
