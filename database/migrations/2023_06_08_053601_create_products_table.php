<?php

use App\Models\Income;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("product_name");
            $table->integer("product_quantity");
            $table->string("product_code");
            $table->string("product_garage");
            $table->string("product_route");
            $table->string("product_image");
            $table->string("buy_date");
            $table->string("expire_date");
            $table->string("import_price");
            $table->string("export_price");
            $table->decimal('total_import', 8, 2)->nullable();
            $table->timestamps();
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
