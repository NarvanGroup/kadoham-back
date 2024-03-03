<?php

namespace App\Enums;

use App\Traits\Api\V1\EnumsTrait;

enum ContractStatusEnum: string
{
    use EnumsTrait;

    case PENDING = 'pending';
    case ACTIVE = 'active';
    case REJECT = 'reject';
    const EXPIRED = 'expired';
    const CANCELLED = 'cancelled';

}
