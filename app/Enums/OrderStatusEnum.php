<?php

namespace App\Enums;

use App\Traits\Api\V1\EnumsTrait;

enum OrderStatusEnum: string
{
    use EnumsTrait;
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case REJECTED = 'rejected';
    case CANCELED = 'canceled';
    case DONE = 'done';
}
