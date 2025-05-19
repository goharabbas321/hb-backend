<?php

namespace Modules\Setting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Language extends Model
{
    use SoftDeletes;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'code',
                'file',
                'status',
                'is_rtl'
            ]) // Fields to log
            ->useLogName('languages')                 // Log name
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} a language")
            ->logOnlyDirty();                     // Log only changed fields
    }
}
