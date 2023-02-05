<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalResource extends JsonResource
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
            'type' => 'personal',
            'id' => (string) $this->resource->id,
            'attributes' => [
                'name' => $this->resource->name,
                'last_name' => $this->resource->last_name,
                'identification_number' => $this->resource->identification_number,
                'code' => $this->resource->code,
                'date_of_birth' => $this->resource->date_of_birth,
                'email' => $this->resource->email,
                'charge' => $this->resource->charge,
                'status' => $this->resource->status
            ],
            'links' => [
                'self' => route('personal.show', [$this->resource->id])
            ]
        ];
    }
}