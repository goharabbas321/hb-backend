<?php

namespace Modules\Medical\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'hospital' => $this->whenLoaded('hospital', function () {
                return [
                    'id' => $this->hospital->id,
                    'name' => $this->hospital->name,
                ];
            }),
            'specialization' => $this->whenLoaded('specialization', function () {
                return [
                    'id' => $this->specialization->id,
                    'name' => $this->specialization->name,
                ];
            }),
            'patient' => $this->whenLoaded('patient', function () {
                // Get the patient information from the JSON field
                $patientInfo = json_decode($this->patient->user_information, true) ?? [];

                return [
                    'id' => $this->patient->id,
                    'name' => $this->patient->name,
                    'email' => $this->patient->email,
                    'phone' => $this->patient->phone,
                    'age' => $patientInfo['age'] ?? null,
                    'gender' => $patientInfo['gender'] ?? null,
                    'city' => $patientInfo['city'] ?? null,
                    'address' => $patientInfo['address'] ?? null,
                    'emergency_contact' => $patientInfo['emergency_contact'] ?? null,
                    'country' => $patientInfo['country'] ?? null,
                ];
            }),
            'appointment_date' => $this->appointment_date,
            'appointment_number' => $this->appointment_number,
            'status' => $this->status,
            'reason' => $this->reason,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
