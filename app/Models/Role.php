<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends SpatieRole
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
            ->useLogName('roles')       // Log name
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} a role")
            ->logOnlyDirty();                 // Log only changed fields
    }
}
