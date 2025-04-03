<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
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

        $userId = Auth::id();

        $validate = Cart::where('userId', $userId)->first();

        if($validate){
            return response()->json([
                "error" => "This user already has a cart"
            ]);
        }

        $user = Cart::create([
            'userId' => $userId
        ]);

        return response()->json([
            "message" => "Cart created succesfully",
            "cart" => $user
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        $userCart = Cart::where('userId', $userId)->first();

        if(!$userCart){
            return response()->json([
                'error'=> 'Cart not found'
            ]);
        }

        $validateItems = $request->validate([
            'productId' => 'required | integer',
            'quantity' => 'required | integer',
        ]);

        $products = Product::find($validateItems['productId']);

        if(!$products){
            return response()->json([
                'error'=> 'Product not found'
            ]);
        }

        $cart = CartItem::create([
            "cartId" => $userCart['id'],
            "productId" => $validateItems['productId'],
            "quantity" => $validateItems['quantity'],
            "unitPrice" => $products['price']
        ]);


        return response()->json([
            "message" => "Product added to cart",
            $cart
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        //
    }
}
