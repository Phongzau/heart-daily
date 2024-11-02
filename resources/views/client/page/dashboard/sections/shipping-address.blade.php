<div class="tab-pane fade" id="shipping" role="tabpanel">
    <div class="address account-content mt-0 pt-2">
        <h4 class="title mb-3">Shipping Address</h4>

        <form class="mb-2" method="POST" action="{{ route('user.updateAddress') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>First name <span class="required">*</span></label>
                        <input type="text" name="first_name" class="form-control" required placeholder="Fist Name"
                            value="{{ old('first_name', Auth::user()->first_name) }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last name <span class="required">*</span></label>
                        <input type="text" name="last_name" class="form-control" required placeholder="Last Name"
                            value="{{ old('last_name', Auth::user()->last_name) }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Phone </label>
                <input type="text" name="phone" class="form-control" placeholder="Phone"
                    value="{{ old('phone', Auth::user()->phone) }}">
            </div>
            <div class="form-group d-flex" style="gap: 10px">
                <select id="province" name="province_id"
                    style="border: 1px solid #dfdfdf; height: 40px; color: #777; padding: 0.3rem 0.5rem; flex: 1;">
                    <option value="" hidden>Province</option>
                </select>

                <select id="district" name="district_id" disabled
                    style="border: 1px solid #dfdfdf; height: 40px; color: #777; padding: 0.3rem 0.5rem; flex: 1;">
                    <option value="" hidden>District</option>
                </select>

                <select id="commune" name="commune_id" disabled
                    style="border: 1px solid #dfdfdf; height: 40px; color: #777; padding: 0.3rem 0.5rem; flex: 1;">
                    <option value="" hidden>Commune</option>
                </select>
            </div>

            <div class="form-group">
                <label>Address<span class="required">*</span></label>
                <input type="text" name="address" class="form-control" required placeholder="Address"
                    value="{{ old('address', Auth::user()->address) }}" />
            </div>

            <div class="form-footer mb-0">
                <div class="form-footer-right">
                    <button type="submit" class="btn btn-dark py-4">
                        Save Address
                    </button>
                </div>
            </div>
        </form>
    </div>
</div><!-- End .tab-pane -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let userProvinceId = "{{ old('province_id', Auth::user()->province_id) }}";
        let userDistrictId = "{{ old('district_id', Auth::user()->district_id) }}";
        let userCommuneId = "{{ old('commune_id', Auth::user()->commune_id) }}";

        // Load all provinces on page load
        $.getJSON('/provinces', function(provinces) {
            $('#province').append(provinces.map(function(province) {
                return `<option value="${province.id}" ${province.id == userProvinceId ? 'selected' : ''}>${province.title}</option>`;
            }));

            // Trigger change event to load districts if a province is pre-selected
            if (userProvinceId) {
                $('#province').trigger('change');
            }
        });

        // Load districts when a province is selected
        $('#province').on('change', function() {
            let province_id = $(this).val();
            if (province_id) {
                $('#district').prop('disabled', false);
                $.getJSON(`/provinces/${province_id}/districts`, function(districts) {
                    $('#district').html('');
                    $('#district').append(districts.map(function(district) {
                        return `<option value="${district.id}" ${district.id == userDistrictId ? 'selected' : ''}>${district.title}</option>`;
                    }));

                    // Trigger change event to load communes if a district is pre-selected
                    if (userDistrictId) {
                        $('#district').trigger('change');
                    }
                });
            } else {
                $('#district').prop('disabled', true).html('');
                $('#commune').prop('disabled', true).html('');
            }
        });

        // Load communes when a district is selected
        $('#district').on('change', function() {
            let district_id = $(this).val();
            if (district_id) {
                $('#commune').prop('disabled', false);
                $.getJSON(`/districts/${district_id}/communes`, function(communes) {
                    $('#commune').html('');
                    $('#commune').append(communes.map(function(commune) {
                        return `<option value="${commune.id}" ${commune.id == userCommuneId ? 'selected' : ''}>${commune.title}</option>`;
                    }));
                });
            } else {
                $('#commune').prop('disabled', true).html('');
            }
        });
    });
</script>
