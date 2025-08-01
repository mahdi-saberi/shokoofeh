<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ProfileController extends Controller
{
    /**
     * Show profile edit form
     */
    public function edit()
    {
        $user = Auth::user();

        // Check if user is accessing from admin panel
        if (request()->is('admin/*') || $user->role === 'admin' || $user->role === 'super_admin') {
            return view('profile.edit', compact('user'));
        }

        // Regular user view
        $siteSettings = \App\Models\SiteSetting::current();
        return view('profile.user-edit', compact('user', 'siteSettings'));
    }

    /**
     * Update profile information
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];

        // Super admin can change role and status
        if ($user->role === 'super_admin') {
            $rules['role'] = 'required|in:admin,super_admin';
            $rules['is_active'] = 'boolean';
        }

        $request->validate($rules);

        $oldValues = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ];

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Super admin can update role and status
        if ($user->role === 'super_admin') {
            $updateData['role'] = $request->role;
            $updateData['is_active'] = $request->boolean('is_active', true);
        }

        $user->update($updateData);

        $newValues = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ];

        // Log the activity
        ActivityLog::createLog('update', $user, $oldValues, $newValues);

        // Determine redirect route based on user role
        $redirectRoute = ($user->role === 'admin' || $user->role === 'super_admin')
            ? 'admin.profile.edit'
            : 'profile.edit';

        return redirect()->route($redirectRoute)
                       ->with('success', 'اطلاعات پروفایل با موفقیت بروزرسانی شد.');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'رمز عبور فعلی صحیح نمی‌باشد.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Log the activity
        ActivityLog::createLog('update', $user, ['password' => '***'], ['password' => '*** (تغییر یافت)']);

        // Determine redirect route based on user role
        $redirectRoute = ($user->role === 'admin' || $user->role === 'super_admin')
            ? 'admin.profile.edit'
            : 'profile.edit';

        return redirect()->route($redirectRoute)
                       ->with('success', 'رمز عبور با موفقیت تغییر یافت.');
    }
}
