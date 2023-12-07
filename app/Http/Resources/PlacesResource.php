<?php

namespace App\Http\Resources;

use App\Models\Agencies;
use App\Models\Cities;
use App\Models\Typeplaces;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlacesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $agency = Agencies::find($this->agency_id);
        $city = Cities::find($this->city_id);
        $typeplace = Typeplaces::find($this->typecontact_id);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'google_id' => $this->google_id,
            'manager' => $this->manager,
            'phone' => $this->phone,
            'extra_phone' => $this->extra_phone,
            'gis' => $this->gis,
            'address' => $this->address,
            'notes' => $this->notes,
            'email' => $this->email, 
            'agency' => new AgenciesResource($agency),
            'agency_id' => $this->agency_id,
            'typeplace' => new TypeplacesResource($typeplace),
            'typeplace_id' => $this->typeplace_id,
            'city' => new CitiesResource($city),
            'city_id' => $this->city_id, 
                           
        ];
    }
}
