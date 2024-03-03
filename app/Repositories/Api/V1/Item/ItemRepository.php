<?php

namespace App\Repositories\Api\V1\Item;

use App\Models\Api\V1\Item;
use App\Repositories\Api\V1\Repository;

class ItemRepository extends Repository implements ItemRepositoryInterface
{
    public function __construct(Item $model)
    {
        parent::__construct($model);
    }
}
