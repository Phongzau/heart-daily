<?php

namespace App\Exports;

use App\Models\OrderProduct;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductVariantsSheet implements FromCollection, WithHeadings, WithMapping
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function collection()
    {
        return $this->product->productVariants;
    }

    public function headings(): array
    {
        return ['Tên biến thể', 'Giá', 'Số lượng', 'Đã bán'];
    }

    public function map($variant): array
    {
        $idVariants = json_decode($variant->id_variant);
        $soldQty = OrderProduct::where('product_id', $this->product->id)
            ->where(function ($query) use ($idVariants) {
                foreach ($idVariants as $id) {

                    $query->whereJsonContains('id_variants', $id);
                }
            })
            ->sum('qty');

        return [
            $variant->title_variant,
            number_format($variant->offer_price_variant > 0 ? $variant->offer_price_variant : $variant->price_variant) . ' VND',
            $variant->qty,
            $soldQty,

        ];
    }
}
