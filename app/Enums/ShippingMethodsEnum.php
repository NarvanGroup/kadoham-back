<?php

namespace App\Enums;

use App\Traits\Api\V1\EnumsTrait;

enum ShippingMethodsEnum: string
{
    use EnumsTrait;
    case DELIVERY = 'delivery';
    case HELD = 'held';
}
