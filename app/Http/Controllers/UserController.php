<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        if (request()->ajax()) {
            $users = $this->repository->getUserAll();
            return DataTables::of($users)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('users.edit', $row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_user"><i class="fa fa-edit"></i></button>&nbsp;
                                            <button type="button" data-href="'.route('users.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_user" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('avatar', function($row){
                    $html = '<img src="https://ui-avatars.com/api/?name='.$row->name.'" width="38px" height="38px" class="rounded-circle avatar">';
                    return $html;
                })
                ->editColumn('amount', '{{@number_format($amount)}} đ')
                ->rawColumns(['avatar', 'action'])
                ->make(true);;
        }

        return view('admin.manager_user.index');
    }

    public function create()
    {
        return view('admin.manager_user.create');
    }

    public function store(RegisterRequest $request)
    {
        try {
            $this->repository->create($request);
            return response()->json([
                'success' => true,
                'msg' => __('Add successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => __('Error! An error occurred!')
            ]);
        }
    }

    public function edit($id)
    {
        $user = $this->repository->getUser($id);
        return view('admin.manager_user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        try {
            $this->repository->update($request);
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

    public function destroy($id)
    {
        $user = $this->repository->delete($id);
        $user->delete();
        return response()->json([
                'success' => true,
                'msg' => __('Delete successfully')
        ]);
    }

    public function getRechargeHistory(Request $request)
    {
        $date =  date('Y-m-d');
        $first_day = date('Y-m-01', strtotime($date));
        $last_day = date('Y-m-t', strtotime($date));
        if (request()->ajax()) {
            $transaction_history = $this->repository->getRechargeHistory();
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start = $request->start_date;
                $end =  $request->end_date;
                $transaction_history->whereDate('user_transactions.created_at', '>=', $start)
                                ->whereDate('user_transactions.created_at', '<=', $end);
            }
            return DataTables::of($transaction_history)
                ->editColumn('status', function($row){
                    if ($row->status == 1) {
                        $html = '<span class="badge badge-success">'. __("paid") .'</span>';
                    }else{
                        $html = '<span class="badge badge-danger">'. __("unpaid") .'</span>';
                    }

                    return $html;
                })
                ->editColumn('amount', '+ {{@number_format($amount)}} đ')
                ->editColumn('created_at', '{{date("d/m/Y H:i", strtotime($created_at))}}')
                ->rawColumns(['status'])
                ->make(true);;
        }
        return view('users.partials.recharge_history', compact('first_day', 'last_day'));
    }

    public function userDashboard()
    {
        return view('users.index');
    }

    public function recharge()
    {
        $banks = $this->repository->getBanks();
        return view('users.recharge', compact('banks'));
    }

    public function getAmount()
    {
        $user = $this->repository->getAmount();
        return response()->json([
            'success' => true,
            'amount' => $user
        ]);
    }

    public function info()
    {
        return view('users.information');
    }

    public function updateInfo(Request $request)
    {
        try {
            $user = $this->repository->updateInfo($request);
            return response()->json([
                'success' => true,
                'data' => $user,
                'msg' => __('Update successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => __('Error! An error occurred!')
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $chang_password = $this->repository->changePassword($request);
            if($chang_password){
                return response()->json([
                    'success' => true,
                    'msg' => __('Change password successfully')
                ]);
            }
            return response()->json([
                'success' => false,
                'msg' => __('Old password is incorrect')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'msg' => __('Error! An error occurred!')
            ]);
        }

    }

    public function history(Request $request)
    {
        $date =  date('Y-m-d');
        $first_day = date('Y-m-01', strtotime($date));
        $last_day = date('Y-m-t', strtotime($date));
        if (request()->ajax()) {
            $service_bills = $this->repository->serviceBills();
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start = $request->start_date;
                $end =  $request->end_date;
                $service_bills->whereDate('service_bills.created_at', '>=', $start)
                            ->whereDate('service_bills.created_at', '<=', $end);
            }
            return DataTables::of($service_bills)
                ->editColumn('discount', function($row){
                    $html = '';
                    if ($row->country) {
                        $html = '<span class="badge badge-warning">

                                </span>';
                    }
                    return $html;
                })
                ->editColumn('account', function($row){
                    $html = '<button type="button" class="btn btn-outline-info btn-not-radius view btn-hover" data-href="'.route('order.view', $row->id).'"><i class="fa fa-eye"></i></button>';
                    return $html;
                })
                ->editColumn('status', function($row){
                    $html = '';
                    if ($row->status == "completed") {
                        $html = '<span class="badge badge-success">'. __("Completed") .'</span>';
                    }

                    return $html;
                })
                ->editColumn('amount', '<span class="btn mb-1 btn-sm btn-outline-danger">{{@number_format($amount)}} đ</span>')
                ->editColumn('quantity', '<span class="btn mb-1 btn-sm btn-outline-secondary">{{$quantity}}</span>')
                ->editColumn('created_at', '{{date("d/m/Y H:i", strtotime($created_at))}}')
                ->rawColumns(['amount', 'quantity', 'status', 'account', 'created_at'])
                ->make(true);;
        }
        return view('users.partials.purchase_history', compact('first_day', 'last_day'));
    }

    public function contacts()
    {
        $contact = $this->repository->getSetting();
        return view('users.contact', compact('contact'));
    }

    public function getTransactionHistory(Request $request)
    {
        $date =  date('Y-m-d');
        $first_day = date('Y-m-01', strtotime($date));
        $last_day = date('Y-m-t', strtotime($date));
        if (request()->ajax()) {
            $transaction_history = $this->repository->getTransactionHistory();
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start = $request->start_date;
                $end =  $request->end_date;
                $transaction_history->whereDate('history_transactions.created_at', '>=', $start)
                                ->whereDate('history_transactions.created_at', '<=', $end);
            }
            return DataTables::of($transaction_history)
                ->editColumn('status', function($row){
                    if ($row->status == 'payment') {
                        $html = '<span class="badge badge-success">'.__('Payment').'</span>';
                    }elseif ($row->status == 'return'){
                        $html = '<span class="badge badge-danger">'.__('Refund').'</span>';
                    }

                    return $html;
                })
                ->editColumn('price', function($row){
                    if ($row->status == 'payment') {
                        $html = '<span class="btn mb-1 btn-sm btn-outline-danger"> - '.number_format($row->price).'đ</span>';
                    }elseif ($row->status == 'return'){
                        $html = '<span class="btn mb-1 btn-sm btn-outline-success"> + '.number_format($row->price).'đ</span>';
                    }

                    return $html;
                })
                ->editColumn('created_at', '{{date("d/m/Y H:i", strtotime($created_at))}}')
                ->rawColumns(['status', 'created_at', 'price'])
                ->make(true);;
        }
        return view('users.partials.transaction_history', compact('first_day', 'last_day'));
    }

    public function export($id)
    {
        return $this->repository->export($id);
    }

    public function topRecharge()
    {
        $top_recharge = $this->repository->topRecharge();
        return view('users.top_recharge', compact('top_recharge'));
    }

    public function documentApi()
    {
        return view('document');
    }

    public static function utf8convert($str) {

        if(!$str) return false;

        $utf8 = array(

            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'd'=>'đ|Đ',

            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',

            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',

        );

        foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);

        return $str;

    }
}
