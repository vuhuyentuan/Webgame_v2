<?php

namespace App\Http\Controllers;

use App\Repositories\ContactRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        if (request()->ajax()) {
            $query = $this->repository->getAll();
           return DataTables::of($query)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('contacts.edit',$row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_contact btn-hover"><i class="fa fa-edit"></i></button>&nbsp;
                            <button type="button" data-href="'.route('contacts.destroy',$row->id).'" data-name="'.$row->name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_contact btn-hover" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('images', function($row){
                    if ($row->image) {
                        $html = '<img src="'.asset($row->image).'" width="50px" height="50px" class="rounded-circle avatar">';
                    }else{
                        $html = '<img src="'.asset('AdminLTE-3.1.0/dist/img/no_img.jpg').'" width="38px" height="38px" class="rounded-circle avatar">';
                    }
                    return $html;
                })
                ->editColumn('link', '<a href="{{$link}}" target="_blank">{{$link}}</a>')
                ->rawColumns(['images', 'action', 'link'])
                ->make(true);
        }
        return view('admin.contacts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contacts.create');
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
        $contact = $this->repository->getContact($id);
        return view('admin.contacts.edit', compact('contact'));
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
