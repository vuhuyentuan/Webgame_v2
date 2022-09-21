<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        if (request()->ajax()) {
            $products = $this->repository->getAll();
            return DataTables::of($products)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('products.edit', $row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_game"><i class="fa fa-edit"></i></button>&nbsp;
                            <button type="button" data-href="'.route('products.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_game" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('featured' , function($row){
                    $html = '';
                    if($row->featured == 0){
                        $html = '<div class="icheck-primary d-inline"><input type="checkbox" class="check_featured" data-href="'.route('products.featured', $row->id).'" id="featured'.$row->id.'"><label for="featured'.$row->id.'"></label></div>';
                    }else{
                        $html = '<div class="icheck-primary d-inline"><input type="checkbox" class="check_featured" data-href="'.route('products.featured', $row->id).'" id="featured'.$row->id.'" checked><label for="featured'.$row->id.'"></label></div>';
                    }
                    return $html;
                })
                ->editColumn('image', function($row){
                    if ($row->image) {
                        $html = '<img src="'.asset($row->image).'" width="100px" height="70px" class="avatar">';
                    }else{
                        $html = '<img src="'.asset('AdminLTE-3.1.0/dist/img/no_img.jpg').'" width="100px" height="70px" class="avatar">';
                    }
                    return $html;
                })
                ->rawColumns(['action', 'image', 'featured'])
                ->make(true);
        }

        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
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
        $product = $this->repository->getProductId($id);
        return view('admin.products.edit', compact('product'));
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
    public function destroy(Request $request, $id)
    {
        return $this->repository->delete($request, $id);
    }

    public function showPackage(Request $request)
    {
        return view('admin.products.show');
    }

    public function featured($id){
        try {
            $this->repository->featured($id);
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

    public function uploadImage(Request $request){
        try {
            $url = $this->repository->uploadImage($request);
            return response()->json($url);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => __('Error! An error occurred!')
            ]);
        }
    }

    public function removeImage(Request $request){
        try {
            $result = $this->repository->removeImage($request);
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => __('Error! An error occurred!')
            ]);
        }
    }
}
