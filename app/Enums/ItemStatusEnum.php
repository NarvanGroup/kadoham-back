<?php

namespace App\Enums;

enum ItemStatusEnum: string
{
    case PENDING = 'pending';
    case RESERVED = 'reserved';
    case COMPLETED = 'completed';
}
