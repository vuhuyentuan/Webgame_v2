<?php

namespace App\Repositories;

use App\Models\Bank;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderRepository
{
    public function getOrder()
    {
        return Bill::where('user_id', Auth::user()->id)
                    ->with(['product', 'product.package'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(8);
    }

    public function adminOrderHistory()
    {
       return Bill::orderBy('created_at', 'desc')->with(['user', 'product']);
    }

    public function checkOrder($request, $id)
    {
        $order_history = Bill::find($id);
        $user = User::find($order_history->user_id);
        if ($request->status == 'canceled') {
            $order_history->status = $request->status;
            $user->point = $user->point + $order_history->point_total;
        }else{
            $order_history->status = $request->status;
        }
        $order_history->save();
        $user->save();
    }

    public function getBank()
    {
        return Bank::select('image')->get();
    }

    public function getAdminInfo()
    {
        return User::where('role', '1')->first();
    }

    public function orderShow($id)
    {
        return Bill::with('user')->find($id);
    }
}
