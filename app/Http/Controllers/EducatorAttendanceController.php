<?php

namespace App\Http\Controllers;

use App\Models\EducatorAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EducatorAttendanceController extends Controller
{
    public function index()
    {
        $educatorId = Auth::id();
        $today = Carbon::today();
        
        // Get today's attendance to check if we have location
        $todayAttendance = EducatorAttendance::where('educator_id', $educatorId)
            ->whereDate('date', $today)
            ->first();

        // Get history
        $history = EducatorAttendance::where('educator_id', $educatorId)
            ->with('educator')
            ->orderBy('date', 'desc')
            ->get();

        return view('educator.attendance.index', compact('todayAttendance', 'history'));
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'nullable|string',
            'state' => 'nullable|string',
        ]);

        $educatorId = Auth::id();
        $today = Carbon::today();

        $updateData = [
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
            'state' => $request->state,
            'ip_address' => $request->client_ip ?? $request->ip(), // Prioritize client-side IP
        ];

        EducatorAttendance::where('educator_id', $educatorId)
            ->whereDate('date', $today)
            ->update($updateData);

        return response()->json(['success' => true, 'message' => 'Location updated successfully']);
    }
}
