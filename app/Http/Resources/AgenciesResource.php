<?php

namespace App\Http\Resources;

use App\Models\Cities;
use App\Models\Typeagencies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgenciesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $city = Cities::find($this->city_id);
        if ($city == null) {
            $city = [
                'id' => 0,
                'name' => 'Ciudad eliminada',
            ];
        } else {
            $city = new CitiesResource($city);
        }
        $typeagency = Typeagencies::find($this->typeagency_id);
        return [
            'id' => $this->id,
            'tradename' => $this->tradename,
            'taxname' => $this->taxname,
            'taxcode' => $this->taxcode,
            'image' => $this->imagePath,
            'owner' => $this->owner,
            'address' => $this->address,
            'email' => $this->email,
            'web' => $this->web,
            'notes' => $this->notes,
            'phone' => $this->phone,
            'city' => $city,
            'city_id' => $this->city_id,
            'typeagency' => new TypeagenciesResource($typeagency),
            'typeagency_id' => $this->typeagency_id,
            'socialmedias' => SocialmediasResource::collection($this->socialmedias()->get()),
            'documents' => DocumentsResource::collection($this->documents()->get()),
            // 'users' => User::where('agency_id', $this->id),
            'users' => $this->users,

        ];
    }
}
