<?php

namespace Modules\Payment\App\Enums\Novinpal;

use App\Traits\Api\V1\EnumsTrait;

enum IpgPortEnum: string
{
    use EnumsTrait;
    case NOVINPAL = 'NOVINPAL';
}