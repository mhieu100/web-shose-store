<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle user login and redirect based on role
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đã bị khóa.',
                ]);
            }

            // Update last login timestamp
            $user->update(['last_login_at' => now()]);

            $request->session()->regenerate();

            // Redirect based on role
            if ($user->hasRole('admin')) {
                return redirect()->intended('/admin');
            }

            // CTV and registered users go to home
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}