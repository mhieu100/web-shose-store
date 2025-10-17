<?php

namespace App\Http\Controllers;

use App\Models\CollaboratorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CollaboratorController extends Controller
{
    public function showForm(): View
    {
        // Kiểm tra xem user đã đăng ký chưa
        $existingApplication = null;
        if (Auth::check()) {
            $existingApplication = CollaboratorApplication::where('user_id', Auth::id())->first();
        }

        return view('collaborator.register', compact('existingApplication'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đăng ký cộng tác viên.');
        }

        // Kiểm tra xem user đã đăng ký chưa
        $existingApplication = CollaboratorApplication::where('user_id', Auth::id())->first();
        if ($existingApplication) {
            return redirect()->back()->with('error', 'Bạn đã đăng ký làm cộng tác viên rồi. Vui lòng chờ duyệt.');
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'id_card_number' => 'required|string|max:20',
            'bank_account' => 'required|string|max:50',
            'bank_name' => 'required|string|max:100',
            'bank_account_name' => 'required|string|max:255',
            'address' => 'required|string',
            'reason' => 'nullable|string',
            'experience' => 'nullable|string',
        ]);

        CollaboratorApplication::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'id_card_number' => $request->id_card_number,
            'bank_account' => $request->bank_account,
            'bank_name' => $request->bank_name,
            'bank_account_name' => $request->bank_account_name,
            'address' => $request->address,
            'reason' => $request->reason,
            'experience' => $request->experience,
        ]);

        return redirect()->back()->with('success', 'Đăng ký cộng tác viên thành công! Chúng tôi sẽ xem xét và phản hồi trong thời gian sớm nhất.');
    }

    public function status(): View
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $application = CollaboratorApplication::where('user_id', Auth::id())->first();
        
        return view('collaborator.status', compact('application'));
    }
}
