<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $this->bearerToken();
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $decoded_array = (array)$decoded;
            $sub = $decoded_array['sub'];
            $expired = $decoded_array['exp'];

            if (strtotime(date('Y-m-d H:i:s')) > $expired) {
                $token = null;
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
        if (!$token) {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
        return $next($request);
    }

    public function bearerToken()
    {
        $headers = request()->headers->all();
        $header = $headers['authorization'][0];
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        } else {
            return $this->request->header('token', '');
        }
    }
}
