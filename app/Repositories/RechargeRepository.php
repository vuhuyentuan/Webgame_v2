<?php

namespace App\Repositories;

use App\Models\RechargeHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RechargeRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function adminRechargeHistory()
    {
       return RechargeHistory::orderBy('created_at', 'desc')->with('user');
    }
    public function getRecharge($id)
    {
        return RechargeHistory::where('user_id', $id)->where('status', 'pending')->distinct()->count();
    }

    public function rechargePoint($request, $id)
    {
        $point_purchase = new RechargeHistory();
        $point_purchase->user_id = $id;
        $point_purchase->point_purchase = $request->point_purchase;
        $point_purchase->description = 'Purchase ' . $request->point_purchase . ' points';
        $point_purchase->order_id = $request->point_purchase . '' . Str::random(6);
        $point_purchase->save();
    }

    public function rechargeHistory()
    {
        return RechargeHistory::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(8);
    }

    public function checkRechaege($request, $id)
    {
        $recharge_history = RechargeHistory::find($id);
        $user = User::find($recharge_history->user_id);
        if ($request->status == 'paid') {
            $recharge_history->status = $request->status;
            $user->point = $user->point + $recharge_history->point_purchase;
        }else{
            $recharge_history->status = $request->status;
        }
        $recharge_history->save();
        $user->save();
    }
}
