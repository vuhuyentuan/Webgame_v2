<?php

namespace App\Http\Controllers;

use App\Models\AutoBank;
use App\Repositories\FrontendRepository;
use Exception;
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
        $more_views = $this->repository->getProductMoreViews();
        return view('layout_index.index', compact('slides', 'product_featured', 'product_news', 'more_views'));
    }

    public function allGames(Request $request, $type)
    {
        $products = $this->repository->allProduct($request, $type);
        $more_views = $this->repository->getProductMoreViews();
        return view('layout_index.pages.games', compact('products', 'type', 'more_views'));
    }

    public function gameDetail($id)
    {
        $game_detail = $this->repository->gameDetail($id);
        $more_views = $this->repository->getProductMoreViews();
        return view('layout_index.pages.game_detail', compact('game_detail', 'more_views'));
    }

    public function checkout($id)
    {
        $package = $this->repository->getPackage($id);
        return view('layout_index.pages.checkout', compact('package'));
    }

    public function createBill(Request $request, $id)
    {
        return $this->repository->createBill($request, $id);
    }

    public function deleteBills()
    {
        return $this->repository->deleteBills();
    }
}
