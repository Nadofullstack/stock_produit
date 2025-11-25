<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

          if (!auth()->check()) {
            return redirect()->route('login');
          }

          // If user is authenticated but not admin, redirect to their dashboard instead of '/'
          $user = auth()->user();
          if (!$user->isAdmin()) {
              if ($user->isManager()) {
                  return redirect()->route('manager.dashboard');
              }
              if ($user->isCaisse()) {
                  return redirect()->route('caisse.dashboard');
              }
              return redirect()->route('login');
          }
        return $next($request);

    }
}
