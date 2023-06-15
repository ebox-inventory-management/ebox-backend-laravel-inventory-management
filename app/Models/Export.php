<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;

    protected $with = ['products'];

    public function export()
    {
        return $this->hasMany(Products::class);
    }
}
