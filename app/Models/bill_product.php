<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_product extends Model
{
    use HasFactory;


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
