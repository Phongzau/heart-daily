<div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="3000">
    <div class="carousel-inner">
        @foreach ($slider as $slide)
            @if ($slide->status)
            <div class="carousel-item @if ($loop->first) active @endif">
                <a href="{{$slide->url}}">
                    <img src="{{ Storage::url($slide->image) }}" class="d-block w-100" alt=""
                     style="max-height: 500px; max-width: 100%; height: auto; object-fit: cover;">
                </a>
            </div>
            @endif
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myCarousel = document.querySelector('#carouselExample');
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 2500,
            wrap: true
        });
        carousel.cycle();
    });
</script>

