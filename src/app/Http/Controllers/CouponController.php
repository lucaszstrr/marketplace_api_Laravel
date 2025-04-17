<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function store(Request $request)
    {
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == 'user' || $userRole == 'moderator'){
            return response()->json([
                "error" => "Only admins can create new coupons"
            ], 401);
        }

        $coupon = $request->validate([
            "code" => "required | string",
            "discountPercentage" => "required | numeric"
        ]);

        if($coupon["discountPercentage"] <= 0 || $coupon["discountPercentage"] > 100){
            return response()->json([
                "error" => "Discount percentage must be a valid value between 0 and 100"
            ], 401);
        }

        $couponName = $coupon['code'];

        $coupon = Coupon::create($coupon);

        return response()->json([
            "message" => "Coupon $couponName created succesfully"
        ], 201);
    }

    public function show()
    {
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == 'user' || $userRole == 'moderator'){
            return response()->json([
                "error" => "Only admins can create new coupons"
            ], 401);
        }

        $coupon = Coupon::all();

        return response()->json([
            $coupon
        ], 200);
    }

    public function showSpecific(string $id)
    {
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == 'user' || $userRole == 'moderator'){
            return response()->json([
                "error" => "Only admins can create new coupons"
            ], 401);
        }

        $coupon = Coupon::find($id);

        if(!$coupon){
            return response()->json([
                "error" => "This coupon doesn't exists"
            ], 404);
        }

        return response()->json([
            $coupon
        ], 200);
    }

    public function delete(string $id)
    {
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == 'user' || $userRole == 'moderator'){
            return response()->json([
                "error" => "Only admins can create new coupons"
            ], 401);
        }

        $coupon = Coupon::find($id);

        if(!$coupon){
            return response()->json([
                "error"=> "Only admins can delete coupons"
            ], 401);
        }

        $couponName = $coupon->name;

        $coupon->delete();

        return response()->json([
            "message" => "Coupon $couponName deleted succesfully"
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == 'user' || $userRole == 'moderator'){
            return response()->json([
                "error" => "Only admins can create new coupons"
            ], 401);
        }

        $validateCoupon = $request->validate([
            "code" => "required | string",
            "startDate" => "required | date",
            "endDate" => "required | date",
            "discountPercentage" => "required | numeric"
        ]);

        $coupon = Coupon::find($id);

        $coupon->update($validateCoupon);

        return response()->json([
            "message" => "Coupon updated succesfully",
            $validateCoupon
        ], 201);
    }
}
