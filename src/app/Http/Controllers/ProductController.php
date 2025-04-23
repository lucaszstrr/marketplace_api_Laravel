<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == 'user'){
            return response()->json([
                "error" => "You are not a moderator or admin to create new products"
            ], 400);
        }

        $product = $request->validate([
            'categoryId' => 'required | integer',
            'name' => 'required | string',
            'stock' => 'required | integer',
            'price' => 'required | numeric',
            'coupon' => 'required | boolean',
            'image' => 'required | image',
        ]);

        $foundId = Category::find($product['categoryId'], 'id');

        if(!$foundId){
            return response()->json([
                'error' => "This id doesn't exists"
            ],400);
        }

        $productName = $product["name"];

        $imageName = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

        $path = Storage::putFileAs('products', $request->file('image'), $imageName);

        $product = Product::create([
            "categoryId" => $product['categoryId'],
            "name" => $product['name'],
            "stock" => $product['stock'],
            "price" => $product['price'],
            "coupon" => $product['coupon'],
            "image" => $path
        ]);
        
        return response()->json([
            "message" => "Product '$productName' was created succesfully",
            $product
        ]);
    }

    public function show()
    {
        $products = Product::all();

        return response()->json([
            $products
        ]);
    }

    public function showId(string $id){
        $product = Product::find($id);

        if(!$product){
            return response()->json([
                "error"=> "This id doesn't exists",
                "message"=> "This id doesn't exists"
            ],404);
        }

        return response()->json([
            $product
        ], 200);

    }

    public function delete(Request $request, string $id)
    {
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == 'user'){
            return response()->json([
                'error'=> 'Only moderators can delete products',
                'message'=> 'Only moderators can delete products'
            ], 400);
        }

        $product = Product::find($id);

        if(!$product){
            return response()->json([
                "error" => "This id doesn't exists",
                "message" => "This id doesn't exists"
            ],404);
        }

        $productName = $product["name"];

        $product->delete();

        return response()->json([
            "message" => "Product '$productName' was deleted"
        ],200);
    }

    public function update(Request $request, string $id)
    {
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == "user"){
            return response()->json([
                "error"=> "Only moderators can update products",
                "message"=> "Only moderators can update products"
            ], 400);
        }

        $product = Product::find($id);

        if(!$product){
            response()->json([
                "error" => "Product id wasn't found",
                "message"=> "Product id wasn't found"
            ], 404);
        }

        $updateProduct = $request->validate([
            'name' => 'required | string',
            'stock' => 'required | integer',
            'price' => 'required | numeric'
        ]);

        $product->name = $updateProduct['name'];
        $product->stock = $updateProduct['stock'];
        $product->price = $updateProduct['price'];
        $product->save();

        $userName = $userLogged->name;

        return response()->json([
            'message'=> "Product updated succesfully by $userName",
            $product
        ], 200);
    }
}
