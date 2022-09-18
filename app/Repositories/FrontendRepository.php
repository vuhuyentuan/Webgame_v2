<?php

namespace App\Repositories;

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
    public function getSlides(){
        return Slide::orderBy('id', 'desc')->limit(5)->get();
    }
    public function getProductFeatured(){
        return Product::orderBy('id', 'desc')->where('featured', 1)->limit(3)->get();
    }
    public function getProductNews($type){
        return Product::orderBy('id', 'desc')->where('os_supported', $type)->limit(3)->get();
    }
}
