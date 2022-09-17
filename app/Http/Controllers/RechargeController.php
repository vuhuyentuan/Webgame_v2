<?php

namespace App\Http\Controllers;

use App\Repositories\RechargeRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RechargeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(RechargeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function adminRechargeHistory(Request $request)
    {
        $date =  date('Y-m-d');
        $first_day = date('Y-m-01', strtotime($date));
        $last_day = date('Y-m-t', strtotime($date));
        if (request()->ajax()) {
            $recharge_histories = $this->repository->adminRechargeHistory();
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start = $request->start_date;
                $end =  $request->end_date;
                $recharge_histories->whereDate('recharge_histories.created_at', '>=', $start)
                                ->whereDate('recharge_histories.created_at', '<=', $end);
            }
            return DataTables::of($recharge_histories)
                ->addColumn('action' , function($row){
                    $disabled = '';
                    if ($row->status != 'unpaid') {
                        $disabled = 'disabled';
                    }
                    $html = '<button type="button" data-href="'.route('admin.check_recharge', $row->id).'" data-order="'.$row->order_id.'" class="btn btn-outline-info btn-not-radius modal-btn check_recharge" '.$disabled.'><i class="fa fa-check"></i></button>&nbsp;
                            <button type="button" data-href="'.route('admin.check_recharge', $row->id).'" data-order="'.$row->order_id.'" class="btn btn-outline-danger btn-not-radius delete-btn cancel_recharge" '.$disabled.'><i class="fa fa-times"></i></button>';
                    return $html;
                })
                ->addColumn('bills', function($row){
                    return '<a href="'.route('recharge.show', $row->id).'" class="btn btn-primary btn-not-radius modal-btn bill" target="_blank">'.__('Bill').'</a>';
                })
                ->editColumn('avatar', function($row){
                    $html = '<div class="d-flex px-2 py-1">
                            <div>
                                <img src="https://ui-avatars.com/api/?name='.$row->user->name.'" width="38px" height="38px" class="rounded-circle avatar">
                            </div>&nbsp;&nbsp;
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">'.$row->user->name.'</h6>
                                <p class="text-xs text-secondary mb-0">'.$row->user->email.'</p>
                            </div>
                        </div>';
                    if($row->avatar){
                        $html = '<div class="d-flex px-2 py-1">
                                <div>
                                    <img src="'.asset($row->user->avatar).'" width="38px" height="38px" class="rounded-circle avatar">
                                </div>&nbsp;&nbsp;
                                    <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">'.$row->user->ame.'</h6>
                                    <p class="text-xs text-secondary mb-0">'.$row->user->email.'</p>
                                </div>
                            </div>';
                    }
                    return $html;
                })
                ->editColumn('status', function($row){
                    if ($row->status == 'paid') {
                        $html = '<span class="badge badge-success">'. __("Paid") .'</span>';
                    }elseif($row->status == 'canceled'){
                        $html = '<span class="badge badge-danger">'. __("Canceled") .'</span>';
                    }else{
                        $html = '<span class="badge badge-warning">'. __("Unpaid") .'</span>';
                    }
                    return $html;
                })
                ->editColumn('point_purchase', '+ {{@number_format($point_purchase)}}')
                ->editColumn('created_at', '{{date("d/m/Y H:i", strtotime($created_at))}}')
                ->rawColumns(['action', 'avatar', 'status', 'bills'])
                ->make(true);
        }
        return view('admin.histories.recharge_history', compact('first_day', 'last_day'));
    }

    public function checkRechaege(Request $request, $id)
    {
        try {
            $this->repository->checkRechaege($request, $id);
            return response()->json([
                'success' => true,
                'msg' => __('Update successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => __('Error! An error occurred!')
            ]);
        }
    }

    public function recharge()
    {
        return view('users.recharge');
    }

    public function rechargePoint(Request $request, $id)
    {
        try {
            $recharge_history = $this->repository->getRecharge($id);
            if($recharge_history > 2){
                return response()->json([
                    'success' => false,
                    'msg' => __('Please pay the bill first')
                ]);
            }
            else{
                $this->repository->rechargePoint($request, $id);
                return response()->json([
                    'success' => true,
                    'msg' => __('Recharge successfully')
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => __('Error! An error occurred!')
            ]);
        }
    }

    public function rechargeHistory()
    {
        $recharge_history = $this->repository->rechargeHistory();
        return view('users.histories.recharge_history', compact('recharge_history'));
    }

    public function rechargeShow($id)
    {
        $admin = $this->repository->getAdminInfo();
        $recharge_show = $this->repository->rechargeShow($id);
        $banks = $this->repository->getBank();
        return view('users.histories.recharge_show', compact('id', 'recharge_show', 'admin', 'banks'));
    }
}
