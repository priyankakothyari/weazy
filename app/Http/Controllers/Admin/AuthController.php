<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.auth.login');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('admin.login')->withErrors('Please enter the currect email or password.');
        }
    }

    public function passwordReset(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.auth.forgot-password');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email|exists:admins'
            ]);

            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            //   Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            //     $message->to($request->email);
            //     $message->subject('Reset Password');
            // });

            return back()->with('message', 'We have e-mailed your password reset link!');
        }
    }

    public function showForgetPasswordForm($token)
    {
        $check = DB::table('password_resets')->where([
            'email' => Auth::user()->email,
            'token' => $token
        ])->first();
        if($check){
            return view('admin.auth.forgot-password-reset', ['token' => $token]);
        }
    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }


        Admin::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('admin.login')->with('message', 'Your password has been changed!');
    }

    public function signOut()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
