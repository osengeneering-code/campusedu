<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class LogPageViewActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $routeName = $request->route() ? $request->route()->getName() : 'N/A';
            $url = $request->fullUrl();
            $ipAddress = $request->ip();

            // Log only if it's a GET request and not an AJAX request
            if ($request->isMethod('GET') && !$request->ajax()) {
                ActivityLog::create([
                    'user_id' => $user->id,
                    'action' => 'consultation',
                    'table_cible' => 'page', // Or a more specific identifier
                    'element_id' => null, // No specific element ID for page view
                    'description' => "Consultation de la page: {$routeName} ({$url})",
                    'ip_address' => $ipAddress,
                ]);
            }
        }

        return $next($request);
    }
}
