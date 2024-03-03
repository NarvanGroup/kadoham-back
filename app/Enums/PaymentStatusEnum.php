<?php

namespace App\Enums;

use App\Traits\Api\V1\EnumsTrait;

enum PaymentStatusEnum: string
{
    use EnumsTrait;
    case PENDING = 'pending';
    case PAID = 'paid';
    case REFUNDED = 'refunded';
    case FAILED = 'failed';
}
