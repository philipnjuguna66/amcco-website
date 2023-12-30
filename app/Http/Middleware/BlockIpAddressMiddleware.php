<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class BlockIpAddressMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $blacklistIps = Cache::get('black-list-ips', []);

        if (count($blacklistIps) > 0 && in_array($request->getClientIp(), $blacklistIps)) {
            abort(433, 'You are restricted to access the site.');
        }

        return $next($request);
    }
}
