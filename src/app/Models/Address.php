<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable =[
        'userId',
        'street',
        'number',
        'zip',
        'city',
        'state',
        'country',
    ];

    protected $table = "address";
    
    public function user(){
        return $this->has(User::class);
    }

    public function order(){
        return $this->has(Order::class);
    }
}
