<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with(['ProductVariants', 'reviews', 'category', 'brand'])
            ->paginate(13);
        return view('admin.page.inventory.index', compact('products'));
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
