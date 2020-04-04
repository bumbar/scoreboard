<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Departures extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'from' => $this->cityFrom->name,
            'to' => $this->cityTo->name,
            'places' => $this->places,
            //'passengers' => $this->countPassengersByDestination,
            'departure_at' => $this->departure_at,
            //'cnt' => $this->loadCount('passengers')
            'passengers_count' => $this->passengers->count(),
        ];
    }
}
