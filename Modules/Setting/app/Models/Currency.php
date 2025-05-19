<?php

namespace Modules\Setting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Currency extends Model
{
    use SoftDeletes;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'code',
                'symbol'
            ]) // Fields to log
            ->useLogName('currencies')                 // Log name
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} a currency")
            ->logOnlyDirty();                     // Log only changed fields
    }
}
