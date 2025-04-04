<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
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

        $userRole = $userLogged->role;

        if($userRole == 'user' || $userRole == 'moderator'){
            return response()->json([
                "error" => "Only admins can create new coupons"
            ], 401);
        }

        $coupon = $request->validate([
            "code" => "required | string",
            "startDate" => "required | date",
            "endDate" => "required | date",
            "discountPercentage" => "required | numeric"
        ]);

        $couponName = $coupon['code'];

        $coupon = Coupon::create($coupon);

        return response()->json([
            "message" => "Coupon $couponName created succesfully"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
