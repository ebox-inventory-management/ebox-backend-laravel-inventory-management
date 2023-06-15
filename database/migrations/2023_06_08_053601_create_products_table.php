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
            $table->string("product_name")->unique();
            $table->string("product_quantity");
            $table->string("product_code");
            $table->string("product_garage");
            $table->string("product_route");
            $table->string("product_image");
            $table->string("expire_date");
            $table->integer("import_price");
            $table->integer("export_price");
            $table->integer("total_import");
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
