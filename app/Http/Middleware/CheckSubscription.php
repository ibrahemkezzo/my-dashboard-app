<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $salon = Auth::user()->salon;
        if ($salon && !$salon->subscription?->isActive()) {
            return redirect()->route('subscriptions.renew', $salon->subscription->id ?? null)
                ->with('error', 'يرجى تجديد الاشتراك');
        }

        return $next($request);
    }
}
