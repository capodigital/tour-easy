<?php

namespace App\Http\Resources;

use App\Models\Typesocialmedias;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialmediasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $typesocialmedia = Typesocialmedias::find($this->typesocialmedia_id);
        return [
            'id' => $this->id,
            'url'=>$this->url,
            'description' => $this->description,
            'typesocialmedia' => new TypesocialmediasResource($typesocialmedia),
            'typesocialmedia_id' => $this->typesocialmedia_id,
                           
        ];
    }
}
