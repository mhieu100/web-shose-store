<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Hiển thị form reset password
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset password
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.exists' => 'Email này không tồn tại trong hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        // Kiểm tra token
        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token không hợp lệ hoặc đã hết hạn.']);
        }

        // Kiểm tra token có khớp không
        if (!Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'Token không hợp lệ.']);
        }

        // Kiểm tra token có hết hạn không (24 giờ)
        $tokenCreatedAt = \Carbon\Carbon::parse($passwordReset->created_at);
        if ($tokenCreatedAt->addHours(24)->isPast()) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token đã hết hạn. Vui lòng yêu cầu link mới.']);
        }

        // Cập nhật mật khẩu
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Xóa token đã sử dụng
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Mật khẩu của bạn đã được đặt lại thành công! Bạn có thể đăng nhập ngay bây giờ.');
    }
}
