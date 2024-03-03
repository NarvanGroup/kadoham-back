<?php

namespace App\Repositories\Api\V1\Address;

use App\Models\Api\V1\Address;
use App\Repositories\Api\V1\Repository;

class AddressRepository extends Repository implements AddressRepositoryInterface
{
    public function __construct(Address $model)
    {
        parent::__construct($model);
    }
}
