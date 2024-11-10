<div class="show active tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.settings.logo-setting-update') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    preview <br>
                    <img width="150px" src="{{ Storage::url(@$logoSetting->logo) }}" alt=""> <br>
                    <label for="">Logo</label>
                    <input type="file" name="logo" class="form-control">
                </div>

                <div class="form-group">
                    preview <br>
                    <img width="150px" src="{{ Storage::url(@$logoSetting->logo_footer) }}" alt=""> <br>
                    <label for="">LogoFooter</label>
                    <input type="file" name="logo_footer" class="form-control">
                </div>

                <div class="form-group">
                    preview <br>
                    <img width="150px" src="{{ Storage::url(@$logoSetting->favicon) }}" alt=""><br>
                    <label for="">Favicon</label>
                    <input type="file" name="favicon" class="form-control">
                </div>
                @can('edit-settings')
                    <button type="submit" class="btn btn-primary">Save</button>
                @endcan
            </form>
        </div>
    </div>
</div>
