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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->date('variant_offer_start_date')->after('offer_price_variant')->nullable();
            $table->date('variant_offer_end_date')->after('variant_offer_start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('variant_offer_start_date');
            $table->dropColumn('variant_offer_end_date');
        });
    }
};
