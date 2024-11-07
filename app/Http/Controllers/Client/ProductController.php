<?php

namespace App\Http\Controllers\Client;

use App\Helper\BadwordsHelper;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Wishlist;
use App\Models\ProductReview;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->input('count', 12);
        $query = Product::query()->where('status', 1);

        if ($request->has('tag_id')) {

            $tagId = intval($request->input('tag_id'));

            $query->whereJsonContains('id_tags', $tagId);
        }
        $products = $query->paginate($perPage);

        $categories = CategoryProduct::all();

        $brands = Brand::all();

        $colors = Attribute::whereHas('categoryAttribute', function ($query) {
            $query->where('title', 'Color');
        })->get();

        $sizes = Attribute::whereHas('categoryAttribute', function ($query) {
            $query->where('title', 'Size');
        })->get();
        $tags = Tag::all();
        return view('client.page.product.list_product', compact('products', 'tags', 'categories', 'sizes', 'colors', 'brands', 'perPage'));
    }

    public function ajaxIndex(Request $request)
    {
        $perPage = $request->input('count', 12);
        $orderby = $request->input('orderby', 'menu_order');
        $currentDate = Carbon::now()->toDateString();

        $query = Product::with('brand')->where('status', 1);
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }

        $query->whereHas('ProductVariants', function ($q) use ($request) {
            // Lọc theo màu sắc
            if ($request->has('color') && $request->color) {
                $q->whereExists(function ($subQuery) use ($request) {
                    $subQuery->select(DB::raw(1))
                        ->from('attributes')
                        ->join('category_attributes', 'attributes.category_attribute_id', '=', 'category_attributes.id')
                        ->where('category_attributes.title', 'Color')
                        ->where('attributes.id', $request->color)
                        ->whereRaw("JSON_CONTAINS(product_variants.id_variant, CAST(attributes.id AS JSON), '$')");
                });
            }

            // Lọc theo kích cỡ
            if ($request->has('size') && $request->size) {
                $q->whereExists(function ($subQuery) use ($request) {
                    $subQuery->select(DB::raw(1))
                        ->from('attributes')
                        ->join('category_attributes', 'attributes.category_attribute_id', '=', 'category_attributes.id')
                        ->where('category_attributes.title', 'Size')
                        ->where('attributes.id', $request->size)
                        ->whereRaw("JSON_CONTAINS(product_variants.id_variant, CAST(attributes.id AS JSON), '$')");
                });
            }
        });
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 1000000000);
        if ($request->has('min_price') || $request->has('max_price')) {

            $query->where(function ($q) use ($minPrice, $maxPrice, $currentDate) {
                // Điều kiện cho sản phẩm có giá khuyến mãi
                $q->where(function ($subQ) use ($minPrice, $maxPrice, $currentDate) {
                    $subQ->where('offer_price', '>', 0)
                        ->where('offer_start_date', '<=', $currentDate)
                        ->where('offer_end_date', '>=', $currentDate)
                        ->whereBetween('offer_price', [$minPrice, $maxPrice]);
                })
                    // Điều kiện cho sản phẩm không có giá khuyến mãi
                    ->orWhere(function ($subQ) use ($minPrice, $maxPrice) {
                        $subQ->whereNull('offer_price')
                            ->whereBetween('price', [$minPrice, $maxPrice]);
                    });
            });
        }

        if ($orderby == 'price') {
            $query->where(function ($q) use ($currentDate) {
                $q->where('offer_price', '>', 0)
                    ->where('offer_start_date', '<=', $currentDate)
                    ->where('offer_end_date', '>=', $currentDate);
            })->orWhere(function ($q) {
                $q->where('offer_price', null);
            });

            $query->orderByRaw('COALESCE(offer_price, price) ASC');
        }

        if ($orderby == 'price-desc') {
            $query->where(function ($q) use ($currentDate) {
                $q->where('offer_price', '>', 0)
                    ->where('offer_start_date', '<=', $currentDate)
                    ->where('offer_end_date', '>=', $currentDate);
            })->orWhere(function ($q) {
                $q->where('offer_price', null);
            });

            $query->orderByRaw('COALESCE(offer_price, price) DESC');
        }

        if ($orderby == 'date') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'asc');
        }

        $products = $query->paginate($perPage);
        $wishlistProductIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();

        return response()->json([
            'products' => $products,
            'wishlistProductIds' => $wishlistProductIds,
        ]);
    }

    public function productDetail(string $slug, Request $request)
    {
        $product = Product::query()
            ->with([
                'ProductImageGalleries',
                'ProductVariants',
            ])
            ->where(['status' => 1, 'slug' => $slug])
            ->first();

        //Đánh giá sản phẩm
        $reviews = ProductReview::query()->where('product_id', $product->id)->orderBy('id', 'DESC')->paginate(7);
        // $countReviews = ProductReview::query()->where('product_id', $product->id)->count();

        // Tăng lượt xem
        $product->increment('views');

        // Tìm sản phẩm liên quan
        $productRelated = Product::query()
            ->with(['ProductImageGalleries', 'category'])
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                    ->orWhere('brand_id', $product->brand_id);
            })
            ->orderBy('created_at', 'desc') // Sắp xếp sản phẩm mới nhất
            ->limit(6)
            ->get();
        $variantGroups = [];
        $variantArray = [];
        foreach ($product->ProductVariants as $variant) {
            $variantIds = json_decode($variant->id_variant, true);

            foreach ($variantIds as $variantId) {
                $attribute = Attribute::query()->with('categoryAttribute')->findOrFail($variantId);

                // Kiểm tra danh mục thuộc tính
                if ($attribute->categoryAttribute->title === 'Color') {
                    $currentVariant['color'] = $attribute->title; // Lưu màu sắc
                } elseif ($attribute->categoryAttribute->title === 'Size') {
                    $currentVariant['size'] = $attribute->title; // Lưu kích cỡ
                }
                $variantGroups[$attribute->categoryAttribute->title][] = $attribute->title;
            }

            // Nếu có cả màu sắc và kích cỡ, thêm vào mảng biến thể
            if (isset($currentVariant['color']) && isset($currentVariant['size'])) {
                $color = $currentVariant['color'];
                $size = $currentVariant['size'];

                // Khởi tạo mảng cho màu nếu chưa có
                if (!isset($variantArray[$color])) {
                    $variantArray[$color] = [];
                }
                $variantArray[$color][$size] = $variant->qty;
            }
        }
        // dd($variantGroups);
        // Chuyển đổi mảng PHP thành JSON
        $variantDataJson = json_encode($variantArray);
        // dd($variantDataJson);
        foreach ($variantGroups as $category => $attributes) {
            $variantGroups[$category] = array_values(array_unique($attributes));
        }
        // dd($variantGroups);
        if ($request->ajax()) {
            return view('client.page.product.review-list', compact('reviews'))->render();
        }
        return view('client.page.product.product-details', compact('product', 'variantGroups', 'variantDataJson', 'productRelated', 'reviews'));
    }
    public function updateWishlist(Request $request)
    {
        if ($request->ajax()) {
            if (!Auth::check()) {
                return response()->json(['action' => 'not_logged_in'], 403); // Trả về mã lỗi 403
            }
            $data = $request->all();
            // print_r($data);
            $countWishlist = Wishlist::countWishlist($data['product_id']);

            $wishlist = new Wishlist;
            if ($countWishlist == 0) {
                $wishlist->product_id = $data['product_id'];
                $wishlist->user_id = $data['user_id'];
                $wishlist->save();
                return response()->json(['action' => 'add']);
            } else {
                Wishlist::where(['user_id' => Auth::user()->id, 'product_id' => $data['product_id']])->delete();
                return response()->json(['action' => 'remove']);
            }
        }
    }

    public function totalWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $total_wishlist = Wishlist::where(['user_id' => Auth::user()->id])->count();
        echo json_encode($total_wishlist);
    }


    //reviews
    public function reviews(Request $request)
    {
        $request->validate([
            'review' => ['required', 'max:250', 'string'],
            'product_id' => ['required'],
            'rate' => ['required', 'integer', 'between:1,5'],
        ], [
            'review.required' => 'Bạn phải nhập Đánh giá.',
            'review.max' => 'Đánh giá không được vượt quá 250 ký tự.',
            'review.string' => 'Đánh giá phải là một chuỗi văn bản hợp lệ.',
            'product_id.required' => 'Thiếu ID.',
            'rate.required' => 'Bạn phải chọn mức đánh giá.',
        ]);

        // Kiểm tra từ nhạy cảm
        if (BadwordsHelper::isProfane($request->review)) {
            return response([
                'status' => 'error',
                'message' => 'Đánh giá có chứa từ ngữ nhạy cảm',
            ]);
        }

        // Lưu đánh giá vào cơ sở dữ liệu
        $review = new ProductReview();
        $review->user_id = Auth::user()->id;
        $review->review = $request->review;
        $review->product_id = $request->product_id;
        $review->rate = $request->rate;
        $review->save();

        // Trả về review mới thêm vào
        return response([
            'status' => 'success',
            'message' => 'Đánh giá thành công',
            'review' => $review,
        ]);
    }

    public function getAllReviews(Request $request)
    {
        $reviews = ProductReview::query()
            ->where('product_id', $request->product_id)
            ->with('user')
            ->orderBy('id', 'DESC')
            ->paginate(7);
        $updateHtmlReview = view('client.page.product.review-list', compact('reviews'))->render();
        return response()->json([
            'updateHtmlReview' => $updateHtmlReview,
            'total' => $reviews->total(),
        ]);
    }
}
