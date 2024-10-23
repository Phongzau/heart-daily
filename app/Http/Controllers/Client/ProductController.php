<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->input('count', 12);
        $products = Product::query()->where('status', 1)->paginate($perPage);
        return view('client.page.product.list_product', compact('products'));
    }

    public function ajaxIndex(Request $request)
    {
        $perPage = $request->input('count', 12);
        $orderby  = $request->input('orderby', 'menu_order');

        $query = Product::with('brand')->where('status', 1);

        if ($orderby == 'price') {
            $query->orderBy('price', 'asc');
        } elseif ($orderby == 'price-desc') {
            $query->orderBy('price', 'desc');
        } elseif ($orderby == 'date') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'asc'); // Mặc định
        }

        $products = $query->paginate($perPage);

        return response()->json([
            'products' => $products,
        ]);
    }

    public function productDetail(string $slug)
    {
        $product = Product::query()
            ->with(['ProductImageGalleries', 'ProductVariants'])
            ->where(['status' => 1, 'slug' => $slug])
            ->first();
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

        return view('client.page.product-details', compact('product', 'variantGroups', 'variantDataJson', 'productRelated'));
    }
}
