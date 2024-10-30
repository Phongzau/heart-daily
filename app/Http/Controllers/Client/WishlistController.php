<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{


    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->with('product')->get();
        return view('client.page.wishlist', compact('wishlists'));
    }

    public function remove($id)
    {
        $wishlistItem = Wishlist::where('id', $id)->where('user_id', Auth::id())->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            toastr('Xóa thành công', 'success');
            return redirect()->back();
        }
        toastr('Không có sản phẩm ưa thích', 'error');
        return redirect()->back();
    }
}
