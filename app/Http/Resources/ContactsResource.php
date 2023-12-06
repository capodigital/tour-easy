<?php

namespace App\Http\Resources;

use App\Models\Agencies;
use App\Models\Cities;
use App\Models\Typecontacts;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactsResource extends JsonResource
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
        $typecontact = Typecontacts::find($this->typecontact_id);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'extra_phone' => $this->extra_phone,
            'lang' => $this->lang,
            'position' => $this->position,
            'notify' => $this->notify,
            'notes' => $this->notes,
            'email' => $this->email, 
            'agency' => new AgenciesResource($agency),
            'agency_id' => $this->agency_id,
            'typecontact' => new TypecontactsResource($typecontact),
            'typecontact_id' => $this->typecontact_id,
            'city' => new CitiesResource($city),
            'city_id' => $this->city_id, 
                           
        ];
    }
}
