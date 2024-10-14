<div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.advertisement.homepage-banner-section-four') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Status</label> <br>
                    <label class='custom-switch mt-2'>
                        <input type='checkbox'
                            {{ @$homepage_section_banner_four->banner_one->status === 1 ? 'checked' : '' }}
                            name='status' class='custom-switch-input'>
                        <span class='custom-switch-indicator'></span>
                    </label>
                </div>

                <div class="form-group">
                    {{-- <img width="150px" src="{{ asset(@$homepage_section_banner_four->banner_one->banner_image) }}" alt=""> --}}
                    <img width="150px" src="{{ Storage::url(@$homepage_section_banner_four->banner_one->banner_image) }}">

                </div>

                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_image" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_url"
                        value="{{ @$homepage_section_banner_four->banner_one->banner_url }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
