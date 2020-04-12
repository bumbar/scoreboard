<?php

namespace App\Http\Resources;

use App\Models\Departure;
use Illuminate\Http\Resources\Json\JsonResource;

class Cities extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *
     * {
        "id":1,
        "name":"София",
        "slug":"sofiya",
        "relationCityFromDepartures":{
            "name":"София",
            "slug":"sofiya",
            "count":1
        }
      }
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'from' => $this->sectionsCitiesFromDepartures,
            'to' => $this->sectionsCitiesToDepartures,
        ];
    }
}
