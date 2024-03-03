<?php

namespace App\Repositories\Api\V1\User;

use App\Models\Api\V1\User;
use App\Repositories\Api\V1\Repository;

class UserRepository extends Repository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
