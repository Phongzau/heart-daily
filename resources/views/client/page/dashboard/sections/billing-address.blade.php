<div class="tab-pane fade" id="billing" role="tabpanel">
    <div class="address account-content mt-0 pt-2">
        <h4 class="title">Địa chỉ thanh toán</h4>

        <form class="mb-2" action="#">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tên<span class="required">*</span></label>
                        <input type="text" class="form-control" required />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Họ <span class="required">*</span></label>
                        <input type="text" class="form-control" required />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Công ty </label>
                <input type="text" class="form-control">
            </div>

            <div class="select-custom">
                <label>Quốc gia / Khu vực <span class="required">*</span></label>
                <select name="orderby" class="form-control">
                    <option value="" selected="selected">Lãnh thổ
                    </option>
                    <option value="1">Brunei</option>
                    <option value="2">Bulgaria</option>
                    <option value="3">Burkina Faso</option>
                    <option value="4">Burundi</option>
                    <option value="5">Cameroon</option>
                </select>
            </div>

            <div class="form-group">
                <label>Địa chỉ đường phố <span class="required">*</span></label>
                <input type="text" class="form-control" placeholder="House number and street name" required />
                <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)"
                    required />
            </div>

            <div class="form-group">
                <label>Thị trấn / Thành phố<span class="required">*</span></label>
                <input type="text" class="form-control" required />
            </div>

            <div class="form-group">
                <label>Tiểu bang / Quốc gia<span class="required">*</span></label>
                <input type="text" class="form-control" required />
            </div>

            <div class="form-group">
                <label>Mã bưu điện / ZIP <span class="required">*</span></label>
                <input type="text" class="form-control" required />
            </div>

            <div class="form-group mb-3">
                <label>Điện thoại <span class="required">*</span></label>
                <input type="number" class="form-control" required />
            </div>

            <div class="form-group mb-3">
                <label>Địa chỉ email<span class="required">*</span></label>
                <input type="email" class="form-control" placeholder="editor@gmail.com" required />
            </div>

            <div class="form-footer mb-0">
                <div class="form-footer-right">
                    <button type="submit" class="btn btn-dark py-4">
                        Lưu
                    </button>
                </div>
            </div>
        </form>
    </div>
</div><!-- End .tab-pane -->
