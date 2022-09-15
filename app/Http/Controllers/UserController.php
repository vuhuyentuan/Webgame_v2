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
                    $html = '';
                    if ($row->banned_status == 'unbanned') {
                       $html .= '<button type="button" data-href="'.route('users.banned', $row->id).'" class="btn btn-outline-warning btn-not-radius modal-btn ban_user"><i class="fa fa-lock"></i></button>&nbsp;&nbsp;&nbsp;';
                    }else{
                       $html .= '<button type="button" data-href="'.route('users.unbanned', $row->id).'" class="btn btn-outline-success btn-not-radius modal-btn ban_user"><i class="fa fa-unlock"></i></button>&nbsp;&nbsp;&nbsp;';
                    }

                    $html .= '<button type="button" data-href="'.route('users.edit', $row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_user"><i class="fa fa-edit"></i></button>&nbsp;
                            <button type="button" data-href="'.route('users.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_user" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('avatar', function($row){
                    $html = '<img src="https://ui-avatars.com/api/?name='.$row->name.'" width="38px" height="38px" class="rounded-circle avatar">';
                    return $html;
                })
                ->editColumn('point', '{{@number_format($point)}} $')
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

    public function banned($id)
    {
        $users =  $this->repository->getUser($id);
        $users->banned_status = 'banned';
        $users->save();

        return response()->json([
            'success' => true,
            'msg' => __('User lock successfully')
        ]);
    }

    public function unbanned($id)
    {
        $users =  $this->repository->getUser($id);
        $users->banned_status = 'unbanned';
        $users->save();

        return response()->json([
            'success' => true,
            'msg' => __('User unlock successfully')
        ]);
    }

    public function getAmount()
    {
        $user = $this->repository->getAmount();
        return response()->json([
            'success' => true,
            'amount' => $user
        ]);
    }

    public function userInfo()
    {
        return view('users.info');
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
