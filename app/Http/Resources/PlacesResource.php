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
        if ($agency == null) {
            $agency = [
                'id' => 0,
                'tradename' => 'Agencia eliminada',
                'taxname' => 'Agencia eliminada'
            ];
        } else {
            $agency = new AgenciesResource($agency);
        }
        $city = Cities::find($this->city_id);
        if ($city == null) {
            $city = [
                'id' => 0,
                'name' => 'Ciudad eliminada',
            ];
        } else {
            $city = new CitiesResource($city);
        }
        $typeplace = Typeplaces::find($this->typeplace_id);

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
            'agency' => $agency,
            'agency_id' => $this->agency_id,
            'typeplace' => new TypeplacesResource($typeplace),
            'typeplace_id' => $this->typeplace_id,
            'city' => $city,
            'city_id' => $this->city_id,
            'socialmedias' => SocialmediasResource::collection($this->socialmedias()->get()),
            'documents' => DocumentsResource::collection($this->documents()->get()),



        ];
    }
}
