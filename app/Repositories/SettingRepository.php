<?php

namespace App\Repositories;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class SettingRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function getSetting()
    {
        return Setting::find(1);
    }

    public function update($request, $id)
    {
        $setting = Setting::find($id);
        $date = Carbon::now()->format('d-m-Y');
        $logo = $request->logo;
        if (isset($logo)) {
            if (isset($setting->logo) && $setting->logo != 'AdminLTE-3.1.0/dist/img/AdminLTELogo.png') {
                unlink(public_path($setting->logo));
            }
            $logo_name = 'upload/setting/img/' . $date . '/' . Str::random(10) . rand() . '.' . $logo->getClientOriginalExtension();
            $destinationPath = public_path('upload/setting/img/' . $date);
            $logo->move($destinationPath, $logo_name);

            $setting->logo = $logo_name;
        }
        $setting->logo_text = $request->logo_text;
        $setting->save();
        return $setting;
    }

    public function updateGeneral($request, $id)
    {
        $setting = Setting::find($id);
        $setting->seo_title = $request->seo_title;
        $setting->seo_description = $request->seo_description;
        $setting->keywords = $request->keywords;
        $setting->main_color = $request->main_color;
        $setting->secondary_color = $request->secondary_color;
        $setting->javascript = $request->javascript;
        $setting->save();
    }

    public function updateContact($request, $id)
    {
        $setting = Setting::find($id);
        $setting->contacts = json_encode($request->all());
        $setting->save();
    }
}
