<div class="tab-pane fade show active" id="dashboard" role="tabpanel">
    <div class="dashboard-content">
        <p>
            Hello <strong class="text-dark">Editor</strong> (not
            <strong class="text-dark">Editor</strong>?
            <a href="login.html" class="btn btn-link ">Log out</a>)
        </p>

        <p>
            From your account dashboard you can view your
            <a class="btn btn-link link-to-tab" href="#order">recent orders</a>,
            manage your
            <a class="btn btn-link link-to-tab" href="#address">shipping and billing
                addresses</a>, and
            <a class="btn btn-link link-to-tab" href="#edit">edit your password and account
                details.</a>
        </p>

        <div class="mb-4"></div>

        <div class="row row-lg">
            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="#order" class="link-to-tab"><i class="sicon-social-dropbox"></i></a>
                    <div class="feature-box-content">
                        <h3>ORDERS</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="#download" class="link-to-tab"><i class="sicon-cloud-download"></i></a>
                    <div class=" feature-box-content">
                        <h3>DOWNLOADS</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="#address" class="link-to-tab"><i class="sicon-location-pin"></i></a>
                    <div class="feature-box-content">
                        <h3>ADDRESSES</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="#edit" class="link-to-tab"><i class="icon-user-2"></i></a>
                    <div class="feature-box-content p-0">
                        <h3>ACCOUNT DETAILS</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="{{ route('wishlist') }}"><i class="sicon-heart"></i></a>
                    <div class="feature-box-content">
                        <h3>WISHLIST</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="feature-box text-center pb-4">
                    <a href="login.html"><i class="sicon-logout"></i></a>
                    <div class="feature-box-content">
                        <h3>LOGOUT</h3>
                    </div>
                </div>
            </div>
        </div><!-- End .row -->
    </div>
</div><!-- End .tab-pane -->
