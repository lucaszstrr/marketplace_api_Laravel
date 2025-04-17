<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return response()->json([
            $user
        ]);
    }

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

    public function delete(string $id)
    {
        $userLogged = Auth::user();

        $userId = $userLogged->id;

        $addresses = Address::where("userId", $userId)->get();

        $addressIds = [];

        foreach($addresses as $address){
            $addressIds[] = $address->id;
        }

        if(!in_array($id, $addressIds)){
            return response()->json([
                "error" => "You cant delete this address"
            ], 401);
        }

        $selectedAddress = Address::find($id);

        $selectedAddress->delete();

        return response()->json([
            "message" => "Address deleted",
            $selectedAddress
        ]);
    }
}
