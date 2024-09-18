<div class="tab-pane fade" id="shipping" role="tabpanel">
    <div class="address account-content mt-0 pt-2">
        <h4 class="title mb-3">Shipping Address</h4>

        <form class="mb-2" action="#">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>First name <span class="required">*</span></label>
                        <input type="text" class="form-control" required />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last name <span class="required">*</span></label>
                        <input type="text" class="form-control" required />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Company </label>
                <input type="text" class="form-control">
            </div>

            <div class="select-custom">
                <label>Country / Region <span class="required">*</span></label>
                <select name="orderby" class="form-control">
                    <option value="" selected="selected">British Indian Ocean Territory
                    </option>
                    <option value="1">Brunei</option>
                    <option value="2">Bulgaria</option>
                    <option value="3">Burkina Faso</option>
                    <option value="4">Burundi</option>
                    <option value="5">Cameroon</option>
                </select>
            </div>

            <div class="form-group">
                <label>Street address <span class="required">*</span></label>
                <input type="text" class="form-control" placeholder="House number and street name" required />
                <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)"
                    required />
            </div>

            <div class="form-group">
                <label>Town / City <span class="required">*</span></label>
                <input type="text" class="form-control" required />
            </div>

            <div class="form-group">
                <label>State / Country <span class="required">*</span></label>
                <input type="text" class="form-control" required />
            </div>

            <div class="form-group">
                <label>Postcode / ZIP <span class="required">*</span></label>
                <input type="text" class="form-control" required />
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
