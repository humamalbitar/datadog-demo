<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DataDog\DogStatsd;
use Symfony\Component\HttpFoundation\Response;

class DatadogMetrics
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        $response = $next($request);
        
        $duration = microtime(true) - $startTime;
        $statusCode = $response->getStatusCode();
        $route = $request->route()?->getName() ?? 'unknown';
        
        // Send request metrics
        app(DogStatsd::class)->histogram('http.request.duration', $duration, [
            'route' => $route,
            'method' => $request->method(),
            'status_code' => $statusCode
        ]);
        
        app(DogStatsd::class)->increment('http.requests', 1, [
            'route' => $route,
            'method' => $request->method(),
            'status_code' => $statusCode
        ]);
        
        // Track error rates
        if ($statusCode >= 400) {
            app(DogStatsd::class)->increment('http.errors', 1, [
                'route' => $route,
                'status_code' => $statusCode
            ]);
        }

        return $response;
    }
}
