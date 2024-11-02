<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id(); 
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('category_attribute_id'); 
            $table->double('price_start')->nullable(); 
            $table->double('price_end')->nullable(); 
            $table->boolean('status')->default(true); 
            $table->unsignedInteger('userid_created')->nullable();
            $table->unsignedInteger('userid_updated')->nullable();
            $table->timestamps(); 

          
            $table->foreign('category_attribute_id')->references('id')->on('category_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
}
