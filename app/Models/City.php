<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function departures()
    {
        return $this->hasMany(Departure::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Select only records bigger than now() time
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @throws \Exception
     */
    public function sectionsCitiesFromDepartures()
    {
        return $this->hasOne(Departure::class, 'from_id')
            ->selectRaw('cities.id, cities.name, cities.slug, count(*) as count')
            ->join('cities', 'cities.id', 'from_id')
            ->whereDate('departures.departure_at', '=', date('Y-m-d'))
            ->whereTime('departures.departure_at', '>=', date('H:i:s'))
            ->groupBy('from_id');
    }

    /**
     * Select only records bigger than now() time
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @throws \Exception
     */
    public function sectionsCitiesToDepartures()
    {
        return $this->hasOne(Departure::class, 'to_id')
            ->selectRaw('cities.id, cities.name, cities.slug, count(*) as count')
            ->join('cities', 'cities.id', 'to_id')
            ->whereDate('departures.departure_at', '=', date('Y-m-d'))
            ->whereTime('departures.departure_at', '>=', date('H:i:s'))
            ->groupBy('to_id');
    }
}
