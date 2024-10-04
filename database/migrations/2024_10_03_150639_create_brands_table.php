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
        Schema::create('brands', function (Blueprint $table) {
            $table->id(); // id (Primary key)
            $table->string('name'); // varchar for name
            $table->text('image'); // text for image
            $table->string('slug'); // varchar for slug
            $table->string('description')->nullable(); // varchar for description, nullable
            $table->boolean('status'); // boolean for status
            $table->timestamp('created_at')->nullable(); // timestamp for create_at
            $table->timestamp('updated_at')->nullable(); // timestamp for update_at
            $table->timestamp('deleted_at')->nullable(); // timestamp for delete_at (soft delete)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
