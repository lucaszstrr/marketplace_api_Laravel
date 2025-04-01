<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
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
        
        $user = $request->validate([
            'name' => 'required | string',
            'email' => 'required | email',
            'password' => 'required | string'
        ]);

        $user = User::create($user);

        return response()->json([
            'message' => 'User created',
            $user
        ]);
    }

    public function login(Request $request){

        $validateLogin = $request->validate([
            'email' => 'required | email',
            'password' => 'required | string'
        ]);

        //Tenta procurar o email passado, ele verifica na tabela users na coluna email
        $user = User::where('email', $validateLogin['email'])->first();

        //Se o usuario nao for encontrado irá aparecer um erro
        if(!$user){
            return response()->json([
                "error" => "Unknown credentials",
                "message" => "Unknown credentials"
            ]);
        }

        //Aqui e feita uma comparacao da senha que foi passada com a senha do bd
        //O Hash::check verifica se a senha em texto puro bate com a senha hasheada
        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                "error" => "Unknown credentials",
                "message" => "Unknown credentials"
            ], 401);
        }

        //Aqui é criado um token de acesso para o usuario com a funcao createToken
        $token = $user->createToken('token')->plainTextToken;

        //Response dizendo que deu tudo certo
        return response()->json([
            "message" => "Login successfully",
            "user" => $user,
            "token" => $token
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == 'user'){
            return response()->json([
                'error'=> 'Only admins and moderator can access this information',
                'message'=> 'Only admins and moderator can access this information'
            ], 400);
        }

        $user = User::all();

        return response()->json([
            $user
        ]);
    }

    public function showId(string $id){
        
        $userLogged = Auth::user();

        $userRole = $userLogged->role;

        if($userRole == 'user'){
            return response()->json([
                'error'=> 'Only admins and moderator can access this information',
                'message'=> 'Only admins and moderator can access this information'
            ], 400);
        }

        $user = User::find($id);

        if(!$user){
            return response()->json([
                "error"=> "This user doesn't exists",
                "message"=> "This user doesn't exists"
            ],404);
        }

        return response()->json([
            $user
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
    public function update(Request $request)
    {
        //Pega o usuario que esta logado
        $userLogged = Auth::user();

        //Pega o tipo do usuario logado(se é user, admin ou moderator)
        $userType = $userLogged->role;

        $updateUser = $request->validate([
            'email' => 'required | email',
            'role' => 'required | in:admin,moderator,user'
        ]);

        //Verifica se o user logado é um user
        if($userType == "user" || $userType == "moderator"){
            return response()->json([
                "error" => "Logged user must be an admin"
            ]);
        }

        //Procura o email passado no request na tabela user no bd
        $targetUser = User::where("email", $updateUser['email'])->first();

        if(!$targetUser){
            return response()->json([
                "error" => "User not found",
                "message" => "User not found"
            ]);
        }

        //Atualiza o usuário que foi passado
        $targetUser->role = $updateUser['role'];
        $targetUser->save();

        //Isso pega o nome do user que vamos alterar
        $userName = $targetUser->name;

        //Isso pega o tipo do user que vamos alterar
        $targetUserRole = $updateUser['role'];

        return response()->json([
            "message" => "Job title from user $userName updated to $targetUserRole",
        ], 200);
    }

    public function updateUserLogged(Request $request)
    {
        //Validacao do id user
        $user = User::findOrFail(Auth::id());

        $validateUser = $request->validate([
            'name' => 'required | string',
            'email' => 'required | email',
            'password' => 'required | string',
        ]);

        $user->update($validateUser);

        return response()->json([
            "message" => "User updated succesfully",
            $validateUser
        ], 200);
    }

    public function userDelete()
    {
        //Valida o id do user logado
        $user = User::findOrFail(Auth::id());

        //Valida o user
        $userLogged = Auth::user();

        $userName = $userLogged->name;

        $user->delete();

        return response()->json([
            "message"=> "User $userName was deleted succesfully",
        ],200);
    }

    public function profile()
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $addresses = Address::where("userId", $userId)->get();

        return response()->json([
            $userLogged,
            "Addresses below",
            $addresses
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
