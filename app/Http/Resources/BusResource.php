<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
        ];
    }
}
