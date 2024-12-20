<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhật trạng thái đơn hàng từ shipped sang delivered sau 3 ngày';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Lấy danh sách đơn hàng có trạng thái shipped và đã quá 3 ngày
        $orders = Order::where('order_status', 'shipped')
            ->whereDate('updated_at', '<=', Carbon::now()->subDays(3))
            ->get();

        // Cập nhật trạng thái sang delivered
        foreach ($orders as $order) {
            $order->update([
                'order_status' => 'delivered',
            ]);
            $this->info("Order ID {$order->id} đã được cập nhật sang trạng thái hoàn tất.");
        }

        $this->info("Đã xử lý tất cả đơn hàng đủ điều kiện.");
        return 0;
    }
}
