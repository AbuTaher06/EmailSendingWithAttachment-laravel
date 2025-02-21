<?php

namespace App\Http\Controllers;
use App\Mail\WelcomeEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendWelcomeEMail(){
        $toEmail = "test@gmail.com";
        $messageContent = "This is a test email.I hope you are doing well.Thank you";
        $subject = "Welcome Email";
        Mail::to($toEmail)->send(new WelcomeEmail($messageContent, $subject));
        return "Email sent successfully";
    }

    public function contactForm(Request $request){
        return view('mail-template.contact-form');
}

public function sendContactEMail(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required',
        'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
    ]);

    try {
        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('uploads', 'public');
        }

        Mail::to("test@gmail.com")->send(new WelcomeEmail($request->all(), $filePath));

        return back()->with('success', 'Email sent successfully');
    } catch (\Throwable $th) {
        return back()->with('fail', 'Something went wrong: ' . $th->getMessage());
    }
}



}
