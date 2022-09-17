<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function adminOrderHistory(Request $request)
    {
        $date =  date('Y-m-d');
        $first_day = date('Y-m-01', strtotime($date));
        $last_day = date('Y-m-t', strtotime($date));
        if (request()->ajax()) {
            $order_histories = $this->repository->adminOrderHistory();
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start = $request->start_date;
                $end =  $request->end_date;
                $order_histories->whereDate('bills.created_at', '>=', $start)
                                ->whereDate('bills.created_at', '<=', $end);
            }
            return DataTables::of($order_histories)
                ->addColumn('action' , function($row){
                    $disabled = '';
                    if ($row->status != 'pending') {
                        $disabled = 'disabled';
                    }
                    $html = '<button type="button" data-href="'.route('admin.check_order', $row->id).'" data-order="'.$row->order_id.'" class="btn btn-outline-info btn-not-radius modal-btn check_order" '.$disabled.'><i class="fa fa-check"></i></button>&nbsp;
                            <button type="button" data-href="'.route('admin.check_order', $row->id).'" data-order="'.$row->order_id.'" class="btn btn-outline-danger btn-not-radius delete-btn cancel_order" '.$disabled.'><i class="fa fa-times"></i></button>';
                    return $html;
                })
                ->addColumn('bills', function($row){
                    return '<a href="'.route('order.show', $row->id).'" class="btn btn-outline-warning btn-not-radius modal-btn bill" target="_blank"><i class="fa fa-eye"></i></a>';
                })
                ->addColumn('os_system', function($row){
                    return $row->product->os_supported;
                })
                ->addColumn('name_game', function($row){
                    return $row->product->name;
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
                    if ($row->status == 'completed') {
                        $html = '<span class="badge badge-success">'. __("Completed") .'</span>';
                    }elseif($row->status == 'canceled'){
                        $html = '<span class="badge badge-danger">'. __("Canceled") .'</span>';
                    }else{
                        $html = '<span class="badge badge-warning">'. __("pending") .'</span>';
                    }
                    return $html;
                })
                ->editColumn('point_total', '{{@number_format($point_total)}}')
                ->editColumn('created_at', '{{date("d/m/Y H:i", strtotime($created_at))}}')
                ->rawColumns(['action', 'avatar', 'status', 'bills', 'os_system', 'name_game'])
                ->make(true);
        }
        return view('admin.histories.order_history', compact('first_day', 'last_day'));
    }

    public function orderHistory()
    {
        $orderhistory = $this->repository->getOrder();
        return view('users.histories.order_history', compact('orderhistory'));
    }

    public function checkOrder(Request $request, $id)
    {
        try {
            $this->repository->checkOrder($request, $id);
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

    public function orderShow($id)
    {
        $admin = $this->repository->getAdminInfo();
        $order_show = $this->repository->orderShow($id);
        $banks = $this->repository->getBank();
        return view('users.histories.order_show', compact('id', 'order_show', 'admin', 'banks'));
    }
}
