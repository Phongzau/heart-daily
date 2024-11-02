@if ( isset($homepage_section_banner_two->banner_image_two) && $homepage_section_banner_two->banner_image_two->status)
<a href="{{$homepage_section_banner_two->banner_image_two->banner_url}}" target="_blank">
    <section class="promo-section bg-dark" data-parallax="{'speed': 2, 'enableOnMobile': true}"
             data-image-src="{{Storage::url($homepage_section_banner_two->banner_image_two->banner_image)}}">
    </section>
</a>
@endif
