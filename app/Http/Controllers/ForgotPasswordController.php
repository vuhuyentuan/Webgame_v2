<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            return view('layout_index.reset_password.reset_password', ['msg' => 'Lỗi! Nội dung đã thay đổi hoặc không tìm thấy!']);
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
                'password.required' => 'Vui lòng nhập mật khẩu mới',
                'repassword.required' => 'Vui lòng xác nhận mật khẩu',
                'password.min' => 'Mật khẩu ít nhất 6 kí tự',
                'password.max' => 'Mật khẩu không quá 20 kí tự',
                'repassword.same' => 'Mật khẩu xác nhận không đúng'
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
                'msg' => __('Đường dẫn lấy lại mật khẩu không đúng, vui lòng thử lại')
            ]);
        }

        $checkUser->password = bcrypt($request->password);
        $checkUser->save();
        return response()->json([
            'success' => true,
            'msg' => __('Mật khẩu đã được đổi thành công')
        ]);
    }
}
