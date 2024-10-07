<?php

namespace Modules\Payment\App\Enums\Novinpal;

enum CallbackCodesEnum: int
{
    case SUCCESS = 100; // تراکنش موفقیت آمیز بود
    case FAILURE = 109; // تراکنش ناموفق بود
    case PSP_ERROR = 104; // خطای PSP
    case PSP_NOT_FOUND = 107; // PSP یافت نشد
    case SERVER_ERROR = 108; // خطای سرور
    case INVALID_METHOD = 114; // متد ارسال شده اشتباه است
    case UNCONFIRMED_TERMINAL = 115; // ترمینال تأیید نشده است
    case TERMINAL_INACTIVE = 116; // ترمینال غیرفعال است
    case TERMINAL_REJECTED = 117; // ترمینال رد شده است
    case TERMINAL_SUSPENDED = 118; // ترمینال تعلیق شده است
    case UNDEFINED_TERMINAL = 119; // ترمینالی تعریف نشده است
    case ACCOUNT_SUSPENDED = 120; // حساب کاربری پذیرنده به حالت تعلیق درآمده است
    case ACCOUNT_UNCONFIRMED = 121; // حساب کاربری پذیرنده تأیید نشده است
    case ACCOUNT_NOT_FOUND = 122; // حساب کاربری پذیرنده یافت نشد
}