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
    //Funcion para registrarnos
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'role' => 'required|string|max:100|in:admin,user',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'role' => $request->get('role'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    //Funcion para loguearnos
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only([
            'email',
            'password'
        ]);

        //Ahora validamos credenciales, de usuario y contraseña, si son erróneas, devolvemos error
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }
            return response()->json([
                'message' => "User logged in successfully",
                'token' => $token,
            ], 200);
        } catch (JWTException $e){
            return respone()->json([
                'error' => 'Could not create token',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
