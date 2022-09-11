<?php

namespace App\Repositories;

use App\Models\Language;
use App\Models\Translation;

class TranslateRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function getLanguage()
    {
        return Language::where('status', 'show')->orderBy('created_at', 'desc')->get();
    }

    public function getTranslate()
    {
        return Translation::where('locale', 'raw')->count();
    }

    public function update($request, $id)
    {
        $lang = Language::find($id);
        if (empty($lang)) {
            abort(404);
        }
        $translate = $request->input('translate');
        if (is_array($translate)) {
            foreach ($translate as $item_id => $string) {
                $check = Translation::where('locale', $lang->locale)->where('parent_id', $item_id)->first();
                if ($check) {
                    $check->string = $string;
                    $check->save();
                } else {
                    $check = new Translation();
                    $check->parent_id = $item_id;
                    $check->string = $string;
                    $check->locale = $lang->locale;
                    $check->save();
                }
            }
        }
    }
}
