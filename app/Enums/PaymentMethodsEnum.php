<?php

namespace App\Enums;

use App\Traits\Api\V1\EnumsTrait;

enum PaymentMethodsEnum: string
{
    use EnumsTrait;
    case IPG = 'ipg';
    case WALLET = 'wallet';
    case HYBRID = 'hybrid';
}
