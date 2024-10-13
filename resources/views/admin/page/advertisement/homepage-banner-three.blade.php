<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.advertisement.homepage-banner-section-three') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h5>Banner One</h5>
                <div class="form-group">
                    <label for="">Status</label> <br>
                    <label class='custom-switch mt-2'>
                        <input type='checkbox'
                            {{ @$homepage_section_banner_three->banner_one->status === 1 ? 'checked' : '' }}
                            name='banner_one_status' class='custom-switch-input'>
                        <span class='custom-switch-indicator'></span>
                    </label>
                </div>

                <div class="form-group">
                    {{-- <img width="150px" src="{{ asset(@$homepage_section_banner_three->banner_one->banner_image) }}" alt=""> --}}
                    <img width="150px" src="{{ Storage::url(@$homepage_section_banner_three->banner_one->banner_image) }}">

                </div>

                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_one_image" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_one_url"
                        value="{{ @$homepage_section_banner_three->banner_one->banner_url }}" class="form-control">
                </div>
                <hr>
                <h5>Banner Two</h5>
                <div class="form-group">
                    <label for="">Status</label> <br>
                    <label class='custom-switch mt-2'>
                        <input type='checkbox'
                            {{ @$homepage_section_banner_three->banner_two->status === 1 ? 'checked' : '' }}
                            name='banner_two_status' class='custom-switch-input'>
                        <span class='custom-switch-indicator'></span>
                    </label>
                </div>

                <div class="form-group">
                    {{-- <img width="150px" src="{{ asset(@$homepage_section_banner_three->banner_two->banner_image) }}" alt=""> --}}
                    <img width="150px" src="{{ Storage::url(@$homepage_section_banner_three->banner_two->banner_image) }}">

                </div>

                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_two_image" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_two_url"
                        value="{{ @$homepage_section_banner_three->banner_two->banner_url }}" class="form-control">
                </div>
                <hr>
                <h5>Banner Three</h5>
                <div class="form-group">
                    <label for="">Status</label> <br>
                    <label class='custom-switch mt-2'>
                        <input type='checkbox'
                            {{ @$homepage_section_banner_three->banner_three->status === 1 ? 'checked' : '' }}
                            name='banner_three_status' class='custom-switch-input'>
                        <span class='custom-switch-indicator'></span>
                    </label>
                </div>

                <div class="form-group">
                    {{-- <img width="150px" src="{{ asset(@$homepage_section_banner_three->banner_three->banner_image) }}" alt=""> --}}
                    <img width="150px" src="{{ Storage::url(@$homepage_section_banner_three->banner_three->banner_image) }}">

                </div>

                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_three_image" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_three_url"
                        value="{{ @$homepage_section_banner_three->banner_three->banner_url }}" class="form-control">
                </div>


                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
