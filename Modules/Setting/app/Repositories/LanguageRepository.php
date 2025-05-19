<?php

namespace Modules\Setting\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Setting\Interfaces\LanguageRepositoryInterface;
use Modules\Setting\Models\Language;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    public function __construct(Language $model)
    {
        parent::__construct($model);
    }
}
