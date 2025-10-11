<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(6)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'name.min' => 'Họ và tên phải có ít nhất 2 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'phone.max' => 'Số điện thoại không được quá 20 ký tự.',
            'address.max' => 'Địa chỉ không được quá 500 ký tự.',
        ]);

        // Lấy role "registered" mặc định
        $registeredRole = Role::where('name', 'registered')->first();
        
        if (!$registeredRole) {
            return back()->withErrors([
                'email' => 'Hệ thống chưa được cấu hình đầy đủ. Vui lòng liên hệ quản trị viên.',
            ])->withInput();
        }

        // Tạo user mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => $registeredRole->id,
            'is_active' => true,
            'email_verified_at' => now(), // Tự động verify email
        ]);

        // Đăng nhập user sau khi đăng ký thành công
        Auth::login($user);

        // Redirect về trang chủ với thông báo thành công
        return redirect('/')->with('success', 'Đăng ký tài khoản thành công! Chào mừng bạn đến với hệ thống.');
    }
}
