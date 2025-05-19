<?php

namespace Modules\Setting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use SoftDeletes;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'key',
                'value'
            ]) // Fields to log
            ->useLogName('settings')                 // Log name
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} a setting")
            ->logOnlyDirty();                     // Log only changed fields
    }
}
