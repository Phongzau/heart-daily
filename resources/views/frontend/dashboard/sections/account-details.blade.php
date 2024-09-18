<div class="tab-pane fade" id="edit" role="tabpanel">
    <h3 class="account-sub-title d-none d-md-block mt-0 pt-1 ml-1"><i
            class="icon-user-2 align-middle mr-3 pr-1"></i>Account Details</h3>
    <div class="account-content">
        <form action="#">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="acc-name">First name <span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="Editor" id="acc-name" name="acc-name"
                            required />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="acc-lastname">Last name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="acc-lastname" name="acc-lastname" required />
                    </div>
                </div>
            </div>

            <div class="form-group mb-2">
                <label for="acc-text">Display name <span class="required">*</span></label>
                <input type="text" class="form-control" id="acc-text" name="acc-text" placeholder="Editor"
                    required />
                <p>This will be how your name will be displayed in the account section and
                    in
                    reviews</p>
            </div>


            <div class="form-group mb-4">
                <label for="acc-email">Email address <span class="required">*</span></label>
                <input type="email" class="form-control" id="acc-email" name="acc-email"
                    placeholder="editor@gmail.com" required />
            </div>

            <div class="change-password">
                <h3 class="text-uppercase mb-2">Password Change</h3>

                <div class="form-group">
                    <label for="acc-password">Current Password (leave blank to leave
                        unchanged)</label>
                    <input type="password" class="form-control" id="acc-password" name="acc-password" />
                </div>

                <div class="form-group">
                    <label for="acc-password">New Password (leave blank to leave
                        unchanged)</label>
                    <input type="password" class="form-control" id="acc-new-password" name="acc-new-password" />
                </div>

                <div class="form-group">
                    <label for="acc-password">Confirm New Password</label>
                    <input type="password" class="form-control" id="acc-confirm-password" name="acc-confirm-password" />
                </div>
            </div>

            <div class="form-footer mt-3 mb-0">
                <button type="submit" class="btn btn-dark mr-0">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</div><!-- End .tab-pane -->
