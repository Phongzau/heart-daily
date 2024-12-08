<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ReservedStock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReleaseExpiredStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:release-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Giải phóng số lượng sản phẩm đã hết thời gian giữ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::transaction(function () {
            // Lấy các bản ghi hết hạn theo nhóm
            ReservedStock::query()
                ->where('expires_at', '<', now())
                ->chunkById(100, function ($expiredStocks) {
                    foreach ($expiredStocks as $stock) {
                        $product = Product::query()->find($stock->product_id);
                        if ($product) {
                            if ($product->type_product == 'product_variant' && $stock->variant_id) {
                                ProductVariant::query()->where('id', $stock->variant_id)->increment('qty', $stock->reserved_qty);
                            } else if ($product->type_product == 'product_simple') {
                                Product::query()->where('id', $stock->product_id)->increment('qty', $stock->reserved_qty);
                            }
                        }
                        $stock->delete();
                    }
                });
        });
        $this->info('Đã giải phóng số lượng sản phẩm hết thời gian giữ.');
    }
}
