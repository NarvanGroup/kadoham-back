<?php

namespace App\Enums;

enum VisibilityEnum: string
{
    case PUBLIC = 'public';
    case PROTECTED = 'protected';
    case PRIVATE = 'private';
}
