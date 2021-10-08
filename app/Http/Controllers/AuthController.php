<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    //registro de usuario
    public function register(Request $req){
        return User::create([
            'name' => $req->input('name'),
            'email' => $req->input('email'),
            'password' => Hash::make($req->input('password'))

        ]);
    }

    //login usuario
    public function login(Request $req){
        //autenticamos si las credenciales introducidas son validas
        if(!Auth::attempt(['email' => $req->input('email'), 'password' => $req->input('password')])){
            return response([
                'message' => 'Non valid credentials'
            ],  401);
        }

        //si son validas, recuperamos al usuario
        $user = Auth::user();

        //generamos el token
        $token = $user->createToken('token')->plainTextToken;

        //creamos una cookie para guardar nuestro token
        $cookie = cookie('jwt', $token, 60*24);

        //retornamos el status + cookie
        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
        
    }

    //logout usuario
    public function logout(){
        $cookie = Cookie::forget('jwt');
        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

}


/*
Por motivos de seguridad, es conveniente almacenar el token como cookie en vez
de enviarlo directamente al frontend. 
Para autentificar el login en el backend, extraemos el token de la cookie y lo 
añadimos a nuestro header como un bearer token en la funcion handle del middleware
Authenticate
*/
