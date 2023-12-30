<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LockoutResponse;
use Laravel\Fortify\LoginRateLimiter;

class EnsureLoginIsNotThrottled
{
    /**
     * The login rate limiter instance.
     *
     * @var \Laravel\Fortify\LoginRateLimiter
     */
    protected $limiter;

    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct(LoginRateLimiter $limiter)
    {
        $this->limiter = $limiter;

    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handle($request, $next)
    {

        if (! $this->limiter->tooManyAttempts($request)) {

            return $next($request);
        }

        return app(LockoutResponse::class);
    }
}
