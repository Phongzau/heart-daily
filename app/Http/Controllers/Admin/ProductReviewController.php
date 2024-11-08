<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductReviewDataTable;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductReviewDataTable $dataTable)
    {
        return $dataTable->render('admin.page.product_reviews.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    //  public function store(Request $request){
    //     $validatedData = $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'rating' => 'required|integer|min:1|max:5',
    //         'review' => 'required|string|max:500',
    //     ]);
    //     // Lưu đánh giá vào cơ sở dữ liệu
    //     $review = new ProductReview();
    //     $review->user_id = Auth::user()->id;
    //     $review->rate = $request->rating;
    //     $review->review = $request->review;
    //     $review->product_id = $request->product_id;
    //     $review->save();

    //     // Trả về comment mới thêm vào
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Đánh giá thành công',
    //         'review' => $review, 
    //     ]);
    // }
    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa thành công!',
        ]);
    }
}