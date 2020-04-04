<?php

namespace App;

use App\Models\Departure;
use App\Models\Traits\EnumTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, EnumTrait;

    /**
     * The attributes that are enum.
     *
     * @var array
     */
    protected static $enums = [
        'ROLES' => 'role',
    ];
    /**
     * Passenger's roles
     *
     * @var array
     */
    public const ROLES = [
        'admin'  => 1,
        'writer' => 2
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function departures()
    {
        return $this->hasMany(Departure::class);
    }

    public function isAdmin()
    {
        return $this->role === 1; //admin
    }
}
