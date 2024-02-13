<?php

namespace App\Http\Resources;

use App\Models\Agencies;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Groups;
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
                'name' => 'País eliminado',
            ];
        } else {
            $country = new CountriesResource($country);
        }
        $typecontact = Typecontacts::find($this->typecontact_id);
        if ($this->group_id == null) {
            $group = [
                'id' => null,
                'name' => 'Sin asignar',
            ];
        } else {
            $group = Groups::find($this->group_id);
        }


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
            'passport' => $this->passport,
            'passport_expiry' => $this->passport_expiry,
            'notify_type' => $this->notify_type,
            'group' => new GroupsResource($group),
            'group_id' => $this->group_id,
            'socialmedias' => SocialmediasResource::collection($this->socialmedias()->get()),
            'documents' => DocumentsResource::collection($this->documents()->get()),


        ];
    }
}
