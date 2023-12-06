<?php

namespace App\Http\Resources;

use App\Models\Typeredes;
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
        $typered = Typeredes::find($this->typeredes_id);
        return [
            'id' => $this->id,
            'url'=>$this->url,
            'description' => $this->description,
            'typered' => new TyperedesResource($typered),
            'typeredes_id' => $this->typeredes_id,
                           
        ];
    }
}
