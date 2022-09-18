<?php

namespace App\Repositories;

use App\Models\Package;
use App\Models\Product;
use App\Models\Slide;
use App\Models\User;
use App\Models\UserTransaction;

class FrontendRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function allProduct($request, $type)
    {
        return Product::when(($type == 'Card'), function ($query) use ($type){
                            $query->where(function ($q) use ($type) {
                                $q->where('os_supported', $type)
                                    ->where('type','=','Card');
                            });
                        })
                        ->when(($type == 'Android'), function ($query) use ($type){
                            $query->where(function ($q) use ($type){
                                $q->where('os_supported', 'like', '%' . $type . '%')
                                    ->where('type','=','Game');
                            });
                        })
                        ->when(($type == 'IOS'), function ($query) use ($type){
                            $query->where(function ($q) use ($type){
                                $q->where('os_supported', 'like', '%' . $type . '%')
                                    ->where('type','=','Game');
                            });
                        })
                        ->when(($type == 'Wallet'), function ($query) use ($type){
                            $query->where(function ($q) use ($type){
                                $q->where('os_supported', 'like', '%' . $type . '%')
                                    ->where('type','=','Game');
                            });
                        })
                        ->when(($type == 'all'), function ($query){
                            $query->paginate(9);
                        })
                        ->where('name', 'like', '%' . $request->search . '%')
                        ->paginate(9);
    }

    public function gameDetail($id)
    {
        return Product::with('package')->find($id);
    }

    public function getPackage($id)
    {
        return Package::with('product')->find($id);
    }

    public function getSlides(){
        return Slide::orderBy('id', 'desc')->limit(5)->get();
    }

    public function getProductFeatured(){
        return Product::orderBy('id', 'desc')->where('featured', 1)->get()->random(3);
    }
    public function getProductNews($type){
        return Product::orderBy('id', 'desc')->where('os_supported', $type)->limit(3)->get();
    }
    public function getProductMoreViews(){
        return Product::orderBy('views', 'desc')->limit(4)->get();
    }
}
