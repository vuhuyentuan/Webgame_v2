<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\RechargeHistory;
use App\Models\User;
use App\Repositories\AdminRepository;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(AdminRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(Request $request)
    {
        $date =  date('Y-m-d');
        if (request()->ajax()) {
            if(request()->dates)
            {
                $first_day = date('Y-m-d', strtotime(str_replace('/', '-', explode(' - ', request()->dates)[0])));
                $last_day = date('Y-m-d', strtotime(str_replace('/', '-', explode(' - ', request()->dates)[1])));
            }
            $period = CarbonPeriod::create($first_day, $last_day);
            foreach($period as $date)
            {
                $dates[] = $date->format('Y-m-d');
            }

            $user = User::where('role',0)->whereDate('created_at', '>=', $first_day)->whereDate('created_at', '<=', $last_day)->count();
            $service_bill_done = Bill::where('status','completed')->whereDate('created_at', '>=', $first_day)->whereDate('created_at', '<=', $last_day)->count();
            $service_bill_pending = Bill::where('status','pending')->whereDate('created_at', '>=', $first_day)->whereDate('created_at', '<=', $last_day)->count();
            $revenueMonthDone = RechargeHistory::whereRaw('month(recharge_histories.created_at) BETWEEN "'.date('m', strtotime($first_day)).'" AND "'.date('m', strtotime($last_day)).'"')
                ->select(DB::raw('sum(recharge_histories.point_purchase) as totalMoney'), DB::raw('DATE(recharge_histories.created_at) day'))
                ->where('recharge_histories.status', 'completed')
                ->groupBy('day')
                ->get()
                ->toArray();
            $revenueMonthPending = RechargeHistory::whereRaw('month(recharge_histories.created_at) BETWEEN "'.date('m', strtotime($first_day)).'" AND "'.date('m', strtotime($last_day)).'"')
                ->select(DB::raw('sum(recharge_histories.point_purchase) as totalMoney'), DB::raw('DATE(recharge_histories.created_at) day'))
                ->where('recharge_histories.status', 'completed')
                ->groupBy('day')
                ->get()
                ->toArray();

            $arrRevenueMonthDone = [];
            $arrRevenueMonthPending = [];
            foreach ($dates as $day) {
                $total = 0;
                foreach ($revenueMonthDone as $key => $revenue) {

                    if ($revenue['day'] == $day) {
                        $total = $revenue['totalMoney'];
                        break;
                    }
                }


                $arrRevenueMonthDone[] = (int) $total;
                $total = 0;
                foreach ($revenueMonthPending as $key => $revenue) {
                    if ($revenue['day'] == $day) {
                        $total = $revenue['totalMoney'];
                        break;
                    }
                }
                $arrRevenueMonthPending[] = (int) $total;
            }
            $totalRevenueFromToDate = array_sum($arrRevenueMonthDone);
            $viewData = [
                'service_bill_pending'             => $service_bill_pending,
                'service_bill_done'             => $service_bill_done,
                'user'                      => $user,
                'first_day'                 => $first_day,
                'last_day'                  => $last_day,
                'dates'                     => $dates,
                'arrRevenueMonthDone'       => $arrRevenueMonthDone,
                'arrRevenueMonthPending'    => json_encode($arrRevenueMonthPending),
                'totalRevenueFromToDate'    => $totalRevenueFromToDate
            ];

            return response()->json([
                'success' => 200,
                'table' => view('admin.partials.statistical_table', compact('arrRevenueMonthDone', 'dates'))->render(),
                'data' => $viewData
            ]);
        }
        $first_day = date('Y-m-01', strtotime($date));
        $last_day = date('Y-m-t', strtotime($date));
        return view('admin.index', compact('first_day', 'last_day'));
    }

    public function info()
    {
        return view('admin.information');
    }

    public function viewStatus($id)
    {
        $status = $this->repository->getServiceBill($id);
        return view('admin.orders.edit', compact('status'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $this->repository->updateStatus($request, $id);
            return response()->json([
                'success' => true,
                'msg' => 'Cập nhật trạng thái thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi!'
            ]);
        }
    }
}
