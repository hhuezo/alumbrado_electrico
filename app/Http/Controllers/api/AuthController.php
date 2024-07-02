<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        // Extraer el encabezado de autorización
        $authorizationHeader = $request->header('Authorization');

        // Verificar que el encabezado de autorización esté presente y sea correcto
        if ($authorizationHeader !== 'Basic dXNlcjpwYXNz') {
            return response()->json(['value' => 0, 'mensaje' => 'Encabezado de autorización incorrecto', 'user' => null], 401);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticación exitosa, devuelve un token de acceso
            $token = auth()->user()->createToken('API Token')->accessToken;
            return response()->json(['value' => 1, 'mensaje' => 'Credenciales correctas', 'user' => auth()->user()], 200);
        } else {
            // Credenciales inválidas, devuelve un mensaje de error
            return response()->json(['value' => 0, 'mensaje' => 'Credenciales incorrectas', 'user' => null], 401);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->token()->revoke();
        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }
}
