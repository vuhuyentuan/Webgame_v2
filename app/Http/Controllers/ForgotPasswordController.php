<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function postResetPassword(Request $request)
    {
        $email = $request->email;
        $checkUser = User::where('email', $email)->first();

        if (!$checkUser) {
            return response()->json([
                'success' => false,
                'msg' => __('Email does not exist')
            ]);
        }
        $code = bcrypt(md5(time() . $email));
        $checkUser->code = $code;
        $checkUser->time_code = Carbon::now();
        $checkUser->save();

        $url = route('link_password_new', ['code' => $code, 'email' => $email]);

        $data = [
            'route' => $url,
            'email' => $email
        ];
        Mail::send('layout_index.reset_password.view_password', $data, function ($message) use ($email) {
            $message->to($email)->subject(__('Recover password'));
        });
        return response()->json([
            'success' => true,
            'msg' => __('Password reset link sent to your email, please check your email!')
        ]);
    }

    public function getPasswordNew(Request $request)
    {
        $code = $request->code;
        $email = $request->email;
        $checkUser = User::where([
            'code' => $code,
            'email' => $email
        ])->first();
        if (!$checkUser) {
            return view('layout_index.reset_password.reset_password', ['msg' => __('Error! Content changed or not found!')]);
        }
        return view('layout_index.reset_password.reset_password');
    }

    public function postPasswordNew(Request $request)
    {
        $this->validate(
            $request,
            [
                'password' => 'required|min:6|max:20',
                'repassword' => 'required|same:password',
            ],
            [
                'password.required' => __('Please enter a new password'),
                'repassword.required' => __('Please confirm password'),
                'password.min' => __('Password at least 6 characters'),
                'password.max' => __('Password must not exceed 20 characters'),
                'repassword.same' => __('Confirmation password is incorrect')
            ]
        );

        $code = $request->code;
        $email = $request->email;
        $checkUser = User::where([
            'code' => $code,
            'email' => $email
        ])->first();
        if (!$checkUser) {
            return response()->json([
                'success' => false,
                'msg' => __('The password reset link is incorrect, please try again')
            ]);
        }

        $checkUser->password = Hash::make($request->password);
        $checkUser->save();
        return response()->json([
            'success' => true,
            'msg' => __('Password has been changed successfully')
        ]);
    }
}
