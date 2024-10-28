<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();                             // Primary key (id)
            $table->string('invoice_id');            // Mã hóa đơn (invoice_id)
            $table->foreignId('user_id')              // Khóa ngoại user_id liên kết tới bảng users
                ->constrained('users')
                ->onDelete('cascade');
            $table->double('sub_total');              // Tổng tiền hàng
            $table->double('amount');                 // Tổng tiền thanh toán (đã tính mã giảm giá + ship)
            $table->integer('product_qty');           // Số lượng sản phẩm
            $table->string('payment_method');         // Phương thức thanh toán
            $table->boolean('payment_status')         // Trạng thái thanh toán
                ->default(false);
            $table->json('order_address');            // Địa chỉ giao hàng
            $table->double('cod');                    // COD
            $table->json('coupon_method');            // Thông tin mã giảm giá (dạng JSON)
            $table->date('order_status');             // Trạng thái đơn hàng (theo ngày)
            $table->timestamps();                     // create_at và update_at (tự động)
            $table->softDeletes();                    // delete_at (xóa mềm)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
