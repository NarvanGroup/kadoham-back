<?php

namespace App\Repositories\Api\V1\WishList;

use App\Models\WishList;
use App\Repositories\Api\V1\Repository;

class WishListRepository extends Repository implements WishListRepositoryInterface
{
    public function __construct(WishList $model)
    {
        parent::__construct($model);
    }
}
