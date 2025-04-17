<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
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
                "error" => "Unknown credentials"
            ]);
        }

        //O Hash::check verifica se a senha em texto puro bate com a senha hasheada
        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                "error" => "Unknown credentials"
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

    public function create(Request $request)
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
}
