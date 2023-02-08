<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssistanceResource extends JsonResource
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
            'start_time' => $this->resource->start_time->toDateTimeString(),
            'time_of' => $this->resource->time_of?->toDateTimeString(),
            'personal_id' => $this->resource->personal_id,
        ];
    }
}
