<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
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

         // If authenticated but not manager, redirect to their appropriate dashboard
         $user = auth()->user();
         if (!$user->isManager()) {
             if ($user->isAdmin()) {
                 return redirect()->route('admin.dashboard');
             }
             if ($user->isCaisse()) {
                 return redirect()->route('caisse.dashboard');
             }
             return redirect()->route('login');
         }
        return $next($request);
    }
}
