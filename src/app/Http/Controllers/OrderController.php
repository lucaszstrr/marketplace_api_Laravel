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

        if($request->couponId){

            $foundCoupon = Coupon::where('id', $request->couponId)->first();

            if(!$foundCoupon){
                return response()->json([
                    "message" => "Invalid coupon"
                ], 404);
            }

            $order = Order::create([
                "userId" => $userId,
                "addressId" => $userAddress['id'],
                "couponId" => $foundCoupon['id']
            ]);

            return response()->json([
                "message" => "Order created",
                $order
            ]);

        }
        
        $order = Order::create([
            "userId" => $userId,
            "addressId" => $userAddress['id']
        ]);

        return response()->json([
            "message" => "Order created",
            $order
        ]);
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
            "message" => "Order deleted succesfully",
            $order
        ], 200);
    }
}
