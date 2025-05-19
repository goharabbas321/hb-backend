<?php

namespace Modules\Medical\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Appointment extends Model
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
        'user_id',
        'appointment_date',
        'appointment_number',
        'status',
        'notes',
        'reason',
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
                'user_id',
                'appointment_date',
                'appointment_number',
                'status',
                'notes',
                'reason',
            ])
            ->useLogName('appointments')
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} an appointment")
            ->logOnlyDirty();
    }

    /**
     * Get the hospital associated with the appointment.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Get the specialization associated with the appointment.
     */
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    /**
     * Get the patient associated with the appointment.
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
