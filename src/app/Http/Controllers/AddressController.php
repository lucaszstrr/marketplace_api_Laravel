<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        return response()->json([
            $user
        ]);
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
        //Essa funcao vai verificar qual user está logado
        $userLogged = Auth::user();

        $validateAddress = $request->validate([
            'street' => 'required | string',
            'number' => 'required | integer',
            'zip' => 'required | string',
            'city' => 'required | string',
            'state' => 'required | string',
            'country' => 'required | string',
        ]);

        //Isso pega o nome do user logado
        $userName = $userLogged->name;

        //Cria um endereco atrelado ao id do user que foi logado
        $address = Address::create([
            'userId' => $userLogged->id,
            'street' => $validateAddress['street'],
            'number' => $validateAddress['number'],
            'zip' => $validateAddress['zip'],
            'city' => $validateAddress['city'],
            'state' => $validateAddress['state'],
            'country' => $validateAddress['country'],
        ]);

        return response()->json([
            "message" => "Adress added to $userName",
            $address
        ]);
    }

    public function show()
    {
        $userId = Auth::id();

        $address = Address::where('userId', $userId)->get();

        return response()->json([
            $address
        ]);
    }

    public function showSpecific(string $id)
    {
        $userId = Auth::id();

        $address = Address::findOrFail($id);

        if($userId != $address->userId){
            return response()->json([
                "error" => "This address doesnt belongs to user logged",
            ], 401);
        }

        return response()->json([
            $address
        ]);
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //Pega o id do user logado
        $userLogged = Auth::id();

        $validateAddress = $request->validate([
            'street' => 'required | string',
            'number' => 'required | integer',
            'zip' => 'required | string',
            'city' => 'required | string',
            'state' => 'required | string',
            'country' => 'required | string',
        ]);

        $address = Address::findOrFail($id);

        if($address->userId != $userLogged){
            return response()->json([
                'error'=> 'You are not the owner of this address',
                'message'=> 'You are not the owner of this address'
            ]);
        }

        $address->update($validateAddress);

        return response()->json([
            "message" => "Address updated succesfully",
            $address
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
