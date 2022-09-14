<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function postResetPassword(Request $request)
    {
        $setting = Setting::where('id',1)->select('email_configuration')->first();
        if(json_decode($setting->email_configuration)->email == '' || json_decode($setting->email_configuration)->password == ''){
            return response()->json([
                'success' => false,
                'msg' =>__('Error! An error occurred!')
            ]);
        }
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => 'smtp.googlemail.com',
            'mail.mailers.smtp.port' => 465,
            'mail.mailers.smtp.encryption' => 'ssl',
            'mail.mailers.smtp.username' => json_decode($setting->email_configuration)->email,
            'mail.mailers.smtp.password' => json_decode($setting->email_configuration)->password,
            'mail.from.address' => json_decode($setting->email_configuration)->email,
            'mail.from.name' => json_decode($setting->email_configuration)->app_name,
        ]);
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
            'url' => $url,
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

        $checkUser->password = bcrypt($request->password);
        $checkUser->save();
        return response()->json([
            'success' => true,
            'msg' => __('Password has been changed successfully')
        ]);
    }
}
