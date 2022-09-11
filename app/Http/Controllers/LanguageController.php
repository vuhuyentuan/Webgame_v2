<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Repositories\LanguageRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(LanguageRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        if (request()->ajax()) {
            $lang = $this->repository->getLanguage();
            return DataTables::of($lang)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('languages.edit', $row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_lang"><i class="fa fa-edit"></i></button>&nbsp;
                                            <button type="button" data-href="'.route('languages.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_lang" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('status', function($row){
                    if ($row->status == 'show') {
                        $html = '<span class="badge badge-success">'.__('Show').'</span>';
                    }else{
                        $html = '<span class="badge badge-secondary">'.__('Hide').'</span>';
                    }
                    return $html;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);;
        }

        return view('admin.languages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
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
        $lang = $this->repository->getLanguageId($id);
        return view('admin.languages.edit', compact('lang'));
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
        $request->validate([
                'locale' => 'unique:languages,locale,'.$id,
            ],
            [
                'locale.unique' => __('Language already exists')
            ]
        );
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
        $lang = $this->repository->getLanguageId($id);
        $lang->delete();
        return response()->json([
                'success' => true,
                'msg' => __('Delete successfully')
        ]);
    }
}
