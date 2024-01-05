<?php

namespace App\Http\Resources;

use App\Models\Itineraries;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $itinerary = Itineraries::find($this->itinerary_id);
        if ($itinerary == null) {
            $itinerary = [
                'id' => 0,
                'name' => 'Actividad eliminada',
            ];
        } else {
            $itinerary = new ItinerariesResource($itinerary);
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'amount' => $this->amount,
            'email' => $this->email,
            'wallet' => $this->wallet,
            'chain' => $this->chain,
            'notes' => $this->notes,
            'itinerary_id' => $this->itinerary_id,
            'itinerary' => $itinerary,


        ];
    }

}
