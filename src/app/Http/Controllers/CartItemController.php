<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
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

        $product = Product::find($validateItems['productId']);

        if(!$product){
            return response()->json([
                'error'=> 'Product not found'
            ]);
        }

        if($validateItems['quantity'] > $product->stock){
            return response()->json([
                "error" => "Can't add this quantity of products"
            ], 401);
        }

        $product->stock -= $validateItems['quantity'];
        $product->save();

        $cart = CartItem::create([
            "cartId" => $userCart['id'],
            "productId" => $validateItems['productId'],
            "quantity" => $validateItems['quantity'],
            "unitPrice" => $product['price']
        ]);

        return response()->json([
            "message" => "Product added to cart",
            $cart
        ]);
    }

    public function show(CartItem $cartItem)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $cart = Cart::where('userId', $userId)->first();

        $cartItem = CartItem::where("cartId", $cart->id)->get();

        return response()->json([
            $cartItem
        ], 200);
    }


    public function showCart()
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $cart = Cart::where("userId", $userId)->first();

        return response()->json([
            $cart
        ]);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $cart = Cart::where("userId", $userId)->first();

        $cartItem = CartItem::where("cartId", $cart->id)->get();

        $validateCart = $request->validate([
            "id" => "required | integer",
            "quantity" => "required | integer"
        ]);

        $selectedItem = CartItem::find($validateCart['id']);

        $selectedItem->update([
            "quantity" => $validateCart['quantity']
        ]);

        return response()->json([
            "message" => "Quantity updated",
            $selectedItem
        ], 200);
    }

    public function delete(string $id)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $cart = Cart::where("userId", $userId)->first();

        $cartItems = CartItem::where("cartId", $cart->id)->get();

        $itemId = [];

        foreach($cartItems as $item){
            $itemId[] = $item->id;
        }

        if(!in_array($id, $itemId)){
            return response()->json([
                "error" => "Invalid item"
            ], 401);
        }

        $product = Product::find($id);

        $selectedItem = CartItem::findOrFail($id);

        $product->stock += $selectedItem->quantity;
        $product->save();

        $selectedItem->delete();

        return response()->json([
            "message" => "Item deleted from cart",
            $selectedItem
        ]);
    }

    public function clearCart()
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $cart = Cart::where("userId", $userId)->first();

        $cartItems = CartItem::where("cartId", $cart->id)->get();

        $productIds = [];

        foreach($cartItems as $item){
            $productIds[] = $item->productId;
        }

        foreach($productIds as $productId){
            $product = Product::find($productId);
            
            $product->stock += $item->quantity;
            
            $product->save();
        }

        foreach($cartItems as $item){
            $item->delete();
        }

        return response()->json([
            "message" => "All items were deleted from cart",
            $cartItems
        ]);
    }
}
