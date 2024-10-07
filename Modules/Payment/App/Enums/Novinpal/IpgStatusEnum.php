<?php

namespace Modules\Payment\App\Enums\Novinpal;

use App\Traits\Api\V1\EnumsTrait;

enum IpgStatusEnum: string
{
    use EnumsTrait;
    case TRANSACTION_INIT = 'INIT';
    case TRANSACTION_INIT_TEXT = 'تراکنش ایجاد شد.';

    case TRANSACTION_SUCCEED = 'SUCCEED';
    case TRANSACTION_SUCCEED_TEXT = 'پرداخت با موفقیت انجام شد.';

    case TRANSACTION_FAILED = 'FAILED';
    case TRANSACTION_FAILED_TEXT = 'عملیات پرداخت با خطا مواجه شد.';
}