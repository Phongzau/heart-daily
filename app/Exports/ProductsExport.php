<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new ProductsSummarySheet();
        $products = Product::with(['ProductVariants', 'category', 'brand'])->get();
        foreach ($products as $product) {
            $sheets[] = new ProductVariantsSheet($product);
        }

        return $sheets;
    }
}

