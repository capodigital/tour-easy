<?php

namespace App\Http\Resources;

use App\Models\Cities;
use App\Models\Contacts;
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
        $cityend = Cities::find($this->city_destination_id);
        $typeitinerary = Typeitineraries::find($this->typeitinerary_id);
        $place = Places::find($this->place_id);
        $contact = Contacts::find($this->contact_id);
        $supplier = Suppliers::find($this->supplier_id);


        return [
            'id' => $this->id,
            'name' => $this->name,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'outoflour' => $this->outoflour,
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
            'citystart' => new CitiesResource($citystart),
            'city_start_id' => $this->city_start_id, 
            'cityend' => new CitiesResource($cityend),
            'city_destination_id' => $this->city_destination_id, 
            'place' => new PlacesResource($place),
            'place_id' => $this->place_id, 
            'contact' => new ContactsResource($contact),
            'contact_id' => $this->contact_id, 
            'supplier' => new SuppliersResource($supplier),
            'supplier_id' => $this->supplier_id, 

                           
        ];
    }
}
