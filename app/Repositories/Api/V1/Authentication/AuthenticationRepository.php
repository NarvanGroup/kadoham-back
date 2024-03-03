<?php

namespace App\Repositories\Api\V1\Authentication;

use App\Models\Api\V1\Authentication;
use App\Repositories\Api\V1\Repository;

class AuthenticationRepository extends Repository implements AuthenticationRepositoryInterface
{
    public function __construct(Authentication $model)
    {
        parent::__construct($model);
    }
}
