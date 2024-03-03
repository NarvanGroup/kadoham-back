<?php

namespace App\Enums;

use App\Traits\Api\V1\EnumsTrait;

enum StatusEnum: string
{
    use EnumsTrait;
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case REJECTED = 'rejected';
    case CANCELED = 'canceled';
}
