<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "startDate",
        "discountPercentage",
    ];

    public function order(){
        return $this->applied_in(Order::class); 
    }
}
