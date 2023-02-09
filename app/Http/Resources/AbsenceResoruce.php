<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenceResoruce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string) $this->resource->id,
            'date' => $this->resource->date->toDateString(),
            'observation' => $this->resource->observation,
            'type' => $this->resource->type,
            'personal_id' => $this->resource->personal_id,
        ];
    }
}
