<?php

namespace Modules\Payment\App\Service;

use App\Models\Api\V1\User;
use Illuminate\Http\Request;
use Modules\Payment\App\Enums\Novinpal\IpgStatusEnum;
use Modules\Payment\App\Merchants\Novinpal;
use Modules\Payment\App\Models\IpgTransaction;

class PaymentService
{
    private Novinpal $terminal;


    public function __construct()
    {
        $this->terminal = new Novinpal();
    }

    public function pay(User $user, int $amount, string $orderId, string $mobile, string $cardNumber, $description = null)
    {
        $refIdResponse = $this->terminal->request($amount, $orderId, $mobile, $cardNumber, $description);

        if (!isset($refIdResponse['refId'])) {
            dd(json_encode($refIdResponse, JSON_THROW_ON_ERROR));
        }

        $refId = $refIdResponse['refId'];

        IpgTransaction::create([
            'id' => uuid_create(),
            'user_id'     => $user->id,
            'amount'      => $amount,
            'order_id'    => $orderId,
            'ref_id'      => $refId,
            'mobile'      => $mobile,
            'card_number' => $cardNumber,
            'ip'          => \request()->ip(),
            'description' => $description,
        ]);


        return $this->terminal->start($refId);
    }

    public function verify(string $refId)
    {
        $transaction = IpgTransaction::where('ref_id', $refId)->where('status', IpgStatusEnum::TRANSACTION_INIT)->firstOrFail();
        $verifyTransaction = $this->terminal->verify($refId);

        if (isset($verifyTransaction['status']) && $verifyTransaction['status'] === 1) {
            $transaction->update([
                'status'     => IpgStatusEnum::TRANSACTION_SUCCEED,
                'paid_at'    => $verifyTransaction['paidAt'],
                'ref_number' => $verifyTransaction['refNumber'],
            ]);
        } else {
            $transaction->update([
                'status'            => IpgStatusEnum::TRANSACTION_FAILED,
                'failed_at'         => now(),
                'error_code'        => $verifyTransaction['errorCode'],
                'error_description' => $verifyTransaction['errorDescription'],
            ]);
        }
    }

}