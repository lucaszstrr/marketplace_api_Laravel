<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryId',
        'name', 
        'stock',
        'price',
        'coupon',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function cartItems(){
        return $this->belongsTo(CartItem::class);
    }

}
