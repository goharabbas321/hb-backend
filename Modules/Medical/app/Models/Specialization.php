<?php

namespace Modules\Medical\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Specialization extends Model
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
        'name_en',
        'name_ar',
    ];

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name_en',
                'name_ar',
            ])
            ->useLogName('specializations')
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} a specialization")
            ->logOnlyDirty();
    }

    /**
     * Get the hospitals that have this specialization.
     */
    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class)
            ->withPivot('booking_limit', 'working_days')
            ->withTimestamps();
    }

    /**
     * Get the doctors with this specialization.
     */
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    /**
     * Get the appointments for this specialization.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the patients for this specialization.
     */
    public function patients()
    {
        return $this->hasManyThrough(
            \App\Models\User::class,
            Appointment::class,
            'specialization_id', // Foreign key on appointments table
            'id', // Foreign key on users table
            'id', // Local key on specializations table
            'user_id' // Local key on appointments table
        );
    }
}
