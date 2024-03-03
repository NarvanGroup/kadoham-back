<?php

namespace App\Enums;

use App\Traits\Api\V1\EnumsTrait;

enum PlatformsEnum: string
{
    use EnumsTrait;

    case KADOHAM = 'کادوهام';
    case ALOSRRAFI = 'الو صرافی';
}
