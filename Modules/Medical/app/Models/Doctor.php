<?php

namespace Modules\Medical\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Doctor extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital_id',
        'specialization_id',
        'name_en',
        'name_ar',
        'bio_en',
        'bio_ar',
        'profile_picture',
    ];

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'hospital_id',
                'specialization_id',
                'name_en',
                'name_ar',
                'bio_en',
                'bio_ar',
                'profile_picture',
            ])
            ->useLogName('doctors')
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} a doctor")
            ->logOnlyDirty();
    }

    /**
     * Get the hospital that the doctor belongs to.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Get the specialization that the doctor has.
     */
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    /**
     * Get the appointments for this doctor.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
