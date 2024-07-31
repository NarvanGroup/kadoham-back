<?php

namespace App\Enums;

enum ThankYouNotesEnum: string
{
    case TEXT = 'text';
    case VIDEO = 'video';
    case VOICE = 'voice';
    case IMAGE = 'image';
}
