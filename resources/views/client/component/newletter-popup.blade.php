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

            <form action="{{ route('newsletter.subscribe') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="email" class="form-control" id="newsletter-email" name="email"
                           placeholder="Your email address" required />
                    <input type="submit" class="btn btn-primary" value="Submit" />
                </div>
            </form>
            
            <div class="newsletter-subscribe">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" value="0" id="show-again" />
                    <label for="show-again" class="custom-control-label">
                        Don't show this popup again
                    </label>
                </div>
            </div>
        </div>
        <!-- End .newsletter-popup-content -->

        <button title="Close (Esc)" type="button" class="mfp-close">
            ×
        </button>
    </div>
    <!-- End .newsletter-popup -->
@endif
