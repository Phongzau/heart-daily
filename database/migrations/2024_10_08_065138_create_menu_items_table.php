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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title');
            $table->unsignedInteger('parent_id')->default(0);
            $table->integer('order');
            $table->string('slug');
            $table->string('url');
            // Tạo menu_id và thiết lập khóa ngoại
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            
            $table->boolean('status')->default(true);
            $table->unsignedInteger('userid_created')->nullable();
            $table->unsignedInteger('userid_updated')->nullable();
            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
