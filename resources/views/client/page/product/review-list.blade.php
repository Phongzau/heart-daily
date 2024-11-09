@if ($reviews->isEmpty())
    <div id="text-review" class="text-center">
        <span style="font-size: 28px;
                            font-weight: 700">Hãy làm
            người bình luận đầu
            tiên</span> <br>
        <span style="font-size: 16px;
                            font-weight: 700;">(Mua hàng mới được đánh giá)</span>
    </div>
@else
    @foreach ($reviews as $item)
        <div class="comment-list">
            <div class="comments">
                <figure class="img-thumbnail">
                    <img src="{{ $item->user->image ? Storage::url(optional($item->user)->image) : asset('frontend/assets/images/blog/author.jpg') }}"
                        alt="author" width="80" height="80">
                </figure>
                <div class="comment-block">
                    <div class="comment-header">
                        <div class="comment-arrow"></div>
                        <div class="ratings-container float-sm-right">
                            <div class="product-ratings">
                                <span class="ratings" style="width:{{ ($item->rate / 5) * 100 }}%"></span>
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                        </div>
                        <span class="comment-by">
                            <strong>{{ optional($item->user)->name ?? 'Anonymous' }}</strong>
                        </span>
                    </div>
                    <div class="comment-content">
                        <p>{{ $item->review }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- pagination reviews -->
    @endforeach
    <nav class="toolbox toolbox-pagination">
        <div class="toolbox-item toolbox-show"></div>
        <ul class="pagination toolbox-item" id="pagination-links">
            {{ $reviews->appends(request()->query())->links() }}
        </ul>
    </nav>
@endif
