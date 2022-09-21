<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\LoginRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    protected $repository;

    public function __construct(LoginRepository $repository)
    {
        $this->repository = $repository;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();
        // $user = $this->createUser($getInfo, $provider);
        $existingUser = User::where('provider_id', $getInfo->id)->orWhere('email', $getInfo->email)->first();

        if($existingUser){
            // log them in
            Auth::login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $getInfo->name;
            $newUser->email           = $getInfo->email;
            $newUser->avatar_orginal  = $getInfo->avatar;
            $newUser->password        = Hash::make($getInfo->id);
            $newUser->provider_id     = $getInfo->id;
            $newUser->save();

            Auth::login($newUser, true);
        }
        if(session('link') != null){
            return redirect(session('link'));
        }
        else{
            if(Auth::user()->banned_status == 'banned'){
                return redirect()->route('index')->with('message', '0');
            }else{
                Auth::logout();
                return redirect()->route('index')->with('message', '1');
            }

        }
    }

    public function viewLogin()
    {
        if(Auth::check()){
            if(Auth::user()->role == 1){
                return redirect()->route('dashboard');
            }else{
                return redirect()->route('login');
            }
        }else{
            return view('layout_index.login');
        }
    }

    public function postLogin(Request $request)
    {
        $remember = false;
        if(isset($request->remember)){
            $remember = true;
        }

        $credentaials_username = array('username' => $request->username, 'password' => $request->password, 'banned_status' => 'unbanned');
        $credentaials_email = array('email' => $request->username, 'password' => $request->password, 'banned_status' => 'unbanned');
        if ((Auth::attempt($credentaials_username, $remember) || Auth::attempt($credentaials_email, $remember)) ) {
            return response()->json([
                'success' => true,
                'data' => Auth::user()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => __('Incorrect account or password')
            ]);
        }
    }

    public function viewRegister()
    {
        return view('layout_index.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $sign_up = $this->repository->createUser($request);
        if ($sign_up == true) {
            $credentaials = array('username' => $request->username, 'password' => $request->password);
            if (Auth::attempt($credentaials)) {
                return response()->json([
                    'success' => true,
                    'data' => Auth::user()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => __('Registration failed')
                ]);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        $rememberMeCookie = Auth::getRecallerName();
        $cookie = Cookie::forget($rememberMeCookie);
        return Redirect::to('/')->withCookie($cookie);
    }
}
