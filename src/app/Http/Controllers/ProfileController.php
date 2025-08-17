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

        // Check if user has admin privileges and is accessing from admin panel
        if ((request()->is('admin/*') || $user->hasAdminPrivileges()) && $user->hasAdminPrivileges()) {
            return view('profile.edit', compact('user'));
        }

        // Regular user view for customers and users accessing non-admin profile
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
            'phone' => 'nullable|string|max:20',
            'shipping_address' => 'nullable|string|max:500',
            'postal_code' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
        ];

        // Super admin can change role and status
        if ($user->isSuperAdmin()) {
            $rules['role'] = 'required|in:admin,super_admin,customer';
            $rules['is_active'] = 'boolean';
        }

        $request->validate($rules);

        $oldValues = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'shipping_address' => $user->shipping_address,
            'postal_code' => $user->postal_code,
            'city' => $user->city,
            'province' => $user->province,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ];

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'shipping_address' => $request->shipping_address,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'province' => $request->province,
        ];

        // Super admin can update role and status
        if ($user->isSuperAdmin()) {
            $updateData['role'] = $request->role;
            $updateData['is_active'] = $request->boolean('is_active', true);
        }

        $user->update($updateData);

        $newValues = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'shipping_address' => $user->shipping_address,
            'postal_code' => $user->postal_code,
            'city' => $user->city,
            'province' => $user->province,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ];

        // Log the activity
        ActivityLog::createLog('update', $user, $oldValues, $newValues);

        // Determine redirect route based on user role and access context
        if ($user->hasAdminPrivileges() && request()->is('admin/*')) {
            $redirectRoute = 'admin.profile.edit';
        } else {
            $redirectRoute = 'profile.edit';
        }

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

        // Determine redirect route based on user role and access context
        if ($user->hasAdminPrivileges() && request()->is('admin/*')) {
            $redirectRoute = 'admin.profile.edit';
        } else {
            $redirectRoute = 'profile.edit';
        }

        return redirect()->route($redirectRoute)
                       ->with('success', 'رمز عبور با موفقیت تغییر یافت.');
    }
}
