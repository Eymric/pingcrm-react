<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailNotifier;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showForgotPasswordForm()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function sendPasswordResetMail(Request $request)
    {
        $email = $request->email;
        $user =  User::where('email', $email)->exists();
        if(!$user)
            return back()->withErrors(['email' => 'Oops. Who are you?']);

        Mail::to($email)->send(new MailNotifier());

        return redirect()->route('login')->with('success', 'We did it !');
    }

}
