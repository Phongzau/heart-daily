@extends('layouts.client')

@section('section')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="demo4.html"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog Post</li>
            </ol>
        </div><!-- End .container -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <article class="post single">
                    <div class="post-media">
                        <img src="{{ Storage::url($blog->image) }}">
                    </div><!-- End .post-media -->

                    <div class="post-body">
                        <div class="post-date">
                            <span class="day">{{ $blog->created_at->format('d') }}</span>
                            <span class="month">{{ $blog->created_at->format('M') }}</span>
                        </div>

                        <h2 class="post-title">
                            <p>{{ $blog->title }}</p>
                        </h2>

                        <div class="post-meta">
                            <a href="#" class="hash-scroll count-comments">{{ $countComments }} Comments</a>
                        </div><!-- End .post-meta -->

                        <div class="post-content">
                            {!! $blog->description !!}
                        </div><!-- End .post-content -->

                        <div class="post-share">
                            <h3 class="d-flex align-items-center">
                                <i class="fas fa-share"></i>
                                Share this post
                            </h3>

                            <div class="social-icons">
                                <a href="#" class="social-icon social-facebook" target="_blank" title="Facebook">
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="#" class="social-icon social-twitter" target="_blank" title="Twitter">
                                    <i class="icon-twitter"></i>
                                </a>
                                <a href="#" class="social-icon social-linkedin" target="_blank" title="Linkedin">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="social-icon social-gplus" target="_blank" title="Google +">
                                    <i class="fab fa-google-plus-g"></i>
                                </a>
                                <a href="#" class="social-icon social-mail" target="_blank" title="Email">
                                    <i class="icon-mail-alt"></i>
                                </a>
                            </div><!-- End .social-icons -->
                        </div><!-- End .post-share -->

                        <h3><i class="far fa-user"></i>Comment Blog</h3>

                        <div id="commentSection" class="mt-3 mb-2">
                            @foreach ($comments as $item)
                                <div class="post-author">
                                    <figure>
                                        <a href="#">
                                            <img src="{{ Storage::url($item->user->image) }}" alt="author">
                                        </a>
                                    </figure>

                                    <div class="author-content">
                                        <h4><a href="#">{{ $item->user->name }}</a></h4>
                                        <p>{{ $item->comment }}</p>
                                    </div><!-- End .author.content -->
                                </div>
                            @endforeach
                        </div><!-- End .post-author -->

                        <nav class="toolbox toolbox-pagination">
                            <div class="toolbox-item toolbox-show">
                                <!-- Nếu cần hiển thị số bình luận hiện tại -->
                                Hiển thị {{ $comments->firstItem() }}-{{ $comments->lastItem() }} của
                                {{ $comments->total() }} bình luận
                            </div>

                            <!-- End .toolbox-item -->
                            <ul class="pagination toolbox-item">
                                {{-- Nếu có nhiều trang, hiển thị các trang --}}
                                @if ($comments->hasPages())
                                    {{-- Hiển thị nút "Previous" --}}
                                    @if ($comments->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link page-link-btn" href="#"><i
                                                    class="icon-angle-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link page-link-btn" href="{{ $comments->previousPageUrl() }}"><i
                                                    class="icon-angle-left"></i></a>
                                        </li>
                                    @endif

                                    {{-- Hiển thị các số trang --}}
                                    @foreach ($comments->links()->elements[0] as $page => $url)
                                        @if ($page == $comments->currentPage())
                                            <li class="page-item active">
                                                <a class="page-link" href="#">{{ $page }} <span
                                                        class="sr-only">(current)</span></a>
                                            </li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Hiển thị nút "Next" --}}
                                    @if ($comments->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link page-link-btn" href="{{ $comments->nextPageUrl() }}"><i
                                                    class="icon-angle-right"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="page-link page-link-btn" href="#"><i
                                                    class="icon-angle-right"></i></a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </nav>


                        <div class="comment-respond">
                            <h3>Leave a Reply</h3>

                            <form id="commentForm">
                                <div class="form-group">
                                    <label>Comment</label>
                                    <textarea cols="30" name="comment" rows="1" class="form-control" required></textarea>
                                </div><!-- End .form-group -->
                                <input type="text" hidden name="blog_id" value="{{ $blog->id }}">
                                <div class="form-footer my-0">
                                    <button type="submit" class="btn btn-sm btn-primary">Post
                                        Comment</button>
                                </div><!-- End .form-footer -->
                            </form>
                        </div><!-- End .comment-respond -->
                    </div><!-- End .post-body -->
                </article><!-- End .post -->

                <hr class="mt-2 mb-1">

                <div class="related-posts">
                    <h4>Related <strong>Posts</strong></h4>

                    <div class="owl-carousel owl-theme related-posts-carousel"
                        data-owl-options="{
								'dots': false
							}">

                        <article class="post">
                            <div class="post-media zoom-effect">
                                <a href="{{ route('blog-details', $blog->slug) }}">
                                    <img src="{{ Storage::url($blog->image) }}">
                                </a>
                            </div><!-- End .post-media -->

                            <div class="post-body">
                                <div class="post-date">
                                    <span class="day">{{ $blog->created_at->format('d') }}</span>
                                    <span class="month">{{ $blog->created_at->format('M') }}</span>
                                </div>

                                <h2 class="post-title">
                                    <a href="{{ route('blog-details', $blog->slug) }}">
                                        <h4>{{ $blog->title }}</h4>
                                    </a>
                                </h2><!-- End .post-title -->

                                <div class="post-content">
                                    <p>{{ limitTextDescription($blog->description, 150) }}</p>
                                    <a href="{{ route('blog-details', $blog->slug) }}" class="read-more">read more <i
                                            class="fas fa-angle-right"></i></a>
                                </div><!-- End .post-content -->
                            </div><!-- End .post-body -->
                        </article><!-- End .post -->
                    </div><!-- End .owl-carousel -->
                </div><!-- End .related-posts -->

            </div><!-- End .col-lg-9 -->

            <div class="sidebar-toggle custom-sidebar-toggle">
                <i class="fas fa-sliders-h"></i>
            </div>
            <div class="sidebar-overlay"></div>
            <aside class="sidebar mobile-sidebar col-lg-3">
                <div class="sidebar-wrapper" data-sticky-sidebar-options='{"offsetTop": 72}'>
                    <div class="widget widget-categories">
                        <h4 class="widget-title">Blog Categories</h4>
                        <ul class="list">
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('blogs', $category->slug) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div><!-- End .widget -->

                    <div class="widget widget-post">
                        <h4 class="widget-title">Recent Posts</h4>
                        <ul class="simple-post-list">
                            @foreach ($recentPosts as $recent)
                                <li>
                                    <div class="post-media">
                                        <a href="{{ route('blog-details', $recent->slug) }}">
                                            <img src="{{ Storage::url($recent->image) }}">
                                        </a>
                                    </div><!-- End .post-media -->
                                    <div class="post-info">
                                        <a
                                            href="{{ route('blog-details', $recent->slug) }}">{{ limitText($recent->title, 25) }}</a>
                                        <div class="post-meta">{{ $recent->created_at->format('M d, Y') }}</div>
                                    </div><!-- End .post-info -->
                                </li>
                            @endforeach
                        </ul>
                    </div><!-- End .widget -->


                    {{--                    <div class="widget"> --}}
                    {{--                        <h4 class="widget-title">Tags</h4> --}}

                    {{--                        <div class="tagcloud"> --}}
                    {{--                            <a href="#">ARTICLES</a> --}}
                    {{--                            <a href="#">CHAT</a> --}}
                    {{--                        </div><!-- End .tagcloud --> --}}
                    {{--                    </div><!-- End .widget --> --}}
                </div><!-- End .sidebar-wrapper -->
            </aside><!-- End .col-lg-3 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#commentForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('comments') }}",
                    method: 'POST',
                    data: formData,
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'success') {
                            getComments(data.comment.blog_id);
                            toastr.success(data.message);
                        } else if (data.status == 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value);
                            })
                        }
                    }
                })
            })

            function getComments(blogId) {
                $.ajax({
                    url: "{{ route('get-comments') }}",
                    method: 'GET',
                    data: {
                        blog_id: blogId,
                    },
                    success: function(data) {
                        console.log(data);
                        renderComments(data);
                    },
                    error: function() {}
                })
            }

            function renderComments(comments) {
                let commentSection = $('#commentSection');
                $('.count-comments').text(comments.total + ` Comments`);
                commentSection.empty(); // Xóa các bình luận cũ

                comments.data.forEach(comment => {
                    let commentHtml = `
                    <div class="post-author">
                        <figure>
                            <a href="#">
                                <img src="${comment.user.profile_image_url}" alt="author">
                            </a>
                        </figure>

                        <div class="author-content">
                            <h4><a href="#">${comment.user.name}</a></h4>
                            <p>${comment.comment}</p>
                        </div><!-- End .author.content -->
                    </div>
                    `;
                    commentSection.append(commentHtml);
                });

                // Cập nhật phân trang
                if (comments.total > 0) {
                    $('.toolbox-item').html(`
                    Hiển thị ${comments.from}-${comments.to} của ${comments.total} bình luận
                `);
                } else {
                    $('.toolbox-item').html(`Chưa có bình luận nào.`);
                }

                if (comments.last_page > 1) {
                    // Tạo lại HTML cho phân trang
                    let paginationHtml = '';

                    // Previous button
                    if (comments.current_page > 1) {
                        paginationHtml +=
                            `<li class="page-item"><a class="page-link page-link-btn" href="${comments.prev_page_url}"><i class="icon-angle-left"></i></a></li>`;
                    } else {
                        paginationHtml +=
                            `<li class="page-item disabled"><a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a></li>`;
                    }

                    // Page numbers
                    const currentUrl = new URL(window.location.href);
                    const basePath = currentUrl
                        .pathname; // Lấy đường dẫn hiện tại (ví dụ: /blog-details/vkalsvklaskvlakvl)

                    for (let i = 1; i <= comments.last_page; i++) {
                        // Thay đổi tham số trang trong URL
                        currentUrl.searchParams.set('page', i);

                        if (i == comments.current_page) {
                            paginationHtml +=
                                `<li class="page-item active"><a class="page-link" href="#">${i} <span class="sr-only">(current)</span></a></li>`;
                        } else {
                            paginationHtml +=
                                `<li class="page-item"><a class="page-link" href="${currentUrl.toString()}">${i}</a></li>`;
                        }
                    }

                    // Next button
                    if (comments.current_page < comments.last_page) {
                        paginationHtml +=
                            `<li class="page-item"><a class="page-link page-link-btn" href="${comments.next_page_url}"><i class="icon-angle-right"></i></a></li>`;
                    } else {
                        paginationHtml +=
                            `<li class="page-item disabled"><a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a></li>`;
                    }

                    $('.pagination').html(paginationHtml);
                } else {
                    $('.pagination').html('');
                }
            }
        })
    </script>
@endpush
