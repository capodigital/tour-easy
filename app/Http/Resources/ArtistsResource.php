<?php

namespace App\Http\Resources;

use App\Models\Agencies;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistsResource extends JsonResource
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
        $genres = explode(', ', $this->tags);
        return [
            'id' => $this->id,
            'stagename' => $this->stagename,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'birthday' => $this->birthday,
            'notes' => $this->notes,
            'tags' => $genres,
            'agency' => $agency,
            'agency_id' => $this->agency_id,
            'image' => $this->image,
            'email' => $this->email,
            'socialmedias' => SocialmediasResource::collection($this->socialmedias()->get()),
            'documents' => DocumentsResource::collection($this->documents()->get()),

        ];
    }
}
