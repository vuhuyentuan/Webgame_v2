<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layout_admin.master', 'layout_index.master', 'users.histories.recharge_show',
            'users.histories.order_show', 'layout_index.pages.contact'], function ($view) {
            $setting = Setting::find(1);
            $view->with(['setting' => $setting]);
        });
        Schema::defaultStringLength(191);
    }
}
