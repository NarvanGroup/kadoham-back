<?php

namespace App\Enums;

enum ItemTypeEnum: string
{
    case EXPERIENCE = 'Experience';
    case PRODUCT = 'Product';
    case CASH = 'Cash';
    case CHARITY = 'Charity';
    case DIY = 'DIY';
}
