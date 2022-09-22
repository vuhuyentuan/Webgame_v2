<?php

namespace App\Repositories;

use App\Models\Bank;
use App\Models\RechargeHistory;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function getUserAll()
    {
        return User::where('role', '!=', 1)->latest('id');
    }

    public function topRecharge()
    {
        return User::where('role', '!=', 1)
                    ->select(['name', 'username', 'total_amount'])
                    ->limit(10)
                    ->orderBy('total_amount', 'desc')
                    ->get();
    }

    public function getUser($id)
    {
        return User::find($id);
    }

    public function getAmount()
    {
        return User::where('id', Auth::user()->id)->select('point')->get();
    }

    public function create($request)
    {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'point' => str_replace(',','', $request->point)
        ]);
    }

    public function update($request)
    {
        $user = User::find($request->id);
        $user_data = $request->only(['name', 'email', 'phone', 'point']);
        $user_data['point'] = str_replace(',','', $request->point);
        $user_data['password'] = $request->password ? Hash::make($request->password) : $user->password;
        $user->update($user_data);
    }

    public function delete($id)
    {
        return User::find($id);
    }

    public function getBanks()
    {
        return Bank::all();
    }

    public function getSetting()
    {
        return Setting::find(1);
    }

    public function updateInfo($request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $date = Carbon::now()->format('d-m-Y');
        $avatar = $request->avatar;
        if (isset($avatar)) {
            if (isset($user->avatar)) {
                unlink(public_path($user->avatar));
            }
            $avatar_name = 'upload/users/avatar/' . $date . '/' . Str::random(10) . rand() . '.' . $avatar->getClientOriginalExtension();
            $destinationPath = public_path('upload/users/avatar/' . $date);
            $avatar->move($destinationPath, $avatar_name);
            $user->avatar = $avatar_name;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        return $user;
    }

    public function changePassword($request)
    {
        if (Hash::check($request->old_password, Auth::user()->password)) {
            $id = Auth::user()->id;
            $user = User::find($id);
            $user->password = Hash::make($request->password);
            $user->save();
            return true;
        }
        return false;
    }
}
