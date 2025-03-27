<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth as FacadesAuth;

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
        // $user = User::findOrFail($id);
        // FacadesAuth::login($user);

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
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
