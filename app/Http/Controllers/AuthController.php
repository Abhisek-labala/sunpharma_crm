<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\Rmuser;
use App\Models\User;
use App\Models\EducatorAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',  // This will be email / username / emp_id
            'password' => 'required|string',
        ]);

        // Match via email, user_name or emp_id
        $user = User::where('email', $request->email)
            ->orWhere('user_name', $request->email)
            ->orWhere('emp_id', $request->email)
            ->first();

        if ($user) {
            $hashedPassword = hash('sha256', $request->password);

            if ($hashedPassword === $user->password) {
                Auth::loginUsingId($user->id);
                $request->session()->regenerate();
                session()->put('emp_id', $user->emp_id);
                LoginLog::create([
                    'email' => $user->email,
                    'username' => $user->user_name,
                    'emp_id' => $user->emp_id,
                    'role' => $user->role,
                    'time' => now(),
                    'ip' => $request->ip(),
                ]);

                // Auto Attendance for Educator
                if ($user->role === 'counsellor') {
                    $today = Carbon::today();
                    $attendance = EducatorAttendance::where('educator_id', $user->id)
                        ->whereDate('date', $today)
                        ->first();

                    if (!$attendance) {
                        EducatorAttendance::create([
                            'educator_id' => $user->id,
                            'date' => $today,
                            'in_time' => Carbon::now()->toTimeString(),
                            'ip_address' => $request->ip(),
                        ]);
                    }
                }

                $redirectRoute = match ($user->role) {
                    'counsellor' => route('educator.attendance.index'),
                    'pm' => route('dashboard.pm'),
                    'mis' => route('dashboard.mis'),
                    'digitaleducator' => route('dashboard.digitaleducator'),
                    'yogaeducator' => route('dashboard.yogaeducator'),
                    default => route('login'),
                };

                // If AJAX, return JSON response
                if ($request->ajax()) {
                    return response()->json(['redirect_to' => $redirectRoute]);
                }

                return redirect($redirectRoute);
            }
        }

        // If login fails
        if ($request->ajax()) {
            return response()->json([
                'errors' => ['email' => ['Invalid email or password.']],
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }
    public function rmloginpost(Request $request)
    {
        $request->validate([
            'email' => 'required|string',  // This will be email / username / emp_id
            'password' => 'required|string',
        ]);

        // Match via email, user_name or emp_id
        $user = Rmuser::where('email', $request->email)
            ->orWhere('user_name', $request->email)
            ->orWhere('emp_id', $request->email)
            ->first();

        if ($user) {
            $hashedPassword = hash('sha256', $request->password);

            if ($hashedPassword === $user->password) {
                Auth::loginUsingId($user->id);
                $request->session()->regenerate();
                session()->put('emp_id', $user->emp_id);
                session()->put('id', $user->id);
                LoginLog::create([
                    'email' => $user->email,
                    'username' => $user->user_name,
                    'emp_id' => $user->emp_id,
                    'role' => $user->role,
                    'time' => now(),
                    'ip' => $request->ip(),
                ]);
                $redirectRoute = match ($user->role) {
                    'rm' => route('dashboard.rm'),
                    default => route('rmlogin'),
                };

                // If AJAX, return JSON response
                if ($request->ajax()) {
                    return response()->json(['redirect_to' => $redirectRoute]);
                }

                return redirect($redirectRoute);
            }
        }

        // If login fails
        if ($request->ajax()) {
            return response()->json([
                'errors' => ['email' => ['Invalid email or password.']],
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }


    public function logout(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'counsellor') {
            $user_id = Auth::id();
            $today = Carbon::today();
            // Update out_time on logout (capture last logout)
            EducatorAttendance::where('educator_id', $user_id)
                ->whereDate('date', $today)
                ->update(['out_time' => Carbon::now()->toTimeString()]);
        }
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Logged out successfully.');
    }

    public function rmlogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/rmlogin')->with('status', 'Logged out successfully.');
    }

    public function rmLogin()
    {
        return view('login.rmlogin');
    }
}
