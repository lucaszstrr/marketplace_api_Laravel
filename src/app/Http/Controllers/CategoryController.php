<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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

        //Aqui verificamos o user logado
        $userLogged = Auth::user();

        //Isso pega o role(papel) do user logado
        $userLoggedRole = $userLogged->role;

        //A criação de categorias é restrita aos admins
        if($userLoggedRole == 'user' || $userLoggedRole == 'moderator'){
            return response()->json([
                "error" => "Only admins can create new categories",
                "message" => "Only admins can create new categories"
            ]);
        }

        $category = $request->validate([
            'name' => 'required | string',
            'description' => 'required | string'
        ]);

        $category = Category::create($category);

        return response()->json([
            "message" => "Category $category->name created by $userLogged->name",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function showAll(Category $category)
    {
        //Pegar a model categoria
        $allCategories = Category::all();

        return response()->json([
            $allCategories
        ]);
    }

    public function showOne(Category $category, string $id)
    {
        //Aqui pega uma categoria especifica
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                "error" => "Category not found",
                "message" => "Category not found"
            ], 404);
        }

        return response()->json([
            $category
        ]);

    }

    public function createdBy(string $id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, string $id)
    {

        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == "user" || $userRole == "moderator"){
            return response()->json([
                "error" => "Only admins can update categories",
                "message" =>"Only admins can update categories"
            ], 401);
        }

        $category = Category::find($id);

        if(!$category){
            return response()->json([
                "error"=> "Category not found",
                "message"=> "Category not found"
            ],404);
        }

        $categoryUpdate = $request->validate([
            'name' => 'required | string',
            'description' => 'required | string'
        ]);


        $category->name = $categoryUpdate['name'];
        $category->description = $categoryUpdate['description'];
        $category->save();

        return response()->json([
            "message" => "Category updated sucessfully",
            $category
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Category $category, string $id)
    {
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == "user"|| $userRole == "moderator"){
            return response()->json([
                "error"=> "Only admins can delete categories",
                "message"=> "Only admins can delete categories"
            ]);
        }

        $validateId = Category::find($id);

        if(!$validateId){
            return response()->json([
                "error"=> "Category not found",
                "message"=> "Category not found"
            ], 404);
        }

        // return response()->json([
        //     $validateId
        // ]);

        $categoryName = $validateId->name; 

        DB::table("categories")->where("id", $id)->delete();

        return response()->json([
            "message" => "Category $categoryName was deleted"
        ]);
    }
}
