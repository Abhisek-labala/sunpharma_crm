<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Rmuser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RmAttendanceController extends Controller
{
    public function index()
    {
        // For RM, we rely on session 'id' if Auth::user() is not reliable or if custom login is used.
        $rmUserId = session('id') ?? Auth::id();
        
        $today = Carbon::today();
        
        // Get today's attendance to check if we have location
        $todayAttendance = Attendance::where('authenticatable_id', $rmUserId)
            ->where('authenticatable_type', Rmuser::class)
            ->whereDate('date', $today)
            ->first();

        // Get history
        $history = Attendance::where('authenticatable_id', $rmUserId)
            ->where('authenticatable_type', Rmuser::class)
            ->orderBy('date', 'desc')
            ->get();

        return view('rm.attendance.index', compact('todayAttendance', 'history'));
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'nullable|string',
            'state' => 'nullable|string',
        ]);

        $rmUserId = session('id') ?? Auth::id();
        $today = Carbon::today();

        $updateData = [
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
            'state' => $request->state,
            'ip_address' => $request->client_ip ?? $request->ip(),
        ];

        Attendance::where('authenticatable_id', $rmUserId)
            ->where('authenticatable_type', Rmuser::class)
            ->whereDate('date', $today)
            ->update($updateData);

        return response()->json(['success' => true, 'message' => 'Location updated successfully']);
    }

    public function markOut(Request $request)
    {
        $rmUserId = session('id') ?? Auth::id();
        $today = Carbon::today();

        Attendance::where('authenticatable_id', $rmUserId)
            ->where('authenticatable_type', Rmuser::class)
            ->whereDate('date', $today)
            ->update(['out_time' => Carbon::now()->toTimeString()]);

        return response()->json(['success' => true, 'message' => 'Attendance marked out successfully']);
    }
}
