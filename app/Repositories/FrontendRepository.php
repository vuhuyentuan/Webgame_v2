<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\Contact;
use App\Models\Package;
use App\Models\Product;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        $product = Product::with('package')->find($id);
        $product->views += 1;
        $product->save();
        return $product;
    }

    public function getPackage($id)
    {
        return Package::with('product')->find($id);
    }

    public function getSlides(){
        return Slide::orderBy('id', 'desc')->limit(5)->get();
    }

    public function getProductFeatured(){
        $query = Product::orderBy('id', 'desc')->where('featured', 1)->get();
        // if(count($query) > 0){
        //     $query->random(3);
        // }
        return $query;
    }

    public function getProductNews($type){
        return Product::orderBy('id', 'desc')->where('os_supported', $type)->limit(3)->get();
    }

    public function getProductMoreViews(){
        return Product::orderBy('views', 'desc')->limit(4)->get();
    }

    public function getContact()
    {
       return Contact::all();
    }

    function createBill($request, $id)
    {
        $package = Package::find($id);
        $user = User::find(Auth::user()->id);
        $total_point = $package->point * $request->quantity;
        if($user->point - $total_point < 0){
            return response()->json([
                'success' => false,
                'msg' => __('You have not enough points to buy it!')
            ]);
        }else{
            $bill = new Bill();
            $bill->product_id = $package->product_id;
            $bill->user_id = Auth::user()->id;
            $bill->description = $package->name;
            $bill->order_id = $total_point.''.Str::random(6);
            $bill->quantity = $request->quantity;
            $bill->point_total = $total_point;
            $bill->account = $request->username.' / '.$request->password_game.' / '.$request->sever.' / '.$request->code.' / '.$request->character.' / '.$request->login_with;
            $bill->save();

            $user->point = $user->point - $bill->point_total;
            $user->save();

            return response()->json([
                'success' => true,
                'msg' => __('Order successfully')
            ]);
        }
    }

    public function deleteBills()
    {
        Bill::whereRaw('DATE(created_at) < CURDATE() - INTERVAL 6 month')->delete();
    }
}
