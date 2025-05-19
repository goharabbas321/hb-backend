<?php

namespace Modules\Setting\Repositories;

use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Interfaces\SettingRepositoryInterface;
use Modules\Setting\Models\Setting;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    public function getSettings($key)
    {
        $setting = DB::table('settings')->where('key', $key)->first();

        if ($setting) {
            // If the value is JSON, decode it
            return json_decode($setting->value, true) ?? $setting->value;
        }

        return null;
    }

    public function getJsonSettings($type, $service)
    {
        $jsonSettings = $this->getSettings($type);

        if (is_array($jsonSettings) && isset($jsonSettings[$service])) {
            return $jsonSettings[$service];
        }

        return null;
    }
}
