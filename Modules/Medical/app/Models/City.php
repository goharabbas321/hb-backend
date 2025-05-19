<?php

namespace Modules\Medical\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
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
            ->useLogName('cities')
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} a city")
            ->logOnlyDirty();
    }

    /**
     * Get the hospitals for this city.
     */
    public function hospitals()
    {
        return $this->hasMany(Hospital::class);
    }
}
