<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rmuser;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function educatorchangepassword()
    {
        return view('educator.changepassword');
    }
    public function educatorchangePasswordpost(Request $request)
    {
     $request->validate([
        'currentPassword' => 'required|string',
        'newPassword'     => [
            'required',
            'string',
            'min:8',
            'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).+$/'
        ],
    ], [
        'newPassword.regex' => 'Password must contain at least one letter, one number, and one special character.',
    ]);

    $user = Auth::user();

    // Verify current password
    $hashedCurrent = hash('sha256', $request->currentPassword);
    if ($hashedCurrent !== $user->password) {
        if ($request->ajax()) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }
        return back()->withErrors(['currentPassword' => 'Current password is incorrect.']);
    }

    // Check if new password is same as old
    $hashedNew = hash('sha256', $request->newPassword);
    if ($hashedNew === $user->password) {
        if ($request->ajax()) {
            return response()->json(['message' => 'New password cannot be the same as the current password.'], 422);
        }
        return back()->withErrors(['newPassword' => 'New password cannot be the same as the current password.']);
    }

    // Update password
    $user->password = $hashedNew;
    $user->raw_password = $request->newPassword;
    $user->save();

    if ($request->ajax()) {
        return response()->json(['message' => 'Password changed successfully.']);
    }

    return redirect()->back()->with('success', 'Password changed successfully.');
}
   public function rmchangePasswordpost(Request $request)
{
    $request->validate([
        'currentPassword' => 'required|string',
        'newPassword'     => [
            'required',
            'string',
            'min:8',
            'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).+$/'
        ],
    ], [
        'newPassword.regex' => 'Password must contain at least one letter, one number, and one special character.',
    ]);

    $userId = session()->get('id'); // ID is stored in session
    $user = Rmuser::find($userId); // Fetch full user from DB

   $hashedCurrent = hash('sha256', $request->currentPassword);
    if ($hashedCurrent !== $user->password) {
        if ($request->ajax()) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }
        return back()->withErrors(['currentPassword' => 'Current password is incorrect.']);
    }

    // Check if new password is same as old
    $hashedNew = hash('sha256', $request->newPassword);
    if ($hashedNew === $user->password) {
        if ($request->ajax()) {
            return response()->json(['message' => 'New password cannot be the same as the current password.'], 422);
        }
        return back()->withErrors(['newPassword' => 'New password cannot be the same as the current password.']);
    }

    // Update password
    $user->password = $hashedNew;
    $user->raw_password = $request->newPassword;
    $user->save();

    if ($request->ajax()) {
        return response()->json(['message' => 'Password changed successfully.']);
    }
    return redirect()->back()->with('success', 'Password changed successfully.');
}

    public function digitaleducatorchangePassword()
    {
        return view('digitaleducator.changepassword');
    }

    public function rmchangepassword()
    {
        return view('rm.changepassword');
    }
    public function yogaeducatorchangePassword()
    {
        return view('yogaeducator.changepassword');
    }
}
