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
    public function sectionsCitiesWithDepartures()
    {
        $hours = 3;
        $now = new \DateTime(); //current date/time
        $now->add(new \DateInterval("PT{$hours}H"));
        $new_time = $now->format('H:i:s');

        return $this->hasOne(Departure::class, 'from_id')
            ->selectRaw('cities.id, cities.name, cities.slug, count(*) as count')
            ->join('cities', 'cities.id', 'from_id')
            ->whereTime('departure_at', '>=', $new_time)
            ->groupBy('from_id');
    }
}
