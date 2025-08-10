<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OtpController extends Controller
{
    private $apiUrl = 'https://client.almasafa.ly/api/sms/Send';
    private $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1laWRlbnRpZmllciI6IkFsd2FzZWV0IiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9yb2xlIjoiQWRtaW4iLCJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9lbWFpbGFkZHJlc3MiOiJ0amp4ODM5MVhZIiwiZXhwIjoxNzg2Mzc2OTQ1LCJpc3MiOiJodHRwczovL2NsaWVudC5hbG1hc2FmYS5seSIsImF1ZCI6Imh0dHBzOi8vY2xpZW50LmFsbWFzYWZhLmx5In0.l7DRv75vD3yQKd1aI7TRXjYdM_gMjBhnMxvxMAjQTzo';

    public function index()
    {
        return view('sms.form');
    }

    public function send(Request $request)
    {
        $request->validate([
            'phoneNumber' => 'required|string',
            'message' => 'required|string',
        ]);
    
        $response = Http::withToken($this->token)
            ->post($this->apiUrl, [
                'phoneNumber' => $request->phoneNumber,
                'message' => $request->message,
                'senderID' => 'MyApp'
            ]);
    
        // نحول الاستجابة إلى مصفوفة
        $data = $response->json();
    
        // إذا الـ status = success
        if (isset($data['status']) && $data['status'] === 'success') {
            return back()->with('success', '✅ تم إرسال الرسالة بنجاح إلى ' . $data['phoneNo']);
        }
    
        // لو فيه خطأ من الـ API
        if (isset($data['status']) && $data['status'] === 'error') {
            return back()->with('error', '❌ فشل الإرسال: ' . ($data['message'] ?? 'خطأ غير معروف'));
        }
    
        // لو الـ API رجع استجابة غير متوقعة
        return back()->with('error', '⚠️ حدث خطأ غير متوقع أثناء الاتصال بخدمة الرسائل.');
    }
    
}
