<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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

        $user = User::findOrFail($userLogged->id);

        //Pega o carrinho do usuário logado
        $userCart = $user->cart->cartItems;

        $validateOrderItems = $request->validate([
            "productId" => "required | integer"
        ]);

        //Percorre cada item do carrinho do usuario e armazena o id em um array para fazer a validação
        foreach($userCart as $item){
            $carts[] = $item->id;
        }

        //Valida se o produto passado no request é um item do usuario
        if(!in_array($validateOrderItems["productId"], $carts)){
            return response()->json([
                "error" => "Cannot add this item"
            ], 401);
        }

        //Puxa o produto com base no id passado na validacao
        $selectedItem = CartItem::where("id", $validateOrderItems["productId"])->first();

        //Puxa o produto da tabela products
        $product = Product::where("id", $selectedItem->productId)->first();


        $totalAmount = 0;

        $itemQuantity = $selectedItem->quantity;

        $itemPrice = $selectedItem->unitPrice;

        $totalAmount += $itemQuantity * $itemPrice;

        //Puxa o order do usuario
        $order = $user->order;

        $order->totalAmount += $totalAmount;

        $order->save();

        $orderItem = OrderItem::create([
            "orderId" => $order->id,
            "productId" => $product->id,
            "quantity"=> $selectedItem->quantity,
            "unitPrice" => $selectedItem->unitPrice,
        ]);

        return response()->json([
            "message" => "Product added to order",
            $product->name,
            $product->price
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $order = Order::where("userId", $userId)->first();

        $orderItems = OrderItem::where("orderId", $order->id)->get();

        return response()->json([
            $orderItems
        ]);
    }

    public function showSpecific(string $id)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $order = Order::where("userId", $userId)->first();

        $orderItems = OrderItem::where("id", $id)->where("orderId", $order->id)->get();

        if ($orderItems->isEmpty()) {
            return response()->json([
                "error" => "Invalid item"
            ], 401);
        }

        return response()->json([
            $orderItems
        ]);
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
    public function delete(string $id)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $user = User::findOrFail($userId);

        //Isso puxa a order do usuario logado
        $order = Order::where("userId", $userId)->first();

        //Isso puxa os itens do pedido do usuário logado
        $orderItems = OrderItem::where("orderId", $order->id)->get();

        $itemId = [];

        //Percorre os itens do pedido e armazena os id's em um array
        foreach($orderItems as $item){
            $itemId[] += $item->id;
        }

        if(!in_array($id, $itemId)){
            return response()->json([
                "error" => "Invalid item"
            ]);
        }

        $orderId = OrderItem::find($id);

        $order->totalAmount -= $orderId->unitPrice;
        $order->save();
        
        $orderId->delete();

        return response()->json([
            "message" => "Item deleted succesfully"
        ], 200);
    }
}





// $foundCoupon = Coupon::where('id', $order->couponId)->first();

// if(!$foundCoupon){
//     $order->save();

//     $orderItem = OrderItem::create([
//         "orderId" => $order->id,
//         "productId" => $product->id,
//         "quantity"=> $selectedItem->quantity,
//         "unitPrice" => $selectedItem->unitPrice,
//     ]);

//     return response()->json([
//         "message" => "Product added to order",
//         $product->name,
//         $product->price
//     ],200);
// }

// $discount = $foundCoupon->discountPercentage / 100;

// $discountPrice = $order->totalAmount * $discount;

// $order->totalAmount -= $discountPrice;