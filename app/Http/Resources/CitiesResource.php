<?php

namespace App\Http\Resources;

use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $country = Countries::where('code',$this->country_id)->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => new CountriesResource($country),
            'country_id' => $this->country_id,
                           
        ];
    }
}
