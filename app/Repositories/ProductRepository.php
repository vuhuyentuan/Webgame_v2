<?php

namespace App\Repositories;

use App\Models\Package;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function getAll()
    {
        return Product::orderBy('created_at', 'desc');
    }

    public function getProductId($id)
    {
        return Product::find($id);
    }

    public function create($request)
    {
        $product = new Product();
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
             $img_name = 'upload/product/' . $date . '/' . Str::random(8) . rand() . '.' . $img->getClientOriginalExtension();
             $destinationPath = public_path('upload/product/' . $date);
             $img->move($destinationPath, $img_name);

             $product->image = $img_name;
        }
        $img_detail = $request->image_detail;

        if (isset($img_detail)) {
             $img_name_detail = 'upload/product/' . $date . '/' . Str::random(8) . rand() . '.' . $img_detail->getClientOriginalExtension();
             $destinationPath = public_path('upload/product/' . $date);
             $img_detail->move($destinationPath, $img_name_detail);

             $product->image_detail = $img_name_detail;
        }

        $product->type = $request->type;
        $product->short_des = $request->short_des;
        $product->name = $request->name;
        $product->os_supported = $request->os_supported;
        $product->description = $request->description;
        $product->save();
    }

    public function update($request, $id)
    {
        $product = Product::find($id);
        preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $product->description, $old_urls);
        preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $request->description, $new_urls);
        $old_files = [];
        $new_files = [];
        if(!empty($old_urls[0])){
            foreach ($old_urls[0] as $url) {
                $old_files[] = substr($url, strrpos($url, 'upload'));
            }
        }
        if(!empty($new_urls[0])){
            foreach ($new_urls[0] as $url) {
                $new_files[] = substr($url, strrpos($url, 'upload'));
            }
        }
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            if($product->image){
                unlink(public_path($product->image));
            }
             $img_name = 'upload/product/' . $date . '/' . Str::random(8) . rand() . '.' . $img->getClientOriginalExtension();
             $destinationPath = public_path('upload/product/' . $date);
             $img->move($destinationPath, $img_name);

             $product->image = $img_name;
        }
        $img_detail = $request->image_detail;

        if (isset($img_detail)) {
            if($product->image_detail){
                unlink(public_path($product->image_detail));
            }
             $img_name_detail = 'upload/product/' . $date . '/' . Str::random(8) . rand() . '.' . $img_detail->getClientOriginalExtension();
             $destinationPath = public_path('upload/product/' . $date);
             $img_detail->move($destinationPath, $img_name_detail);

             $product->image_detail = $img_name_detail;
        }

        $product->type = $request->type;
        $product->short_des = $request->short_des;
        $product->name = $request->name;
        $product->os_supported = $request->os_supported;
        $product->description = $request->description;
        $product->save();
        if(empty($new_files)){
            foreach ($old_files as $old_file) {
                if(File::exists($old_file)){
                    unlink(public_path($old_file));
                }
            }
        }else{
            foreach ($old_files as $old_file) {
                if(!in_array($old_file, $new_files) && File::exists($old_file)){
                    unlink(public_path($old_file));
                }
            }
        }
    }

    public function delete($request, $id)
    {
        $product = Product::find($id);
        $this->removeImages($product->description);
        $packages = Package::where('product_id', $product->id)->pluck('image');

        foreach($packages as $key => $vaue){
            if ($vaue) {
                unlink(public_path($vaue));
            }
        }
        if($product->image){
            unlink(public_path($product->image));
        }
        if($product->image_detail){
            unlink(public_path($product->image_detail));
        }
        $product->delete();
        return response()->json([
            'success' => true,
            'msg' =>__('Delete successfully')
        ]);
    }

    public function featured($id){
        $product = Product::find($id);
        if($product->featured == 0){
            $product->featured = 1;
        }elseif($product->featured == 1){
            $product->featured = 0;
        }
        $product->save();
        return $product;
    }

    public function uploadImage($request){
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->file;
        if (isset($img)) {
             $img_name = 'upload/images/' . $date . '/' . Str::random(8) . rand() . '.' . $img->getClientOriginalExtension();
             $destinationPath = public_path('upload/images/' . $date);
             $img->move($destinationPath, $img_name);
        }
        return asset($img_name);
    }

    public function removeImage($request){
        $url = $request->url;
        if (isset($url)) {
            if(File::exists(substr($url, strrpos($url, 'upload')))){
                unlink(public_path(substr($url, strrpos($url, 'upload'))));
            }
        }
    }

    public function removeImages($data){
        if(!empty($data)){
            preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $data, $urls);
            if(!empty($urls[0])){
                foreach ($urls[0] as $url) {
                    if(File::exists(substr($url, strrpos($url, 'upload')))){
                        unlink(public_path(substr($url, strrpos($url, 'upload'))));
                    }
                }
            }
        }
    }
}
