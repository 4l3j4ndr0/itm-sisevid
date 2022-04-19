<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogMiddleware
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
        $uid = (string)Str::uuid();
        $date = date('Y-m-d H:i:s');
        $ip = $request->ip();
        $method = $request->method();
        $uri = $request->path();
        $headers = $request->headers->all();
        $body = $request->all();
        $queryString = $request->query->all();

        Log::info($uid, [
            'date' => $date,
            'ip' => $ip,
            'method' => $method,
            'uri' => $uri,
            'headers' => $headers,
            'body' => $body,
            'queryString' => $queryString,
        ]);

        $request->headers->set('log-uid', $uid);

        return $next($request);
    }
}
