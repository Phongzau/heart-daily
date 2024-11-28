<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Models\Brand;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InventoryProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = CategoryProduct::all();
        $brands = Brand::all();
        $query = Product::query()
            ->with(['ProductVariants', 'reviews', 'category', 'brand', 'supplier']);

        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('price_min') && $request->price_min) {
            $query->where('price_import', '>=', $request->price_min);
        }

        if ($request->has('price_max') && $request->price_max) {
            $query->where('price_import', '<=', $request->price_max);
        }
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('brand_id') && $request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->has('type_product') && $request->type_product) {
            $query->where('type_product', $request->type_product);
        }

        $products = $query->paginate(13);
        return view('admin.page.inventory.index', compact('products', 'categories', 'brands'));
    }

    public function exportToExcel()
    {
        return Excel::download(new ProductsExport, 'san_pham.xlsx');
    }

    public function productDetail(string $productId)
    {
        $product = Product::query()->with(['ProductVariants', 'reviews', 'category', 'brand'])->findOrFail($productId);
        $product->image_url = Storage::url($product->image);
        if ($product && $product->type_product === 'product_variant') {
            $variants = $product->ProductVariants->map(function ($variant) use ($product) {
                $titleVariant = implode(
                    ' / ',
                    json_decode($variant->title_variant, true),
                );
                $sold = OrderProduct::query()
                    ->where('product_id', $product->id)
                    ->whereJsonContains('id_variants', json_decode($variant->id_variant, true))
                    ->whereHas('order', function ($query) {
                        $query->where('order_status', 'delivered');
                    })
                    ->sum('qty');
                if ($variant->offer_price_variant > 0) {
                    $priceVariant = $variant->offer_price_variant;
                } else {
                    $priceVariant = $variant->price_variant;
                }
                return [
                    'name' => $titleVariant,
                    'priceVariant' => number_format($priceVariant) . ' VND',
                    'qty' => $variant->qty,
                    'sold' => $sold ? $sold : 0,
                ];
            });

            $priceArray = [];
            foreach ($product->ProductVariants as $productVariant) {
                if ($productVariant->offer_price_variant > 0) {
                    $priceArray[] = $productVariant->offer_price_variant;
                } else {
                    $priceArray[] = $productVariant->price_variant;
                }
            }
            sort($priceArray);
            $priceProduct = '';
            if (count(array_unique($priceArray)) === 1) {
                $priceProduct = number_format($priceArray[0]) . ' VND';
            } else {
                $priceProduct =
                    number_format($priceArray[0]) .
                    ' VND ~ ' .
                    number_format(end($priceArray)) .
                    ' VND';
            }

            $product->priceProduct = $priceProduct;

            return response()->json([
                'status' => 'success',
                'product' =>  $product,
                'variants' => $variants,
            ]);
        } else if ($product && $product->type_product === 'product_simple') {
            $sold = OrderProduct::query()
                ->where('product_id', $product->id)
                ->whereHas('order', function ($query) {
                    $query->where('order_status', 'delivered');
                })
                ->sum('qty');
            $product->priceProduct = checkDiscount($product) ? number_format($product->offer_price) . ' VND' : number_format($product->price) . ' VND';
            $product->name = limitText($product->name, 25);
            return response()->json([
                'status' => 'success',
                'product' => $product,
                'sold' => $sold ? $sold : 0,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại.',
        ]);
    }
}
