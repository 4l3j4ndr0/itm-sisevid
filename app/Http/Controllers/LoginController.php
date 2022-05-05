<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $jwt = $this->getJwt($user);
            return response()->json([
                'status' => true,
                'token' => $jwt,
                'message' => "Autenticación exitosa."
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logOut()
    {
        Auth::logout();
        return response()->json([
            'status' => true,
            'message' => "Sesión cerrada correctamente."
        ], 200);
    }

    private function getJwt($user)
    {
        $payload = [
            'iss' => "itm-sisevid", // Issuer of the token
            'sub' => ["userId" => $user->id, "userName" => $user->nombre . " " . $user->apellidos], // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60, // Expiration time
            'rand' => md5(microtime()) . rand(0, 10000)
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}
