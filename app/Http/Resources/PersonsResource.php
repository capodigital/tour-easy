<?php

namespace App\Http\Resources;

use App\Models\Agencies;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Typecontacts;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonsResource extends JsonResource
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
        $country = Countries::find($this->country_id);
        if ($country == null) {
            $country = [
                'id' => 0,
                'name' => 'Ciudad eliminada',
            ];
        } else {
            $country = new CountriesResource($country);
        }
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
            'agency' => $agency,
            'agency_id' => $this->agency_id,
            'typecontact' => new TypecontactsResource($typecontact),
            'typecontact_id' => $this->typecontact_id,
            'country' => $country,
            'country_id' => $this->country_id,
            'socialmedias' => SocialmediasResource::collection($this->socialmedias()->get()),
            'documents' => DocumentsResource::collection($this->documents()->get()),


        ];
    }
}
