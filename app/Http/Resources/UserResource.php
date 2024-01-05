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
        if ($agency == null) {
            $agency = [
                'id' => 0,
                'tradename' => 'Agencia eliminada',
                'taxname' => 'Agencia eliminada'
            ];
        } else {
            $agency = new AgenciesResource($agency);
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'agency_id' => $this->agency_id,
            'agency' => $agency,
        ];
    }
}
