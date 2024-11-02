@extends('layouts.client')
@section('title')
    Wishlist
@endsection
@section('section')
    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Wishlist
                        </li>
                    </ol>
                </div>
            </nav>

            <h1>Wishlist</h1>
        </div>
    </div>

    <div class="container">
        <div class="wishlist-title">
            <h2 class="p-2">My wishlist </h2>
        </div>
        <div class="wishlist-table-container">
            @if ($wishlists->isEmpty())
                <p>Your wishlist is empty.</p>
            @else
            <table class="table table-wishlist mb-0">
                <thead>
                    <tr>
                        <th class="thumbnail-col"></th>
                        <th class="product-col">Product</th>
                        <th class="price-col">Price</th>
                        <th class="status-col">Stock Status</th>
                        <th class="action-col">Actions</th>
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
                                        class="btn-remove icon-cancel" 
                                        title="Remove Product" 
                                        onclick="event.preventDefault(); 
                                        document.getElementById('remove-wishlist-{{ $wishlist->id }}').submit();">
                                     </a>
                                     <form id="remove-wishlist-{{ $wishlist->id }}" action="{{ route('wishlist.remove', $wishlist->id) }}" method="POST" style="display: none;">
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
                            <td class="price-box">{{ number_format($wishlist->product->price) }} VND</td>
                            <td>
                                <span class="stock-status">In stock</span>
                            </td>
                            <td class="action">
                                
                                <a href="{{ route('product.detail', ['slug' => $wishlist->product->slug]) }}"
                                    class="btn btn-dark product-type-simple btn-shop"><span>SELECT
                                        OPTIONS</span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div><!-- End .cart-table-container -->
    </div><!-- End .container -->
@endsection
