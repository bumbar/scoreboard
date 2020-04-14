<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departure extends Model
{
    use SoftDeletes, Searchable;

    protected $fillable = [
        'from_id', 'to_id', 'departure_at', 'user_id', 'places', 'price'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'departure_at' => 'datetime',
    ];

    /**
     * Select only records bigger than now() time
     *
     * @param $query
     * @return mixed
     * @throws \Exception
     */
    public function scopeOnlyNew($query)
    {
        return $query
            ->whereDate('departures.departure_at', '=', date('Y-m-d'))
            ->whereTime('departures.departure_at', '>=', date('H:i:s'));
    }

    public function cityFrom()
    {
        return $this->belongsTo(City::class, 'from_id');
    }

    public function cityTo()
    {
        return $this->belongsTo(City::class, 'to_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

//    public function scopeFilterByFromOrToCity($builder)
//    {
//        $query = '';
//        $where = '';
//
//        if (request()->query('city')) {
//            $query = 'city';
//            $where = 'from_id';
//        } elseif (request()->query('toCity')) {
//            $query = 'toCity';
//            $where = 'to_id';
//        }
//
//        if ($query) {
//            $city = City::where('slug', request()->query($query))->first();
//            if ($city) {
//                return $builder->where($where, $city->id);
//            }
//            return $builder;
//        }
//        return $builder;
//    }

//    public function countPassengersByDestination()
//    {
//        return $this->hasOne(Passenger::class, 'departure_id')
//            ->selectRaw('count(*) as count')
//            ->groupBy('departure_id');
//    }
}
