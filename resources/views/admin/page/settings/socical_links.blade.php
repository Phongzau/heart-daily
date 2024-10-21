<div class="show active tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.socical-setting-update') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Url Facebook </label>
                    <input type="text" name="facebook" value="{{ @$socicalLinks->facebook }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Url Instagram</label>
                    <input type="text" name="instagram" value="{{ @$socicalLinks->instagram }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Url Twitter</label>
                    <input type="text" name="twitter" value="{{ @$socicalLinks->twitter }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
