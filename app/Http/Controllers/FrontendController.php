<?php

namespace App\Http\Controllers;

use App\Models\AutoBank;
use App\Repositories\FrontendRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(FrontendRepository $repository)
    {
        $this->repository = $repository;
    }

    public function changeLanguage($language)
    {
        Session::put('language', $language);
        return redirect()->back();
    }

    public function index(Request $request)
    {
        $system = $request->input('system', 'Android');
        if($request->ajax()){
            $product_news = $this->repository->getProductNews($system);
            $html =  view('layout_index.partials.product_news_item', compact('product_news'))->render();
            return response()->json($html);
        }
        $slides = $this->repository->getSlides();
        $product_featured = $this->repository->getProductFeatured();
        $product_news = $this->repository->getProductNews($system);
        return view('layout_index.index', compact('slides', 'product_featured', 'product_news'));
    }
}
