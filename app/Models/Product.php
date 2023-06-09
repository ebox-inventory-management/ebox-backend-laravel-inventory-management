<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        "cat_id",
        "sup_id",
        "brand_id",
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
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Category::class);
    }
}
