@extends('layouts.client')
@section('title')
    {{ $generalSettings->site_name }} || Sản phẩm yêu thích
@endsection
@section('section')
    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Yêu thích
                        </li>
                    </ol>
                </div>
            </nav>

            <h1>Yêu thích</h1>
        </div>
    </div>

    <div class="container">
        <div class="wishlist-title">
            <h2 class="p-2">Yêu thích của tôi </h2>
        </div>
        <div class="wishlist-table-container">
            @if ($wishlists->isEmpty())
                <p>Danh sách yêu thích của bạn trống.</p>
            @else
                <table class="table table-wishlist mb-0 table-responsive">
                    <thead>
                        <tr>
                            <th class="thumbnail-col"></th>
                            <th class="product-col">Sản phẩm</th>
                            <th class="price-col text-center">Giá</th>
                            <th class="status-col text-center">Tình trạng hàng</th>
                            <th class="action-col text-center">Trạng thái </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wishlists as $keyCart => $wishlist)
                            <tr class="product-row">
                                <td>
                                    <figure class="product-image-container">
                                        <a href="{{ route('product.detail', ['slug' => $wishlist->product->slug]) }}"
                                            class="product-image">
                                            <img src="{{ Storage::url($wishlist->product->image) }}"
                                                alt="{{ $wishlist->product->name }}">
                                        </a>

                                        <a href="{{ route('wishlist.remove', $wishlist->id) }}"
                                            class="btn-remove icon-cancel" title="Remove Product"
                                            onclick="event.preventDefault();
                                        document.getElementById('remove-wishlist-{{ $wishlist->id }}').submit();">
                                        </a>
                                        <form id="remove-wishlist-{{ $wishlist->id }}"
                                            action="{{ route('wishlist.remove', $wishlist->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>


                                    </figure>
                                </td>
                                <td>
                                    <h5 class="product-title">
                                        <a
                                            href="{{ route('product.detail', ['slug' => $wishlist->product->slug]) }}">{{ $wishlist->product->name }}</a>
                                    </h5>
                                </td>
                                <td class="price-box text-center">{{ number_format($wishlist->product->price) }} VND</td>
                                <td class="text-center">
                                    <span class="stock-status">
                                        @if ($wishlist->product->type_product === 'product_simple')
                                            {{ $wishlist->product->qty > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                        @else
                                            @php
                                                $inStock = $wishlist->product->productVariants
                                                    ->where('qty', '>', 0)
                                                    ->count();
                                            @endphp

                                            {{ $inStock > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                        @endif
                                    </span>
                                </td>
                                <td class="action text-center">

                                    <a href="{{ route('product.detail', ['slug' => $wishlist->product->slug]) }}"
                                        class="btn btn-dark product-type-simple btn-shop"><span>LỰA CHỌN LOẠI</span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div><!-- End .cart-table-container -->
    </div><!-- End .container -->
@endsection
