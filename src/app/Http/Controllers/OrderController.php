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


        //Se o usuraio nao informar o cupom ele já irá criar o order
        if($request->couponId == null || $request->couponId == ""){
            $order = Order::create([
                "userId" => $userId,
                "addressId" => $userAddress['id'],
                "totalAmount" => $totalAmount
            ]);

            return response()->json([
                "message" => "Order created",
                $order
            ]);
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

    public function delete(string $id)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $order = Order::where('userId', $userId)->get();

        $orderId = [];

        foreach($order as $item){
            $orderId[] = $item->id;
        }

        if(!in_array($id, $orderId)){
            return response()->json([
                "error" => "Invalid order"
            ], 401);
        }

        $order->delete();

        return response()->json([
            "message" => "Order deleted succesfully"
        ], 200);
    }


    public function updateStatus(Request $request, string $id)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        if($userLogged->role != "moderator"){
            return response()->json([
                "error" => "Only moderators can update order status"
            ]);
        }

        $order = Order::findOrFail($id, 'id')->first();

        $request->validate([
            "status" => "required | in:pending,processing,shipped,completed,canceled"
        ]);

        $order->update([
            "status" => $request->status
        ]);

        $order->save();

        return response()->json([
            "message" => "Status updated",
            $order
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $order = Order::where("userId", $userId)->first();

        return response()->json([
            $order
        ]);
    }

    public function showAll()
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        if($userLogged->role == "user"){
            return response()->json([
                "error" => "Users can't access this information"
            ]);
        }

        $order = Order::all();

        return response()->json([
            $order
        ]);
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
