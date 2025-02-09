<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    public function __construct(private readonly AuthService $service)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $expires_in = Cache::get('expires_in');

        if (!$expires_in && isset(User::first()->expires_in)) {
            return $this->service->refreshZohoToken();
        }

        if (is_null($expires_in)) {
            return $this->service->authZoho();
        }
        if ($expires_in - now()->unix() <= 130) {
            return $this->service->refreshZohoToken();
        }
        return $next($request);
    }
}
