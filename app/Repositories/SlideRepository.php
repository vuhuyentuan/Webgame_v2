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
        $slide = new Slide();
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            $img_name = 'upload/slides/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/slides/img/' . $date);
            $img->move($destinationPath, $img_name);

            $slide->images = $img_name;
        }
        $slide->name = $request->name;
        $slide->description = $request->description;
        $slide->save();
    }

    public function update($request, $id)
    {
        $slide = Slide::find($id);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            if (isset($slide->image)) {
                unlink(public_path($slide->image));
            }
            $img_name = 'upload/slides/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/slides/img/' . $date);
            $img->move($destinationPath, $img_name);

            $slide->images = $img_name;
        }

        $slide->name = $request->name;
        $slide->description = $request->description;
        $slide->save();
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
