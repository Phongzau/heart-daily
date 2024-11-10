<div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.advertisement.homepage-banner-section-two') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Status</label> <br>
                    <label class='custom-switch mt-2'>
                        <input type='checkbox'
                            {{ @$homepage_section_banner_two->banner_image_two->status === 1 ? 'checked' : '' }}
                            name='status' class='custom-switch-input'>
                        <span class='custom-switch-indicator'></span>
                    </label>
                </div>

                <div class="form-group">
                    <img width="150px"
                        src="{{ Storage::url(@$homepage_section_banner_two->banner_image_two->banner_image) }}">
                </div>

                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_image_two" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_url_two"
                        value="{{ @$homepage_section_banner_two->banner_image_two->banner_url }}" class="form-control">
                </div>
                @can('edit-advertisements')
                    <button type="submit" class="btn btn-primary">Save</button>
                @endcan
            </form>
        </div>
    </div>
</div>
