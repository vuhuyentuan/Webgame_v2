<?php

namespace App\Repositories;

use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PackageRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPackage($request)
    {
       return Package::where('product_id', $request->id)->orderby('id', 'desc');
    }

    public function getPackageId($id)
    {
       return Package::find($id);
    }

    public function create($request)
    {
        $package = new Package();
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
             $img_name = 'upload/package/' . $date . '/' . Str::random(8) . rand() . '.' . $img->getClientOriginalExtension();
             $destinationPath = public_path('upload/package/' . $date);
             $img->move($destinationPath, $img_name);

             $package->image = $img_name;
        }
        $package->product_id = $request->id;
        $package->value = $request->value;
        $package->name = $request->name;
        $package->point = str_replace(',','',$request->point);
        $package->save();
    }

    public function update($request, $id)
    {
        $package = Package::find($id);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            if($package->image){
                unlink(public_path($package->image));
            }
             $img_name = 'upload/package/' . $date . '/' . Str::random(8) . rand() . '.' . $img->getClientOriginalExtension();
             $destinationPath = public_path('upload/package/' . $date);
             $img->move($destinationPath, $img_name);

             $package->image = $img_name;
        }

        $package->value = $request->value;
        $package->name = $request->name;
        $package->point = str_replace(',','',$request->point);
        $package->save();
    }

    public function delete($id)
    {
        $package = Package::find($id);
        if($package->image){
            unlink(public_path($package->image));
        }
        $package->delete();
    }
}

