<?php

namespace Modules\Setting\Interfaces;

use App\Repositories\Base\BaseInterface;

interface SettingRepositoryInterface extends BaseInterface
{
    public function getSettings($key);
    public function getJsonSettings($type, $service);
}
