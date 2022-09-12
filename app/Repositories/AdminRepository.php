<?php

namespace App\Repositories;

use App\Models\HistoryTransaction;
use App\Models\ServiceBill;
use App\Models\User;
use App\Models\UserTransaction;

class AdminRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function getServiceBill($id)
    {
        return ServiceBill::find($id);
    }

    public function updateStatus($request, $id)
    {
        $bill = ServiceBill::find($id);
        $bill->status = $request->status;
        $bill->save();
        //user
        $user = User::find($bill->user_id);
        $amount_old = $user->amount;
        if ($request->status == 'cancel') {
            $user->amount = $user->amount + $bill->amount;
            $user->save();
        }

        //history
        $history = new HistoryTransaction();
        $history->user_id = $bill->user_id;
        $history->price = $bill->amount;
        $history->content = $bill->service->name.' - '.$bill->service_pack->name;
        $history->volatility = number_format($amount_old) . ' -> ' . number_format($user->amount);
        $history->status = 'return';
        $history->save();
    }
}
