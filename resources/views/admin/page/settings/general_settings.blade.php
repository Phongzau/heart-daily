<div class="show active tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.settings.general-setting-update') }}" enctype="multipart/form-data"
                method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Site Name</label>
                    <input type="text" name="site_name" value="{{ @$generalSettings->site_name }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Contact Email</label>
                    <input type="text" name="contact_email" value="{{ @$generalSettings->contact_email }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Contact Phone</label>
                    <input type="text" name="contact_phone" value="{{ @$generalSettings->contact_phone }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Contact Address</label>
                    <input type="text" name="contact_address" value="{{ @$generalSettings->contact_address }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Google Map Url</label>
                    <input type="text" name="map" value="{{ @$generalSettings->map }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Currency Name</label>
                    <input type="text" name="currency_name" value="{{ @$generalSettings->currency_name }}"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Currency Icon</label>
                    <input type="text" name="currency_icon" value="{{ @$generalSettings->currency_icon }}"
                        class="form-control">
                </div>
                @can('edit-settings')
                    <button type="submit" class="btn btn-primary">Save</button>
                @endcan
            </form>
        </div>
    </div>
</div>
