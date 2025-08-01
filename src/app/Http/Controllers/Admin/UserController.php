<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::admins()->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,super_admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        // Log the activity
        ActivityLog::createLog('create', $user);

        return redirect()->route('admin.users.index')
                       ->with('success', 'کاربر جدید با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $activities = $user->activityLogs()->latest()->take(20)->get();
        return view('admin.users.show', compact('user', 'activities'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,super_admin',
            'is_active' => 'boolean',
        ]);

        $oldValues = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ];

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->boolean('is_active', false),
        ]);

        $newValues = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ];

        // Log the activity
        ActivityLog::createLog('update', $user, $oldValues, $newValues);

        return redirect()->route('admin.users.index')
                       ->with('success', 'اطلاعات کاربر با موفقیت بروزرسانی شد.');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Log the activity
        ActivityLog::createLog('update', $user, ['password' => '***'], ['password' => '*** (توسط مدیر کل تغییر یافت)']);

        return redirect()->route('admin.users.edit', $user)
                       ->with('success', 'رمز عبور کاربر با موفقیت تغییر یافت.');
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        $oldStatus = $user->is_active;
        $user->update(['is_active' => !$user->is_active]);

        // Log the activity
        $action = $user->is_active ? 'فعال‌سازی' : 'غیرفعال‌سازی';
        ActivityLog::createLog('update', $user, ['is_active' => $oldStatus], ['is_active' => $user->is_active]);

        $message = $user->is_active ? 'کاربر با موفقیت فعال شد.' : 'کاربر با موفقیت غیرفعال شد.';

        return redirect()->route('admin.users.index')->with('success', $message);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'نمی‌توانید حساب کاربری خود را حذف کنید.');
        }

        // Log the activity before deletion
        ActivityLog::createLog('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index')
                       ->with('success', 'کاربر با موفقیت حذف شد.');
    }
}
