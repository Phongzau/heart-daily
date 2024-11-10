<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.advertisement.homepage-banner-section-one') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h5>Banner One</h5>
                <div class="form-group">
                    <label for="">Status</label> <br>
                    <label class='custom-switch mt-2'>
                        <input type='checkbox'
                            {{ @$homepage_section_banner_one->banner_one->status === 1 ? 'checked' : '' }}
                            name='banner_one_status' class='custom-switch-input'>
                        <span class='custom-switch-indicator'></span>
                    </label>
                </div>

                <div class="form-group">
                    {{-- <img width="150px" src="{{ asset(@$homepage_section_banner_one->banner_one->banner_image) }}" alt=""> --}}
                    <img width="150px"
                        src="{{ Storage::url(@$homepage_section_banner_one->banner_one->banner_one_image) }}">

                </div>

                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_one_image" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_one_url"
                        value="{{ @$homepage_section_banner_one->banner_one->banner_one_url }}" class="form-control">
                </div>
                <hr>
                <h5>Banner Two</h5>
                <div class="form-group">
                    <label for="">Status</label> <br>
                    <label class='custom-switch mt-2'>
                        <input type='checkbox'
                            {{ @$homepage_section_banner_one->banner_two->status === 1 ? 'checked' : '' }}
                            name='banner_two_status' class='custom-switch-input'>
                        <span class='custom-switch-indicator'></span>
                    </label>
                </div>

                <div class="form-group">
                    {{-- <img width="150px" src="{{ asset(@$homepage_section_banner_one->banner_two->banner_image) }}" alt=""> --}}
                    <img width="150px"
                        src="{{ Storage::url(@$homepage_section_banner_one->banner_two->banner_two_image) }}">

                </div>

                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_two_image" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_two_url"
                        value="{{ @$homepage_section_banner_one->banner_two->banner_two_url }}" class="form-control">
                </div>
                <hr>
                <h5>Banner thre</h5>
                <div class="form-group">
                    <label for="">Status</label> <br>
                    <label class='custom-switch mt-2'>
                        <input type='checkbox'
                            {{ @$homepage_section_banner_one->banner_three->status === 1 ? 'checked' : '' }}
                            name='banner_three_status' class='custom-switch-input'>
                        <span class='custom-switch-indicator'></span>
                    </label>
                </div>

                <div class="form-group">
                    {{-- <img width="150px" src="{{ asset(@$homepage_section_banner_one->banner_one->banner_image) }}" alt=""> --}}
                    <img width="150px"
                        src="{{ Storage::url(@$homepage_section_banner_one->banner_three->banner_three_image) }}">

                </div>

                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_three_image" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_three_url"
                        value="{{ @$homepage_section_banner_one->banner_three->banner_three_url }}"
                        class="form-control">
                </div>
                @can('edit-advertisements')
                    <button type="submit" class="btn btn-primary">Save</button>
                @endcan
            </form>
        </div>
    </div>
</div>
