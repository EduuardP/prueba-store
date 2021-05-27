<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable =   [
                            'client',
                            'phone',
                            'email',
                            'subtotal',
                            'IVA',
                            'total',
                            ];

    protected $with = ['products'];
    
    public function products()
    {
        return $this->belongsToMany(Product::class,'bill_products',"bill_id",'product_id')
                    ->withPivot('quantity');
    }
    
}
