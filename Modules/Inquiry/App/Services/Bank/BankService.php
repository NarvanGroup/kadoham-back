<?php

namespace Modules\Inquiry\App\Services\Bank;

use App\Http\Controllers\Controller;
use Http;

// Bank codes and names
const BANKS_CARD_CODES = [
    '207177' => 'بانک توسعه صادرات ایران',
    '502229' => 'بانک پاسارگاد',
    '502806' => 'بانک شهر',
    '502908' => 'بانک توسعه تعاون',
    '502910' => 'بانک کارآفرین',
    '502938' => 'بانک دی',
    '505416' => 'بانک گردشگری',
    '505785' => 'بانک ایران زمین',
    '505801' => ' موسسه اعتباری کوثر',
    '589210' => 'بانک سپه',
    '589463' => ' بانک رفاه کارگران',
    '603769' => 'بانک صادرات ایران',
    '603770' => 'بانک کشاورزی',
    '603799' => 'بانک ملی ایران',
    '606373' => 'بانک قرض الحسنه مهر ایران',
    '610433' => 'بانک ملت',
    '621986' => 'بانک سامان',
    '622106' => 'بانک پارسیان',
    '627353' => 'بانک تجارت',
    '627381' => 'بانک انصار',
    '627412' => 'بانک اقتصاد نوین',
    '627488' => 'بانک کارآفرین',
    '627648' => 'بانک توسعه صادرات ایران',
    '627760' => 'پست بانک ایران',
    '627884' => 'بانک پارسیان',
    '627961' => 'بانک صنعت و معدن',
    '628023' => 'بانک مسکن',
    '628157' => 'موسسه اعتباری توسعه',
    '636214' => 'بانک تات',
    '636795' => 'بانک مرکزی',
    '636949' => 'بانک حکمت ایرانیان',
    '639194' => 'بانک پارسیان',
    '639217' => 'بانک کشاورزی',
    '639346' => 'بانک سینا',
    '639347' => 'بانک پاسارگاد',
    '639370' => 'بانک مهر اقتصاد',
    '639599' => 'بانک قوامین',
    '639607' => 'بانک سرمایه',
    '991975' => 'بانک ملت
'
];

const BANKS_IBAN_CODES = [
    '010' => 'بانک مرکزی جمهوری اسلامی ایران',
    '011' => 'بانک صنعت و معدن',
    '012' => 'بانک ملت',
    '013' => 'بانک رفاه',
    '014' => 'بانک مسکن',
    '015' => 'بانک سپه',
    '016' => 'بانک کشاورزی',
    '017' => 'بانک ملی ایران',
    '018' => 'بانک تجارت',
    '019' => 'بانک صادرات ایران',
    '020' => 'بانک توسعه صادرات',
    '021' => 'پست بانک ایران',
    '022' => 'بانک توسعه تعاون',
    '051' => 'موسسه اعتباری توسعه',
    '053' => 'بانک کارآفرین',
    '054' => 'بانک پارسیان',
    '055' => 'بانک اقتصاد نوین',
    '056' => 'بانک سامان',
    '057' => 'بانک پاسارگاد',
    '058' => 'بانک سرمایه',
    '059' => 'بانک سینا',
    '060' => 'قرض الحسنه مهر',
    '061' => 'بانک شهر',
    '062' => 'بانک تات',
    '063' => 'بانک انصار',
    '064' => 'بانک گردشگری',
    '065' => 'بانک حکمت ایرانیان',
    '066' => 'بانک دی',
    '069' => 'بانک ایران زمین'
];

class BankService extends Controller
{
    /**
     * Returns bank name of given card number
     *
     * @param  int  $cardNumber
     * @return null|string
     */
    public static function findBankNameByCard(int $cardNumber): string|null
    {
        return BANKS_CARD_CODES[substr($cardNumber, 0, 6)] ?? null;
    }

    /**
     * Returns bank name of given IBAN number
     *
     * @param  string  $ibanNumber
     * @return null|string
     */
    public static function findBankNameByIban(string $ibanNumber): string|null
    {
        return BANKS_IBAN_CODES[substr(preg_replace('/\D/', '', $ibanNumber), 2, 3)] ?? null;
    }

    public static function getShebaShepa(int $cardNumber): array
    {
        $response = Http::asJson()->acceptJson()->withHeaders([
            'authorization' => config('services.jibit-token'),
        ])->asForm()->post('https://shepa.com/wp-admin/admin-ajax.php', [
            'action' => 'ira_iban_action',
            'cardnumber_or_accound' => $cardNumber,
            'bank_code' => ''
        ]);

        return $response->json();
    }

    public static function getShebaJibit(int $cardNumber): array
    {
        $response = Http::asJson()->acceptJson()->withHeaders([
            'authorization' => config('inquiry.jibit.token'),
        ])->get("https://napi.jibit.ir/merchant/v1/cards/{$cardNumber}/iban");

        return $response->json();
    }

    public static function getShebaEhraz(int $cardNumber): array
    {
        $response = Http::asJson()->acceptJson()->withHeaders([
        'Authorization' => "Token ". env('EHRAZIO_TOKEN'),
    ])->post(env('ehrazio_url')."/convert/card-to-iban", ['number' => $cardNumber]);

        return $response->json();
    }

}
