<?php

namespace Modules\Payment\App\Merchants;

use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Http;

class Novinpal
{
    private string $merchantCode;
    private string $returnUrl;
    const BASE_URL = 'https://api.novinpal.ir/';

    public function __construct()
    {
        $this->merchantCode = env('NOVINPAL_MERCHANT_CODE');
        $this->returnUrl = env('APP_URL').'/'.env('NOVINPAL_RETURN_URL');
    }

    /**
     * Request a payment invoice.
     *
     * @param  int  $amount
     * @param  string|int  $orderId
     * @param $mobile
     * @param $cardNumber
     * @param  string  $description
     * @return array
     */
    public function request(int $amount, $orderId, $mobile, $cardNumber, string $description = '')
    {
        return $this->post('invoice/request', [
            'api_key'     => $this->merchantCode,
            'amount'      => $amount,
            'return_url'  => $this->returnUrl,
            'order_id'    => $orderId,
            'description' => $description,
            "mobile"      => $mobile,
            "card_number" => $cardNumber
        ]);
    }

    /**
     * Verify the payment.
     *
     * @param  string  $refId
     * @return array
     */
    public function verify(string $refId)
    {
        return $this->post('invoice/verify', [
            'api_key' => $this->merchantCode,
            'ref_id'  => $refId,
        ]);
    }

    /**
     * Start the payment process.
     *
     * @param  string  $refId
     * @return \Illuminate\Contracts\Foundation\Application|Application|RedirectResponse|Redirector
     */
    public function start(string $refId)
    {
        return redirect(self::BASE_URL.'invoice/start/'.$refId);
    }

    /**
     * Send a POST request to the Novinpal API.
     *
     * @param  string  $endpoint
     * @param  array  $data
     * @return array
     */
    public function post(string $endpoint, array $data): array
    {
        try {
            return Http::asJson()->acceptJson()->post(self::BASE_URL.$endpoint, $data)->json();
        } catch (Exception $exception) {
            dd($exception);
        }
    }
}