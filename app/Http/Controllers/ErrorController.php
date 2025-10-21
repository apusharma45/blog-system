<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ErrorController extends Controller
{
    /**
     * Show the error page
     */
    public function show(Request $request, $status = 500)
    {
        $status = (int) $status;
        
        // Log the error for debugging
        Log::error('Error page accessed', [
            'status' => $status,
            'url' => $request->url(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
        ]);

        $messages = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Page Not Found',
            405 => 'Method Not Allowed',
            419 => 'Page Expired',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
            503 => 'Service Unavailable',
        ];

        $title = $messages[$status] ?? 'Error';
        $message = $this->getErrorMessage($status);

        return response()->view('errors.custom', [
            'status' => $status,
            'title' => $title,
            'message' => $message,
        ], $status);
    }

    /**
     * Get appropriate error message for status code
     */
    private function getErrorMessage($status)
    {
        return match($status) {
            400 => 'The request was invalid or cannot be served.',
            401 => 'You need to be authenticated to access this resource.',
            403 => 'You do not have permission to access this resource.',
            404 => 'The page you are looking for could not be found.',
            405 => 'The request method is not allowed for this resource.',
            419 => 'Your session has expired. Please refresh the page and try again.',
            429 => 'Too many requests. Please slow down and try again later.',
            500 => 'Something went wrong on our end. We are working to fix it.',
            503 => 'The service is temporarily unavailable. Please try again later.',
            default => 'An unexpected error occurred.',
        };
    }
}