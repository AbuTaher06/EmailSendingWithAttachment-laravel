<?php

use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('send-mail',[EmailController::class,'sendWelcomeEMail']);

Route::get('contact-form',[EmailController::class,'contactForm']);
Route::post('send-contact-mail',[EmailController::class,'sendContactEMail'])->name('send-contact-mail');
