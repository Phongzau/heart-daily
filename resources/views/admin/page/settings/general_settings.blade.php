<div class="show active tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.settings.general-setting-update') }}" enctype="multipart/form-data"
                method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Tên trang web</label>
                    <input type="text" name="site_name" value="{{ @$generalSettings->site_name }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Email liên hệ</label>
                    <input type="text" name="contact_email" value="{{ @$generalSettings->contact_email }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Số điện thoại liên hệ</label>
                    <input type="text" name="contact_phone" value="{{ @$generalSettings->contact_phone }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Địa chỉ liên hệ</label>
                    <input type="text" name="contact_address" value="{{ @$generalSettings->contact_address }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Url bản đồ Google</label>
                    <input type="text" name="map" value="{{ @$generalSettings->map }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Tên tiền tệ</label>
                    <input type="text" name="currency_name" value="{{ @$generalSettings->currency_name }}"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Biểu tượng tiền tệ</label>
                    <input type="text" name="currency_icon" value="{{ @$generalSettings->currency_icon }}"
                        class="form-control">
                </div>
                @can('edit-settings')
                    <button type="submit" class="btn btn-primary">Lưu</button>
                @endcan
            </form>
        </div>
    </div>
</div>
