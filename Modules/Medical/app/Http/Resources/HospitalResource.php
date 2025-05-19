<?php

namespace Modules\Medical\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HospitalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $specializations_en = $this->specializations->pluck('name_en')->toArray();
        $specializations_ar = $this->specializations->pluck('name_ar')->toArray();

        $facilities_en = $this->facilities->pluck('name_en')->toArray();
        $facilities_ar = $this->facilities->pluck('name_ar')->toArray();

        $doctors = $this->doctors->map(function ($doctor) {
            return [
                'id' => (string)$doctor->id,
                'name_en' => $doctor->name_en,
                'name_ar' => $doctor->name_ar,
                'specialization_en' => $doctor->specialization->name_en,
                'specialization_ar' => $doctor->specialization->name_ar,
                'profile_picture' => $doctor->profile_picture ? url(Storage::url($doctor->profile_picture)) : null,
                'bio_en' => $doctor->bio_en,
                'bio_ar' => $doctor->bio_ar,
            ];
        })->values()->toArray();

        return [
            'id' => (string)$this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'city_en' => $this->city->name_en,
            'city_ar' => $this->city->name_ar,
            'address_en' => $this->address_en,
            'address_ar' => $this->address_ar,
            'contact_en' => $this->contact_en,
            'contact_ar' => $this->contact_ar,
            'email' => $this->email,
            'website' => $this->website,
            'specialization_en' => $specializations_en,
            'specialization_ar' => $specializations_ar,
            'facilities_en' => $facilities_en,
            'facilities_ar' => $facilities_ar,
            'working_hours_en' => $this->working_hours_en,
            'working_hours_ar' => $this->working_hours_ar,
            'image' => $this->image ? url(Storage::url($this->image)) : null,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'doctors' => $doctors,
        ];
    }
}
