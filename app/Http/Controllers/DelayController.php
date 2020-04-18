<?php

namespace App\Http\Controllers;

use App\Http\Requests\DelayRequest;
use App\Http\Resources\Departures;
use App\Models\City;
use App\Models\Departure;
use Illuminate\Http\Request;

class DelayController extends Controller
{
    public function __construct()
    {
        $this->middleware('VerifyCitiesCount');
        $this->middleware(['auth', 'admin'], ['except' => 'index']);
    }

    public function index()
    {
        $delays = Departure::with(['cityFrom', 'cityTo'])
            ->onlyNew()
            //->whereNotNull('delayed_at')
            ->orderBy('departure_at', 'asc')
            ->paginate(20);

        if (request()->wantsJson()) {
            return Departures::collection($delays);
        }

        return view('delays.index', [
            'delays' => $delays
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param Departure $delay
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Departure $delay)
    {
        return view('delays.create')
            ->with('delay', $delay)
            ->with('cities', City::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DelayRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(DelayRequest $request)
    {
        Departure::where('id', $request->id)->update(['delayed_at' => $request->delayed_at]);

        session()->flash('success', 'Закъснението беше обновено.');

        return redirect(route('delays.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Departure::where('id', request()->id)->update(['delayed_at' => null]);

        session()->flash('success', 'Закъснението беше изтрито.');

        return redirect(route('delays.index'));
    }
}
