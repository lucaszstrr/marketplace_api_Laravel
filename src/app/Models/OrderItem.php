<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        "orderId",
        "productId",
        "quantity",
        "unitPrice",
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'id');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
