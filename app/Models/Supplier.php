<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "email",
        "phone",
        "photo",
        "shop_name",
        "address",
        "type",
        "city",
        "bank_name",
        "bank_number",
    ];
    protected $with = ['products'];


    public function products()
    {
        return $this->hasMany(Products::class);
    }
}