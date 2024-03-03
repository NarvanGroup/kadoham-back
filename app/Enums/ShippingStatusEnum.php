<?php

namespace App\Enums;

use App\Traits\Api\V1\EnumsTrait;

enum ShippingStatusEnum: string
{
    use EnumsTrait;
    case PENDING = 'pending';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
}
