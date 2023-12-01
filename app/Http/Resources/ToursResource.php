<?php

namespace App\Http\Resources;

use App\Models\Agencies;
use App\Models\Artists;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToursResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $agency = Agencies::find($this->agency_id);
        $artist = Artists::find($this->artist_id);
        return [
            'id' => $this->id,
            'tourname' => $this->tourname,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'tourcartel' => $this->tourcartel,
            'web' => $this->web,
            'artist' => new ArtistsResource($artist),
            'artist_id' => $this->artist_id,
            'agency' => new AgenciesResource($agency),
            'agency_id' => $this->agency_id,
                           
        ];
    }
}