<?php

namespace Modules\Setting\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Setting\Interfaces\CurrencyRepositoryInterface;
use Modules\Setting\Models\Currency;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }
}
