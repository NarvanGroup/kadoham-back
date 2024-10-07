<?php

namespace Modules\Payment\App\Enums\Novinpal;

enum ReverseCodesEnum: int
{
    case SUCCESS = 100; // درخواست موفقیت آمیز بود
    case IP_NOT_ALLOWED = 101; // آی پی سایت پذیرنده مجاز نیست
    case TERMINAL_BLOCKED = 102; // ترمینال بلاک شده است
    case INVALID_RETURN_ADDRESS = 103; // آدرس بازگشتی متعلق به سایت پذیرنده نیست
    case PSP_ERROR = 104; // خطای PSP
    case PSP_NOT_FOUND = 107; // PSP یافت نشد
    case SERVER_ERROR = 108; // خطای سرور
    case INVALID_AMOUNT = 110; // مبلغ اشتباه وارد شده یا کمتر از 10000 ریال است
    case INVALID_API_KEY = 111; // کلید API اشتباه است
    case MERCHANT_INACTIVE = 112; // پذیرنده غیرفعال است
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