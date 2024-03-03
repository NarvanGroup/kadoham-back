<?php

namespace App\Repositories\Api\V1\Card;

use App\Models\Api\V1\Card;
use App\Repositories\Api\V1\Repository;

class CardRepository extends Repository implements CardRepositoryInterface
{
    public function __construct(Card $model)
    {
        parent::__construct($model);
    }
}
