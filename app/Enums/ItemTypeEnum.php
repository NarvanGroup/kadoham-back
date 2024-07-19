<?php

namespace App\Enums;

enum ItemTypeEnum: string
{
    case EXPERIENCE = 'experience';
    case PRODUCT = 'product';
    case CASH = 'cash';
    case CHARITY = 'charity';
    case DIY = 'diy';
}
