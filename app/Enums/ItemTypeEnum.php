<?php

namespace App\Enums;

enum ItemTypeEnum: string
{
    case EXPERIENCE = 'Experience';
    case PRODUCTS = 'Products';
    case CASH = 'Cash';
    case VOUCHERS = 'Vouchers';
    case DIY = 'DIY';
}
