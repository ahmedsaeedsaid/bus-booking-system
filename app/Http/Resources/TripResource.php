<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'bus' => new BusResource($this->bus),
            'seats' => SeatResource::collection($this->seats)
        ];
    }
}
