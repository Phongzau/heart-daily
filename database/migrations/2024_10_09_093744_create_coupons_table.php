<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 255);
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('max_use');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('discount_type', 255);
            $table->double('discount');
            $table->double('min_order_value');
            $table->unsignedInteger('total_used');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
