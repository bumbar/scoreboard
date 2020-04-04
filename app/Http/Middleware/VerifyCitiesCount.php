<?php

namespace App\Http\Middleware;

use App\Models\City;
use Closure;

class VerifyCitiesCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (City::all()->count() === 0) {
            session()->flash('error', 'Трябва да добавите градове, за да продължите.');

            return redirect(route('departures.index'));
        }

        return $next($request);
    }
}
