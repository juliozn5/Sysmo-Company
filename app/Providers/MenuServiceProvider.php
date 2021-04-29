<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // get all data from menu.json file
        $verticalMenuJson0 = file_get_contents(base_path('resources/data/menu-data/verticalMenu0.json'));
        $verticalMenuData0 = json_decode($verticalMenuJson0);
        $verticalMenuJson1 = file_get_contents(base_path('resources/data/menu-data/horizontalMenu.json'));
        $verticalMenuData1 = json_decode($verticalMenuJson1);

         // Share all menuData to all the views
        View::share('menuData',[$verticalMenuData0, $verticalMenuData1]);
    }
}
