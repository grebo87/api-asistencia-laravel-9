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
            'id' => (string) $this->resource->id,
            'name' => $this->resource->name,
            'last_name' => $this->resource->last_name,
            'identification_number' => $this->resource->identification_number,
            'code' => $this->resource->code,
            'date_of_birth' => $this->resource->date_of_birth->format('Y-m-d'),
            'email' => $this->resource->email,
            'charge' => $this->resource->charge,
            'status' => $this->resource->status,
            'assistance' =>$this->when( $request->assistance, $this->resource->dayAssistance()),
        ];
    }
}
