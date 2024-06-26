<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'address' => $this->address,
            'province' => ProvinceResource::make($this->whenLoaded('province')),
            'district' => DistrictResource::make($this->whenLoaded('district')),
            'ward' => WardResource::make($this->whenLoaded('ward'))
        ];
    }
}
