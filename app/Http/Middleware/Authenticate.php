<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {

            // If user is trying to access admin area -> go to admin login
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // Otherwise -> normal customer login
            return route('login');
        }

        return null;
    }
}
