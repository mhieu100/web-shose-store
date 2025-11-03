<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Hiển thị form quên mật khẩu
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Gửi email reset password
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.exists' => 'Email này không tồn tại trong hệ thống.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Kiểm tra tài khoản có bị khóa không
        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.'
            ]);
        }

        // Tạo token reset password
        $token = Str::random(64);

        // Xóa token cũ nếu có
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Lưu token mới
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        // Gửi email
        try {
            Mail::to($request->email)->send(new ResetPasswordMail($user, $token));

            return back()->with('status', 'Chúng tôi đã gửi link khôi phục mật khẩu đến email của bạn!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.'
            ]);
        }
    }
}
