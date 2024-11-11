<div class="container">
    <div style="margin: 15px 0px 0px 0px" class="info-boxes-slider owl-carousel owl-theme mb-2"
        data-owl-options="{
        'dots': false,
        'loop': false,
        'responsive': {
            '576': {
                'items': 2
            },
            '992': {
                'items': 3
            }
        }
    }">
        <div class="info-box info-box-icon-left">
            <i class="icon-shipping"></i>

            <div class="info-box-content">
                <h4>FREE SHIPPING &amp; RETURN</h4>
                <p class="text-body">Free shipping on all orders over $99.</p>
            </div>
            <!-- End .info-box-content -->
        </div>
        <!-- End .info-box -->

        <div class="info-box info-box-icon-left">
            <i class="icon-money"></i>

            <div class="info-box-content">
                <h4>MONEY BACK GUARANTEE</h4>
                <p class="text-body">100% money back guarantee</p>
            </div>
            <!-- End .info-box-content -->
        </div>
        <!-- End .info-box -->

        <div class="info-box info-box-icon-left">
            <i class="icon-support"></i>

            <div class="info-box-content">
                <h4>ONLINE SUPPORT 24/7</h4>
                <p class="text-body">Lorem ipsum dolor sit amet.</p>
            </div>
            <!-- End .info-box-content -->
        </div>
        <!-- End .info-box -->
    </div>
    <!-- End .info-boxes-slider -->

    <div class="banners-container mb-2">
        <div class="banners-slider owl-carousel owl-theme" data-owl-options="{'dots': false}">
            <!-- Banner One -->
            @if (isset($homepage_section_banner_one->banner_one) && $homepage_section_banner_one->banner_one->status)
                <div class="banner banner1 banner-sm-vw d-flex align-items-center appear-animate"
                    data-animation-name="fadeInLeftShorter" data-animation-delay="500">
                    <figure class="w-100">
                        <img src="{{ Storage::url($homepage_section_banner_one->banner_one->banner_one_image) }}"
                            alt="Banner One" width="380" height="175" />
                    </figure>
                    <div class="banner-layer">
                        <a href="{{ $homepage_section_banner_one->banner_one->banner_one_url }}" target="_blank">
                        </a>
                    </div>
                </div>
            @endif

            <!-- Banner Two -->
            @if (isset($homepage_section_banner_one->banner_two) && $homepage_section_banner_one->banner_two->status)
                <div class="banner banner2 banner-sm-vw d-flex align-items-center appear-animate"
                    data-animation-name="fadeInUpShorter" data-animation-delay="200">
                    <figure class="w-100">
                        <img src="{{ Storage::url($homepage_section_banner_one->banner_two->banner_two_image) }}"
                            alt="Banner Two" width="380" height="175" />
                    </figure>
                    <div class="banner-layer">
                        <a href="{{ $homepage_section_banner_one->banner_two->banner_two_url }}" target="_blank">
                        </a>
                    </div>
                </div>
            @endif

            <!-- Banner Three -->
            @if (isset($homepage_section_banner_one->banner_three) && $homepage_section_banner_one->banner_three->status)
                <div class="banner banner3 banner-sm-vw d-flex align-items-center appear-animate"
                    data-animation-name="fadeInRightShorter" data-animation-delay="500">
                    <figure class="w-100">
                        <img src="{{ Storage::url($homepage_section_banner_one->banner_three->banner_three_image) }}"
                            alt="Banner Three" width="380" height="175" />
                    </figure>
                    <div class="banner-layer">
                        <a href="{{ $homepage_section_banner_one->banner_three->banner_three_url }}" target="_blank">
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- End .container -->
