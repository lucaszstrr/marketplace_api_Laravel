<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $request->validate([
            "addressId" => "required | integer",
            "couponId" => "nullable | integer"
        ]);
        
        $userAddress = Address::where("id", $request->addressId)->where("userId", $userId)->first();

        if(!$userAddress){
            return response()->json([
                "error" => "Invalid address"
            ]);
        }

        $user = User::findOrFail($userId);

        //Isso puxa os itens do carrinho do usuario logado
        $userCart = $user->cart->cartItems;

        $totalAmount = 0;

        //Isso percorre cada item do cart e faz a soma dos valores dos produtos
        foreach($userCart as $item){
            $totalAmount += $item['quantity'] * $item['unitPrice'];
        }

        $foundCoupon = Coupon::where('id', $request->couponId)->first();

        if($foundCoupon){
            $percentage = $foundCoupon['discountPercentage'];

            $discount = ($totalAmount * $percentage) / 100;

            $totalAmount -= $discount;  
        }

        $order = Order::create([
            "userId" => $userId,
            "addressId" => $userAddress['id'],
            "couponId" => $foundCoupon['id'],
            "totalAmount" => $totalAmount
        ]);


        return response()->json([
            "message" => "Order created",
            $order
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
