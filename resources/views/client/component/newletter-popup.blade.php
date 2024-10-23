@if ($popup)
    <div class="newsletter-popup mfp-hide bg-img" id="newsletter-popup-form"
        style="background: #f1f1f1 no-repeat center/cover url({{ Storage::url($popup->image) }})">
        <div class="newsletter-popup-content">
            <img src="{{ Storage::url(@$logoSetting->logo) }}" width="111" height="44" alt="Logo"
                class="logo-newsletter">
            <h2>{{ $popup->title }}</h2>

            <p>
                {{ $popup->description }}
            </p>

          
        </div>
        <!-- End .newsletter-popup-content -->

        <button title="Close (Esc)" type="button" class="mfp-close">
            ×
        </button>
    </div>
    <!-- End .newsletter-popup -->
@endif
