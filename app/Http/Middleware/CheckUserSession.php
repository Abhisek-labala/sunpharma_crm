<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user session exists.
        if (!Session::has('emp_id')) {
            // Redirect to login page if no session is found.
            return redirect('/login')->with('error', 'Please login first.');
        }

        // Get the current User-Agent and Accept-Language headers.
        $currentUserAgent = $request->header('User-Agent');
        $currentAcceptLanguage = $request->header('Accept-Language');

        // Check if the session already has these values stored.
        if (!Session::has('last_user_agent') || !Session::has('last_accept_language')) {
            // Store the current User-Agent and Accept-Language in the session.
            Session::put('last_user_agent', $currentUserAgent);
            Session::put('last_accept_language', $currentAcceptLanguage);
        } else {
            // Retrieve the stored data from the session.
            $lastUserAgent = Session::get('last_user_agent');
            $lastAcceptLanguage = Session::get('last_accept_language');

            // Compare the current request data with the stored session data.
            // A mismatch in User-Agent or Accept-Language indicates a potential session hijack.
            if ($lastUserAgent !== $currentUserAgent || $lastAcceptLanguage !== $currentAcceptLanguage) {
                // A mismatch indicates a potential session hijack attempt.
                // Log the incident for security analysis.
                Log::warning('Session hijack attempt detected for employee ID: ' . Session::get('emp_id'));

                // Invalidate the current session to prevent further use.
                Session::flush();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Redirect to the login page with an error message.
                return redirect('/')->with('error', 'Your session is invalid due to a security violation. Please log in again.');
            }
        }

        // Continue to the next middleware or controller.
        return $next($request);
    }
}
