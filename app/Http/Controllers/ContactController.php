<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function store(Request $request)
    {
        // Log để track double submit
        \Log::info('Contact form submitted', [
            'time' => now(),
            'ip' => $request->ip(),
            'name' => $request->con_name,
            'email' => $request->con_email
        ]);
        
        $request->validate([
            'con_name' => 'required|string|max:255',
            'con_email' => 'required|email|max:255',
            'con_subject' => 'nullable|string|max:255',
            'con_message' => 'required|string|max:2000'
        ], [
            'con_name.required' => 'Vui lòng nhập họ và tên',
            'con_email.required' => 'Vui lòng nhập email',
            'con_email.email' => 'Email không đúng định dạng',
            'con_message.required' => 'Vui lòng nhập nội dung tin nhắn',
            'con_message.max' => 'Tin nhắn không được vượt quá 2000 ký tự'
        ]);

        // Chuẩn bị dữ liệu email
        $contactData = [
            'name' => $request->con_name,
            'email' => $request->con_email,
            'subject' => $request->con_subject ?? 'Liên hệ từ website',
            'message' => $request->con_message,
            'sent_at' => now()->format('d/m/Y H:i:s')
        ];

        try {
            // Gửi email cho admin - hardcode Gmail để bypass config issue
            Mail::to('levanhieu090901@gmail.com')
                ->send(new ContactMail($contactData));

            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau. Error: ' . $e->getMessage()
            ], 500);
        }
    }
}