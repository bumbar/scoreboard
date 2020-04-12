<?php

namespace App\Http\Controllers;

use App\Http\Resources\Cities;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function index()
    {
        $cities = City::all();

        dd(Cities::collection($cities));
    }

    public function getCities()
    {
        $cities = City::all();

        if (request()->wantsJson()) {
            return Cities::collection($cities);
        }
    }
}
