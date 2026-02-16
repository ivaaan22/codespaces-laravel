<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //creamos funcion para registrar
    public function register(Request $request){

        //Parte a: Validar datos, una vez obtienes información del rquest, se valida

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:5|confirmed',
            'role' => 'required|string|max:100|in:admin,user',
        ]);

        //Parte b: si no pasa la validación...

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Y si si pasa la validacion:

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')), //Es cmo el hash
            'role' => $request->get('role'),
        ]);

        //parte c: devolvemos usuario creado
        return response()->json([
            'token'=> $token,
            'user'=> $user,
            'message' => 'Usuario registrado correctamente'
        ], 201);
    }
}
