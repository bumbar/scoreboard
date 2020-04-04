<?php

namespace App\Models;

use App\Models\Traits\EnumTrait;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use EnumTrait;

    /**
     * The attributes that are enum.
     *
     * @var array
     */
    protected static $enums = [
        'RAILS' => 'rails',
        'HUMAN_STATUS' => 'human_status'
    ];
    /**
     * Passenger's roles
     *
     * @var array
     */
    public const RAILS = [
        'first_class'  => 1,
        'second_class' => 2
    ];

    /**
     * Human's roles
     *
     * @var array
     */
    public const HUMAN_STATUS = [
        'regular'  => 1,
        'child'    => 2,
        'retired'  => 3,
        'invalid'  => 4,
    ];

    public function departure()
    {
        return $this->belongsTo(Departure::class);
    }
}
