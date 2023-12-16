<?php

namespace App\Http\Resources;

use App\Models\Itineraries;
use App\Models\Tours;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $itinerary = Itineraries::find($this->itinerary_id);
        $tour = Tours::find($this->tour_id);

        return [
            'id' => $this->id,
            'platform' => $this->platform,
            'notes' => $this->notes,
            'itinerary' => new ItinerariesResource($itinerary),
            'itinerary_id' => $this->itinerary_id,
            'tour' => new ToursResource($tour),
            'tour_id' => $this->tour_id, 

                           
        ];
    }
}
