<?php

namespace App\Enums;

use App\Traits\Api\V1\EnumsTrait;

enum PackageTypeEnum: string
{
    use EnumsTrait;
    case DELIVERY = 'delivery';
    case CONTRACT = 'contract';
}
