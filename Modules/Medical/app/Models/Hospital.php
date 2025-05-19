<?php

namespace Modules\Medical\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Hospital extends Model
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
        'city_id',
        'user_id',
        'name_en',
        'name_ar',
        'address_en',
        'address_ar',
        'contact_en',
        'contact_ar',
        'email',
        'website',
        'working_hours_en',
        'working_hours_ar',
        'description_en',
        'description_ar',
        'image',
        'auto_booking',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'auto_booking' => 'boolean',
    ];

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'city_id',
                'user_id',
                'name_en',
                'name_ar',
                'address_en',
                'address_ar',
                'contact_en',
                'contact_ar',
                'email',
                'website',
                'working_hours_en',
                'working_hours_ar',
                'description_en',
                'description_ar',
                'image',
                'auto_booking',
            ])
            ->useLogName('hospitals')
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} a hospital")
            ->logOnlyDirty();
    }

    /**
     * Get the user that manages this hospital.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the city that the hospital belongs to.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the specializations for this hospital.
     */
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class)
            ->withPivot('booking_limit', 'working_days')
            ->withTimestamps();
    }

    /**
     * Get the facilities for this hospital.
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }

    /**
     * Get the doctors for this hospital.
     */
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    /**
     * Get the appointments for this hospital.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the patients for this hospital.
     */
    public function patients()
    {
        return $this->hasManyThrough(
            \App\Models\User::class,
            Appointment::class,
            'hospital_id', // Foreign key on appointments table
            'id', // Foreign key on users table
            'id', // Local key on hospitals table
            'user_id' // Local key on appointments table
        );
    }
}
