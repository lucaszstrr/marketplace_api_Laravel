<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
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

        //Pega o carrinho do usuário logado
        $user = User::findOrFail($userLogged->id);

        $userCart = $user->cart->cartItems;

        $validateOrderItems = $request->validate([
            "productId" => "required | integer",
            "quantity" => "required | integer"
        ]);


        return response()->json([
            $userCart
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}


//Isso pega todos os itens do carrinho do usuario logado
// $userCartItems = CartItem::where("cartId", $userCart->id)->get();

// //Vê se o usuário tem um Order Items criado na tabela
// $userOrderItem = OrderItem::find($userCart->id);

// if(!$userOrderItem){
//     $createOrderItems = OrderItem::create([
//         "productId" => $validateOrderItems['productId'],
//         "quantity" => $validateOrderItems['quantity']
//     ]);
// }

// $createOrderItems = OrderItem::create([
//     "productId" => $validateOrderItems['productId'],
//     "quantity" => $validateOrderItems['quantity']
// ]);

// $userCart = $user->cart->cartItems;