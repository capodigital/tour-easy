<?php

namespace App\Http\Resources;

use App\Models\Agencies;
use App\Models\Cities;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuppliersResource extends JsonResource
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

        return [
            'id' => $this->id,
            'tradename' => $this->tradename,
            'taxname' => $this->taxname,
            'taxcode' => $this->taxcode,
            'paydata' => $this->paydata,
            'phone' => $this->phone,
            'extra_phone' => $this->extra_phone,
            'address' => $this->address,
            'manager' => $this->manager,
            'manager_email' => $this->manager_email,
            'manager_phone' => $this->manager_phone,
            'contact' => $this->contact,
            'contact_phone' => $this->contact_phone,
            'contact_email' => $this->contact_email,
            'notes' => $this->notes,
            'email' => $this->email,
            'agency' => $agency,
            'agency_id' => $this->agency_id,
            'city' => $city,
            'city_id' => $this->city_id,
            'socialmedias' => SocialmediasResource::collection($this->socialmedias()->get()),
            'documents' => DocumentsResource::collection($this->documents()->get()),
        ];
    }
}
