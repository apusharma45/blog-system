<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $ttl = 60): Response
    {
        // Don't cache for authenticated users - they need to see real-time content
        if ($request->user()) {
            $response = $next($request);
            // Set no-cache headers for authenticated users
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            return $response;
        }
        
        // Only cache GET requests for guests
        if ($request->isMethod('GET')) {
            $key = 'page_guest_' . md5($request->fullUrl());
            
            // Check if we have a cached response
            if (Cache::has($key)) {
                $cachedData = Cache::get($key);
                $response = response($cachedData['content'], $cachedData['status'], $cachedData['headers']);
                
                // Add cache headers
                $response->headers->set('Cache-Control', 'public, max-age=' . $ttl);
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + $ttl) . ' GMT');
                
                return $response;
            }
            
            // Generate response
            $response = $next($request);
            
            // Cache the response data (not the response object)
            $cacheData = [
                'content' => $response->getContent(),
                'status' => $response->getStatusCode(),
                'headers' => $response->headers->all()
            ];
            
            Cache::put($key, $cacheData, $ttl);
            
            // Add cache headers
            $response->headers->set('Cache-Control', 'public, max-age=' . $ttl);
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + $ttl) . ' GMT');
            
            return $response;
        }
        
        return $next($request);
    }
}
