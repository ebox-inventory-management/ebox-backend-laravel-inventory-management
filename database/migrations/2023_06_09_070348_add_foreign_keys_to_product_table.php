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
        Schema::table('products', function (Blueprint $table) {
            $table->foreign(['id'], 'Product_category_id_fkey')->references(['id'])->on('categories')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign(['id'], 'Product_brand_id_fkey')->references(['id'])->on('brands')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign(['id'], 'Product_supplier_id_fkey')->references(['id'])->on('suppliers')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('Product_category_id_fkey');
            $table->dropForeign('Product_brand_id_fkey');
            $table->dropForeign('Product_supplier_id_fkey');

        });
    }
};
