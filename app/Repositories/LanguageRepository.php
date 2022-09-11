<?php

namespace App\Repositories;

use App\Models\Language;

class LanguageRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function getLanguage()
    {
        return Language::orderBy('created_at', 'desc')->get();
    }

    public function getLanguageId($id)
    {
        return Language::find($id);
    }

    public function create($request)
    {
        $lang = new Language();
        $lang->locale = $request->locale;
        $lang->name = $request->name;
        $lang->flag = $request->flag;
        $lang->status = $request->status;
        $lang->save();
    }

    public function update($request, $id)
    {
        $lang = Language::find($id);
        $lang->locale = $request->locale;
        $lang->name = $request->name;
        $lang->flag = $request->flag;
        $lang->status = $request->status;
        $lang->save();
    }
}
