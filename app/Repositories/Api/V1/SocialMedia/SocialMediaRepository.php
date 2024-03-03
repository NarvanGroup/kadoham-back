<?php

namespace App\Repositories\Api\V1\SocialMedia;

use App\Models\Api\V1\SocialMedia;
use App\Repositories\Api\V1\Repository;

class SocialMediaRepository extends Repository implements SocialMediaRepositoryInterface
{
    public function __construct(SocialMedia $model)
    {
        parent::__construct($model);
    }
}
