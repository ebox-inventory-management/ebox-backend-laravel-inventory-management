<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_name",
        "product_code",
        "product_garage",
        "product_route",
        "product_image",
        "buy_date",
        "expire_date",
        "buying_price",
        "price",
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}