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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("brand_id");
            $table->unsignedBigInteger("supplier_id");
            $table->string("product_name");
            $table->string("product_code");
            $table->string("product_garage");
            $table->string("product_route");
            $table->string("product_image");
            $table->string("buy_date");
            $table->string("expire_date");
            $table->string("buying_price");
            $table->string("price");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
