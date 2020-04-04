<?php

namespace App\Http\Controllers;

use App\Http\Filters\DepartureFilter;
use App\Http\Requests\DepartureRequest;
use App\Http\Resources\Departures;
use App\Models\City;
use App\Models\Departure;

class DepartureController extends Controller
{
    public function __construct()
    {
        $this->middleware('VerifyCitiesCount');
        $this->middleware(['auth', 'admin'], ['except' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param DepartureFilter $filter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(DepartureFilter $filter)
    {
        $departures = Departure::with(['cityFrom', 'cityTo'])
            ->onlyNew()
            ->orderBy('departure_at', 'asc')
            ->filter($filter)
            ->paginate(20);

        if (request()->wantsJson()) {
            return Departures::collection($departures);
        }

        return view('departures.index', [
            'departures' => $departures
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('departures.create')->with('cities', City::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DepartureRequest $request)
    {
        Departure::create([
            'from_id' => $request->from,
            'to_id' => $request->to,
            'places' => $request->places,
            'price' => $request->price,
            'departure_at' => $request->departure_at,
            'user_id' => auth()->user()->id
        ]);

        session()->flash('success', 'Създадохте успешно курса.');

        return redirect(route('departures.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Departure $departure
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Departure $departure)
    {
        return view('departures.create')
            ->with('departure', $departure)
            ->with('cities', City::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DepartureRequest $request
     * @param Departure $departure
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(DepartureRequest $request, Departure $departure)
    {
        $data = $request->only(['from', 'to', 'departure_at']);

        $departure->update($data);

        session()->flash('success', 'Курсът беше обновен.');

        return redirect(route('departures.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Departure $departure
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $departure = Departure::withTrashed()->where('id', $id)->firstOrFail();

        if ($departure->trashed()) {
            $departure->forceDelete();
        } else {
            $departure->delete();
        }

        session()->flash('success', 'Курсът беше изтрит.');

        return redirect(route('departures.index'));
    }

    /**
     * Display a list of all trashed posts
     *
     * @return Factory|View
     */
    public function trashed()
    {
        $trashed = Departure::onlyTrashed()->paginate(3);

        return view('departures.index')->with('departures', $trashed);
    }

    public function restore($id)
    {
        $departure = Departure::withTrashed()->where('id', $id)->firstOrFail();

        $departure->restore();

        session()->flash('success', 'Курсът беше върнат.');

        return redirect()->back();
    }
}
