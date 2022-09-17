<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlideRequest;
use App\Repositories\SlideRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(SlideRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        if (request()->ajax()) {
            $query = $this->repository->getAll();
           return DataTables::of($query)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('slides.edit',$row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_slide btn-hover"><i class="fa fa-edit"></i></button>&nbsp;
                            <button type="button" data-href="'.route('slides.destroy',$row->id).'" data-account="'.$row->account_name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_slide btn-hover" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('images', function($row){
                    if ($row->images) {
                        $html = '<img src="'.$row->images.'" width="100px" height="70px" class="img-thumbnail">';
                    }else{
                        $html = '<img src="'.asset('AdminLTE-3.1.0/dist/img/no_img.jpg').'" width="100px" height="100px" class="rounded-circle avatar">';
                    }
                    return $html;
                })
                ->rawColumns(['images', 'action'])
                ->make(true);
        }
        return view('admin.slides.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slides.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
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
        $slide = $this->repository->getSlide($id);
        return view('admin.slides.edit', compact('slide'));
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
        }  catch (Exception $e) {
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
            $this->repository->destroy($id);
            return response()->json([
                'success' => true,
                'msg' => __('Delete successfully')
            ]);
        }  catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => __('Error! An error occurred!')
            ]);
        }
    }
}
