<?php

namespace App\Providers;

use App\Models\City;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
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
        //solve incompatible with sql_mode=only_full_group_by
        //in folder config => database.php make sure mysql strict is false

        $minutes = 1440; # 1 day
        $cities = Cache::remember('cities', $minutes, function () {

            // config/app.php
            // change 'timezone' => 'UTC' to 'timezone' => 'Europe/Sofia'
            $now = (new \DateTime())->format('H:i:s'); //current date/time

            return City::leftJoin('departures', 'departures.from_id', '=', 'cities.id')
                ->selectRaw('cities.name, count(*) as cnt')
                ->whereTime('departures.departure_at', '>=', $now)
                ->groupBy('departures.from_id')
                ->get();
        });

        View::share('cities', $cities);
    }
}
