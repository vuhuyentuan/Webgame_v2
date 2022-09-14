<?php

namespace App\Http\Controllers;

use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $setting = $this->repository->getSetting();
        return view('admin.setting', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        try {
            $setting = $this->repository->update($request, $id);
            return response()->json([
                'success' => true,
                'data' => $setting,
                'msg' => __('Update successfully')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'msg' =>__('Error! An error occurred!')
            ]);
        }
    }

    public function updateGeneral(Request $request, $id)
    {
        try {
            $this->repository->updateGeneral($request, $id);
            return response()->json([
                'success' => true,
                'msg' => __('Update successfully')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'msg' =>__('Error! An error occurred!')
            ]);
        }
    }

    public function updateContact(Request $request, $id)
    {
        try {
            $this->repository->updateContact($request, $id);
            return response()->json([
                'success' => true,
                'msg' => __('Update successfully')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'msg' =>__('Error! An error occurred!')
            ]);
        }
    }

    public function emailConfig(Request $request, $id)
    {
        try {
            $this->repository->updateEmailConfig($request, $id);
            return response()->json([
                'success' => true,
                'msg' => __('Update successfully')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'msg' =>__('Error! An error occurred!')
            ]);
        }
    }
}
