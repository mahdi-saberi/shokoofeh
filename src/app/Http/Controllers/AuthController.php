<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Log the login activity
            $user = Auth::user();
            if ($user instanceof \App\Models\User) {
                ActivityLog::createLog('login', $user);

                // Redirect based on user role
                if ($user->hasAdminPrivileges()) {
                    return redirect()->intended(route('admin.dashboard'))
                                   ->with('success', 'خوش آمدید! با موفقیت وارد شدید.');
                } else {
                    // Customer users go to their orders page
                    return redirect()->intended(route('customer.orders.index'))
                                   ->with('success', 'خوش آمدید! با موفقیت وارد شدید.');
                }
            }
        }

        return back()->withErrors([
            'email' => 'اطلاعات وارد شده صحیح نمی‌باشد.',
        ])->withInput($request->except('password'));
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')
                       ->with('success', 'حساب کاربری شما با موفقیت ایجاد شد.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log the logout activity before logging out
        if ($user instanceof \App\Models\User) {
            ActivityLog::createLog('logout', $user);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')
                       ->with('success', 'با موفقیت خارج شدید.');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // اینجا می‌توانید منطق ارسال ایمیل بازیابی رمز عبور را پیاده‌سازی کنید

        return back()->with('status', 'لینک بازیابی رمز عبور به ایمیل شما ارسال شد.');
    }
}
