<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageOptimizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Add performance headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Add compression headers for text content
        $contentType = $response->headers->get('Content-Type', '');
        if (str_contains($contentType, 'text/') || str_contains($contentType, 'application/json')) {
            $response->headers->set('Vary', 'Accept-Encoding');
        }
        
        // Add cache headers for static assets
        if (str_contains($request->path(), 'css') || str_contains($request->path(), 'js') || str_contains($request->path(), 'images')) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000'); // 1 year
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        }
        
        // Add ETag for better caching
        if (!$response->headers->has('ETag') && $response->getContent()) {
            $response->headers->set('ETag', '"' . md5($response->getContent()) . '"');
        }
        
        return $response;
    }
}
