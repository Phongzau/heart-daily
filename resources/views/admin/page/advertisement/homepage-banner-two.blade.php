<div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.advertisement.homepage-banner-section-two') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h5>Banner One</h5>
                <div class="form-group">
                    <label for="">Status</label> <br>
                    <label class='custom-switch mt-2'>
                        <input type='checkbox'
                            {{ @$homepage_section_banner_two->banner_one_image->status === 1 ? 'checked' : '' }}
                            name='banner_one_status' class='custom-switch-input'>
                        <span class='custom-switch-indicator'></span>
                    </label>
                </div>

                <div class="form-group">
                    {{-- <img width="150px" src="{{ asset(@$homepage_section_banner_two->banner_one->banner_image) }}" alt=""> --}}
                    <img width="150px"
                        src="{{ Storage::url(@$homepage_section_banner_two->banner_one_image->banner_image) }}">

                </div>

                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_one_image" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_one_url"
                        value="{{ @$homepage_section_banner_two->banner_one_image->banner_url }}" class="form-control">
                </div>
                <hr>
                <h5>Banner Two</h5>
                <div class="form-group">
                    <label for="">Status</label> <br>
                    <label class='custom-switch mt-2'>
                        <input type='checkbox'
                            {{ @$homepage_section_banner_two->banner_two_image->status === 1 ? 'checked' : '' }}
                            name='banner_two_status' class='custom-switch-input'>
                        <span class='custom-switch-indicator'></span>
                    </label>
                </div>

                <div class="form-group">
                    {{-- <img width="150px" src="{{ asset(@$homepage_section_banner_two->banner_two->banner_image) }}" alt=""> --}}
                    <img width="150px"
                        src="{{ Storage::url(@$homepage_section_banner_two->banner_two_image->banner_image) }}">
                    {{-- @if ($homepage_section_banner_two && $homepage_section_banner_two->banner_one)
                        <img width="150px" src="{{ Storage::url(@$homepage_section_banner_two->banner_one) }}">
                    @else
                        <p>No banner available</p>
                    @endif --}}

                </div>

                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_two_image" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_two_url"
                        value="{{ @$homepage_section_banner_two->banner_two_image->banner_url }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
