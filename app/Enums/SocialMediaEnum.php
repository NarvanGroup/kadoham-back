<?php

namespace App\Enums;

use App\Traits\Api\V1\EnumsTrait;

enum SocialMediaEnum: string
{
    use EnumsTrait;

    case INSTAGRAM = 'اینستاگرام';
    case TELEGRAM = 'تلگرام';
    case LINKEDIN = 'لینکد این';
    case X = 'ایکس (توییتر)';
    case WEBSITE = 'وب سایت شخصی';
    case DISCORD = 'دیسکورد';
    case SKYPE = 'اسکایپ';
}
