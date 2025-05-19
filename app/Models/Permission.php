<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Permission extends SpatiePermission
{
    use LogsActivity;

    /**
     * Get the options for logging activity.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'guard_name'])  // Fields to log
            ->useLogName('permissions')       // Log name
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} a permission")
            ->logOnlyDirty();                 // Log only changed fields
    }
}
