<?php

namespace App\Http\Controllers;

use App\Repositories\PackageRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(PackageRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $packages = $this->repository->getPackage($request);
            return DataTables::of($packages)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('packages.edit', $row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_package"><i class="fa fa-edit"></i></button>&nbsp;
                            <button type="button" data-href="'.route('packages.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_package" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('image', function($row){
                    if ($row->image) {
                        $html = '<img src="'.asset($row->image).'" width="80px" height="50px" class="avatar">';
                    }else{
                        $html = '<img src="'.asset('AdminLTE-3.1.0/dist/img/no_img.jpg').'" width="80px" height="50px" class="avatar">';
                    }
                    return $html;
                })
                ->editColumn('point', '{{@number_format($point)}}')
                ->rawColumns(['action', 'image', 'point'])
                ->make(true);;
        }

        return view('admin.packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = $this->repository->getPackageId($id);
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->repository->update($request, $id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json([
                'success' => true,
                'msg' => __('Delete successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => __('Error! An error occurred!')
            ]);
        }
    }
}
