<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColorsTable extends Migration
{
    public function up()
    {
        // Xóa bảng colors
        Schema::dropIfExists('colors');
    }

    public function down()
    {
        // Nếu muốn phục hồi lại bảng khi rollback
        Schema::create('colors', function (Blueprint $table) {
            $table->id(); 
            $table->string('name'); 
            $table->string('code'); 
            $table->string('slug'); 
            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }
}
