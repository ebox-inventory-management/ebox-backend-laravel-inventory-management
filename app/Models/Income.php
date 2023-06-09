<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;


    protected $fillable=[
        "income_details",
        "income_amount",
        "date",
        "month",
        "year",
    ];
}
