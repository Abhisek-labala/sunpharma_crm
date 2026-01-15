<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\Rmuser;
use App\Models\User;
use App\Models\Attendance;
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

                // Auto Attendance for Educator and Digital Educator
                if (in_array($user->role, ['counsellor', 'digitalcounsellor'])) {
                    $today = Carbon::today();
                    $attendance = Attendance::where('authenticatable_id', $user->id)
                        ->where('authenticatable_type', User::class)
                        ->whereDate('date', $today)
                        ->first();

                    if (!$attendance) {
                        Attendance::create([
                            'authenticatable_id' => $user->id,
                            'authenticatable_type' => User::class,
                            'role' => $user->role,
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
                    'digitalcounsellor' => route('digitaleducator.attendance.index'),
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

                // Auto Attendance for RM
                $today = Carbon::today();
                $attendance = Attendance::where('authenticatable_id', $user->id)
                    ->where('authenticatable_type', Rmuser::class)
                    ->whereDate('date', $today)
                    ->first();

                if (!$attendance) {
                    Attendance::create([
                        'authenticatable_id' => $user->id,
                        'authenticatable_type' => Rmuser::class,
                        'role' => 'rc',
                        'date' => $today,
                        'in_time' => Carbon::now()->toTimeString(),
                        'ip_address' => $request->ip(),
                    ]);
                }

                $redirectRoute = match ($user->role) {
                    'rc' => route('rm.attendance.index'),
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
        if (Auth::check() && in_array(Auth::user()->role, ['counsellor', 'digitalcounsellor'])) {
            $user_id = Auth::id();
            $today = Carbon::today();
            // Update out_time on logout (capture last logout)
            Attendance::where('authenticatable_id', $user_id)
                ->where('authenticatable_type', User::class)
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
        if (session()->has('id')) {
            $user_id = session('id');
            // Verify role if possible, or just assume RM since this is rmlogout
            // But verify existing attendance to be safe
            $today = Carbon::today();
            Attendance::where('authenticatable_id', $user_id)
                ->where('authenticatable_type', Rmuser::class)
                ->whereDate('date', $today)
                ->update(['out_time' => Carbon::now()->toTimeString()]);
        }
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/rclogin')->with('status', 'Logged out successfully.');
    }

    public function rmLogin()
    {
        return view('login.rmlogin');
    }
}
