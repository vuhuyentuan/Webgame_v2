<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\Slide;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ContactRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Contact::orderBy('id', 'desc');
    }

    public function getContact($id)
    {
        return Contact::find($id);
    }

    public function create($request)
    {
        $contact = new Contact();
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            $img_name = 'upload/contacts/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/contacts/img/' . $date);
            $img->move($destinationPath, $img_name);

            $contact->image = $img_name;
        }
        $contact->name = $request->name;
        $contact->link = $request->link;
        $contact->save();
    }

    public function update($request, $id)
    {
        $contact = Contact::find($id);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            if (isset($contact->image)) {
                unlink(public_path($contact->image));
            }
            $img_name = 'upload/contacts/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/contacts/img/' . $date);
            $img->move($destinationPath, $img_name);

            $contact->image = $img_name;
        }

        $contact->name = $request->name;
        $contact->link = $request->link;
        $contact->save();
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        if (isset($contact->image)) {
            unlink(public_path($contact->image));
        }
        $contact->delete();
    }

}
