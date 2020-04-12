<?php

namespace App\Http\Resources;

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
        "relationCityWithDepartures":{
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
            //'id' => $this->id,
            //'name' => $this->name,
            //'slug' => $this->slug,
            'from' => $this->sectionsCitiesFromDepartures,
            'to' => $this->sectionsCitiesToDepartures,
        ];
    }
}
