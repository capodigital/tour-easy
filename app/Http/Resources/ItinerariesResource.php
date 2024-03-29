<?php

namespace App\Http\Resources;

use App\Models\Cities;
use App\Models\Persons;
use App\Models\Places;
use App\Models\Suppliers;
use App\Models\Tours;
use App\Models\Typeitineraries;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItinerariesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tour = Tours::find($this->tour_id);
        $citystart = Cities::find($this->city_start_id);
        if ($citystart == null) {
            $citystart = [
                'id' => 0,
                'name' => 'Ciudad eliminada',
            ];
        } else {
            $citystart = new CitiesResource($citystart);
        }
        $cityend = Cities::find($this->city_destination_id);
        if ($cityend == null) {
            $cityend = [
                'id' => 0,
                'name' => 'Ciudad eliminada',
            ];
        } else {
            $cityend = new CitiesResource($cityend);
        }
        $typeitinerary = Typeitineraries::find($this->typeitinerary_id);
        $place = Places::find($this->place_id);
        if ($place == null) {
            $place = [
                'id' => 0,
                'name' => 'Lugar eliminado',
            ];
        } else {
            $place = new PlacesResource($place);
        }
        /*$person = Persons::find($this->person_id);
        if ($person == null) {
            $person = [
                'id' => 0,
                'name' => 'Contacto eliminado',
            ];
        } else {
            $person = new PersonsResource($person);
        }*/
        $persons_1 = $this->persons()->wherePivot('type', 1)->get();
        $persons_2 = $this->persons()->wherePivot('type', 2)->get();
        $supplier = Suppliers::find($this->supplier_id);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'outoftour' => $this->outoftour,
            'carrier' => $this->carrier,
            'carrier_id' => $this->carrier_id,
            'showcheck' => $this->showcheck,
            'showtime' => $this->showtime,
            'notes' => $this->notes,
            'notify' => $this->notify,
            'tour' => new ToursResource($tour),
            'tour_id' => $this->tour_id,
            'typeitinerary' => new TypeitinerariesResource($typeitinerary),
            'typeitinerary_id' => $this->typeitinerary_id,
            'citystart' => $citystart,
            'city_start_id' => $this->city_start_id,
            'cityend' => $cityend,
            'city_destination_id' => $this->city_destination_id,
            'place' => $place,
            'place_id' => $this->place_id,
            'persons_1' => PersonsResource::collection($persons_1),
            'persons_2' => PersonsResource::collection($persons_2),
            'supplier' => new SuppliersResource($supplier),
            'supplier_id' => $this->supplier_id,
        ];
    }
}
