<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParturitionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'service_number' => $this->service_number,
            'registration_time' => $this->registration_time,
            'patient_id' => $this->patient_id,
            'medic_id' => $this->medic_id,
            'phone' => $this->phone,
            'service_fee' => $this->formatted_service_fee,
            'discount' => $this->formatted_discount,
            'total_fee' => $this->total_fee,
            'notes' => $this->notes,
        ];
    }
}
