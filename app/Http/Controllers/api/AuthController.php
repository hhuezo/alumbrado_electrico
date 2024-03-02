<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticación exitosa, devuelve un token de acceso
            $token = auth()->user()->createToken('API Token')->accessToken;
            return response()->json(['mensaje' => 'Credenciales correctas','user' => auth()->user()], 200);
        } else {
            // Credenciales inválidas, devuelve un mensaje de error
            return response()->json(['mensaje' => 'Credenciales incorrectas','user' => null], 401);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->token()->revoke();
        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }
}
