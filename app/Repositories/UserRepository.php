<?php

namespace App\Repositories;

use App\Models\Bank;
use App\Models\Category;
use App\Models\HistoryTransaction;
use App\Models\ServiceBill;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        return User::where('id', Auth::user()->id)->select('amount')->get();
    }

    public function create($request)
    {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'recovery_password' => $request->password,
            'user_token' =>  Str::random(30),
            'code_name' => 'naptien'.rand(100000,999999),
            'amount' => str_replace(',','', $request->amount)
        ]);
    }

    public function update($request)
    {
        $user = User::find($request->id);
        $user_data = $request->only(['name', 'email', 'phone', 'amount']);
        $user_data['amount'] = str_replace(',','', $request->amount);
        $user_data['password'] = $request->password ? $request->password : $user->password;
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

    public function getRechargeHistory()
    {
        $recharge_histories = UserTransaction::where('user_id', Auth::user()->id)
                        ->join('users as u', 'user_transactions.user_id', '=', 'u.id')
                        ->select([
                            'user_transactions.*',
                            'u.name as user_name',
                            'u.avatar as avatar',
                            'u.email'
                        ])
                        ->orderBy('id', 'desc');
        return $recharge_histories;
    }

    public function serviceBills()
    {
        return ServiceBill::join('users', 'service_bills.user_id', '=', 'users.id')
                            ->where('users.id', Auth::user()->id)
                            ->join('services as sv', 'service_bills.service_id', '=', 'sv.id')
                            ->join('categories as cate', 'cate.id', '=', 'sv.category_id')
                            ->select([
                                'service_bills.*',
                                'sv.name as service_name',
                                'sv.country as country',
                                'sv.country_name as country_name',
                                'cate.image as image',
                                'cate.name as cate_name'
                            ])
                            ->orderBy('id', 'desc');

    }

    public function getTransactionHistory()
    {
        $history_transactions = HistoryTransaction::where('user_id', Auth::user()->id)
                        ->join('users as u', 'history_transactions.user_id', '=', 'u.id')
                        ->select([
                            'history_transactions.*'
                        ])
                        ->orderBy('id', 'desc');
        return $history_transactions;
    }

    public function userDashboard()
    {
        return Category::select('id', 'name', 'image', 'status')
                        ->with('service','service.service_pack')
                        ->get();
    }

    public function getSetting()
    {
        return Setting::find(1);
    }

    public function export($id)
    {
        $accounts = ServiceBill::where('id', $id)
                                ->select([
                                    'account'
                                ])->first();
        $data = '';
        $c = 0;
        $date = date('Y-m-d His');
        foreach (json_decode($accounts->account) as $value) {
            $data .= $value. PHP_EOL;
            $c++;
        }
        $data = "Tổng dữ liệu: " . $c . " - Ngày xuất: " . date('Y-m-d H:i:s') . "\n" . $data;
        Storage::put($date.'.txt', $data);
        return response()->download(storage_path('app/'.$date.'.txt'));
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
