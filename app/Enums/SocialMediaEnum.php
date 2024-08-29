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
    case FACEBOOK = 'فیس بوک';
    case WHATSAPP = 'واتس اپ';
    case SPOTIFY = 'اسپاتیفای';
    case PINTEREST = 'پینترست';
    case GITHUB = 'گیت هاب';
    case YOUTUBE = 'یوتیوب';
    case CASTBOX = 'کست باکس';

}
