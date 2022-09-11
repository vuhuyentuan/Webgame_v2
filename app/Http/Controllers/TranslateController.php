<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Translation;
use App\Repositories\TranslateRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TranslateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(TranslateRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        if (request()->ajax()) {
            $languages = $this->repository->getLanguage();
            $total_trans = $this->repository->getTranslate();
            return DataTables::of($languages)
                ->addColumn('action' , function($row){
                    $html = '<a data-href="'.route('translations.edit', $row->id).'" class="btn btn-sm btn-primary edit_translation"><i class="fa fa-edit"></i>'.__("Translate").'</a>
                            <a data-href="'.route('translations.build', $row->id).'" class="btn btn-sm btn-info build"><i class="fa fa-cubes"></i>'.__("Build").'</a>';
                    return $html;
                })
                ->addColumn('percent' , function($row) use($total_trans){
                    $count_trans = Translation::where('locale', $row->locale)->whereNotNull('string')->count();
                    return $total_trans ? number_format((float) $count_trans / $total_trans * 100,2) : 0 .'%';
                })
                ->addColumn('translated' , function($row) use($total_trans){
                    $count_trans = Translation::where('locale', $row->locale)->whereNotNull('string')->count();
                    return $count_trans.'/'.$total_trans;
                })
                ->editColumn('flag', function($row){
                    return '<span class="flag-icon flag-icon-'.$row->flag.'"></span> '.$row->name .' - '. ' ('.$row->locale.')';
                })
                ->editColumn('last_build_at', '{{$last_build_at ? date("d/m/Y H:i", strtotime($last_build_at)) : ""}}')
                ->rawColumns(['action', 'flag', 'percent', 'translated', 'last_build_at'])
                ->make(true);;
        }

        return view('admin.translation.index');
    }

    public function loadStrings()
    {
        $languages = Language::where('status', 'show')->count();
        if ($languages > 0) {
            $file = base_path('resources/lang/default.json');

            if(!is_file($file)){
                return response()->json([
                    'success' => false,
                    'msg' => __("Default language source does not exists")
                ]);
            }

            $content = file_get_contents($file);
            if(empty($content)){
                return response()->json([
                    'success' => false,
                    'msg' => __("Default language source empty")
                ]);
            }

            $json = \GuzzleHttp\json_decode($content,true);
            if(empty($json)){
                return response()->json([
                    'success' => false,
                    'msg' => __("Default language source do not have any strings")
                ]);
            }


            $all_string = Translation::select("string")->where("locale","raw")->get()->pluck('string')->toArray();
            $all_string = array_flip($all_string);

            foreach ($json as $key=>$value) {
                if(empty($all_string[ $key ])){
                    $lang =  new Translation([
                        'locale' => 'raw',
                        'string' => $key
                    ]);
                    $lang->save();
                }
            }
            return response()->json([
                'success' => true,
                'msg' => __("Loaded :count strings",['count'=>count($json)])
            ]);
        }
        return response()->json([
            'success' => false,
            'msg' => __("No language exists")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Request $request, $id)
    {
        $lang = Language::find($id);
        return view('admin.translation.edit', compact('lang'));
    }

    public function listTrans(Request $request, $id)
    {
        if (request()->ajax()) {
            $lang = Language::find($id);
            $query = Translation::select([
                'translations.*',
                't.string as translate'
            ]);

            $query->where('translations.locale', 'raw');

            $query->leftJoin('translations as t', function ($join) use ($lang) {

                $join->on('t.parent_id', '=', 'translations.id');
                $join->where('t.locale', '=', $lang->locale);
            });
            if ($request->type) {
                switch ($request->type) {

                    case "not_translated":
                        $query->whereRaw("(t.id is null or NULLIF(t.string,'') = '' )");
                        break;
                    case "translated":
                        $query->whereRaw("NULLIF(t.string,'') != '' ");
                        break;
                }
            }

            if( $request->search_by == "translated_text"){
                if ($request->s) {
                    $query->where('t.string', 'like', '%' . $request->s . '%');
                }
            }else{
                if ($request->s) {
                    $query->where('translations.string', 'like', '%' . $request->s . '%');
                }
            }

            $origins = $query->orderBy('translations.string', 'asc');

            return DataTables::of($origins)
                ->editColumn('translated', function($row){
                    return '<textarea name="translate['.$row->id.']" class="form-control">'.$row->translate.'</textarea>';
                })
                ->rawColumns(['action', 'translated'])
                ->make(true);
        }
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
        $this->repository->update($request, $id);
        return response()->json([
            'success' => true,
            'msg' => __("Translation saved")
        ]);
        // return redirect()->back()->with('success', __("Translation saved"));
    }

    public function build($id)
    {
        $lang = Language::find($id);
        if (empty($lang)) {
            abort(404);
        }
        $file = base_path('resources/lang/' . $lang->locale . '.json');
        if (!is_writable(base_path('resources/lang'))) {
            return response()->json([
                'success' => false,
                'msg' => __("Folder: resources/lang is not write-able. Please contact your hosting provider")
            ]);
        }
        if (file_exists($file) and !is_writable($file)) {
            return response()->json([
                'success' => false,
                'msg' => __("File: :file_name is not write-able. Please contact your hosting provider", ['file_name' => 'resources/lang/' . $lang->locale . '.json'])
            ]);
        }
        $query = Translation::select([
            'translations.*',
            't.string as origin'
        ])->where('translations.locale', $lang->locale)->whereRaw("NULLIF(translations.string,'') != '' ");
        $query->join('translations as t', function ($join) use ($lang) {

            $join->on('t.id', '=', 'translations.parent_id');
            $join->where('t.locale', 'raw');
        });
        $json = [];
        $rows = $query->get();
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $json[$row['origin']] = $row['string'];
            }
        }
        $myfile = fopen($file, "w");
        fwrite($myfile, json_encode($json));
        fclose($myfile);
        $lang->last_build_at = date('Y-m-d H:i:s');
        $lang->save();
        return response()->json([
            'success' => true,
            'msg' => __("Re-build language file for: :name success", ['name' => $lang->name])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
