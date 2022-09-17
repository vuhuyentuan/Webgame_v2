<?php

namespace App\Repositories;

use App\Models\Slide;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SlideRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Slide::orderBy('id', 'desc');
    }

    public function getSlide($id)
    {
        return Slide::find($id);
    }

    public function create($request)
    {
        $bank = new Slide();
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            $img_name = 'upload/slides/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/slides/img/' . $date);
            $img->move($destinationPath, $img_name);

            $bank->images = $img_name;
        }
        $bank->name = $request->name;
        $bank->description = $request->description;
        $bank->save();
    }

    public function update($request, $id)
    {
        $bank = Slide::find($id);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            if (isset($bank->image)) {
                unlink(public_path($bank->image));
            }
            $img_name = 'upload/slides/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/slides/img/' . $date);
            $img->move($destinationPath, $img_name);

            $bank->images = $img_name;
        }

        $bank->name = $request->name;
        $bank->description = $request->description;
        $bank->save();
    }

    public function destroy($id)
    {
        $slide = Slide::find($id);
        if (isset($slide->images)) {
            unlink(public_path($slide->images));
        }
        $slide->delete();
    }

}
