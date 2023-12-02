<?php

namespace App\Http\Resources;

use App\Models\Agencies;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $agency = Agencies::find($this->agency_id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'agency' => new AgenciesResource($agency),
            'agency_id' => $this->agency_id,
                           
        ];
    }
}
