<?php

namespace App\Http\Resources;

use App\Models\Tours;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tour = Tours::find($this->tour_id);

        return [
            'id' => $this->id,
            'url' => $this->url,
            'tour' => new ToursResource($tour),
            'tour_id' => $this->tour_id,                            
        ];
    }
}
