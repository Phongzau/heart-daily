@extends('layouts.client')

@section('title')
    {{ $generalSettings->site_name }} || Bài viết
@endsection

@section('section')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="demo4.html"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Bài viết</li>
            </ol>
        </div><!-- End .container -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="blog-section row">
                    @foreach ($blogs as $blog)
                        <div class="col-md-6 col-lg-4">
                            <article class="post">
                                <div class="post-media">
                                    <a href="{{ route('blog-details', $blog->slug) }}">
                                        <img src="{{ Storage::url($blog->image) }}">

                                    </a>

                                    <div class="post-date">

                                        <span class="day">{{ $blog->created_at->format('d') }}</span>
                                        <span class="month">{{ $blog->created_at->format('M') }}</span>
                                    </div>
                                </div><!-- End .post-media -->

                                <div class="post-body">
                                    <h2 class="post-title">
                                        <a href="{{ route('blog-details', $blog->slug) }}">
                                            <h4>{{ $blog->title }}</h4>
                                        </a>
                                    </h2><!-- End .post-title -->

                                    <div class="post-content">
                                        <p>{{ limitTextDescription($blog->description, 160) }}</p>
                                    </div><!-- End .post-content -->

                                    {{--                                <a href="single.html" class="post-comment">0 Bình luận</a> --}}
                                </div><!-- End .post-body -->
                            </article><!-- End .post -->
                        </div>
                    @endforeach
                </div>
            </div><!-- End .col-lg-9 -->

            <div class="sidebar-toggle custom-sidebar-toggle">
                <i class="fas fa-sliders-h"></i>
            </div>
            <div class="sidebar-overlay"></div>
            <aside class="sidebar mobile-sidebar col-lg-3">
                <div class="sidebar-wrapper" data-sticky-sidebar-options='{"offsetTop": 72}'>
                    <div class="widget widget-categories">
                        <h4 class="widget-title">Danh mục bài viết</h4>

                        <ul class="list">
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('blogs', $category->slug) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div><!-- End .widget -->

                    <div class="widget widget-post">
                        <h4 class="widget-title">Bài viết gần đây</h4>

                        <ul class="simple-post-list">
                            @foreach ($blogs as $blog)
                                <li>
                                    <div class="post-media">
                                        <a href="{{ route('blog-details', $blog->slug) }}">
                                            <img src="{{ Storage::url($blog->image) }}">
                                        </a>
                                    </div><!-- End .post-media -->

                                    <div class="post-info">
                                        <a href="singl.html">{{ limitText($blog->title, 25) }}</a>
                                        <div class="post-meta">{{ $blog->created_at->format('M d, Y') }}</div>
                                        <!-- End .post-meta -->
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
