<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Storage;

class ProductsSummarySheet implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {

        return Product::with(['category', 'brand', 'ProductVariants'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tên sản phẩm',
            'Giá',
            'Tồn kho',
            'Loại sản phẩm',
            'Danh mục',
            'Thương hiệu',
            'Hình ảnh'
        ];
    }

    public function map($product): array
    {
        if ($product->type_product === 'product_simple') {
        
            $price = $product->offer_price > 0 ? $product->offer_price : $product->price;
        } else {
       
            $totalPrice = 0;
            foreach ($product->ProductVariants as $productVariant) {
                if ($productVariant->offer_price_variant > 0) {
                    $totalPrice += $productVariant->offer_price_variant;
                } else {
                    $totalPrice += $productVariant->price_variant;
                }
            }
            $price = $totalPrice;
        }

       
        $price = is_numeric($price) ? $price : 0;

        $qty = $product->type_product === 'product_simple'
            ? $product->qty
            : $product->ProductVariants->sum('qty');
            $qty = is_numeric($qty) ? $qty : 0;
        return [
            $product->id,
            $product->name,
            number_format($price) . ' VND',
            $qty,
            $product->type_product === 'product_simple' ? 'Đơn giản' : 'Biến thể',
            $product->category->title ?? 'N/A', 
            $product->brand->name ?? 'N/A', 
            Storage::url($product->image), 
        ];
    }



}
