<?php

namespace Modules\Inquiry\App\Services\Jibit;

use Illuminate\Support\Facades\Http;
use Modules\Inquiry\App\Dto\Bank\CardToIbanDto;

class JibitService
{
    private string $apiUrl;
    private string $apiToken;

    public function __construct()
    {
        $this->apiUrl = config('inquiry.jibit.url');
        $this->apiToken = config('inquiry.jibit.token');
    }

    private function sendRequest(string $endpoint, array|null $data, string $method = 'post')
    {
        return Http::asJson()->acceptJson()->withHeaders([
            'authorization' => $this->apiToken,
        ])->$method("{$this->apiUrl}/{$endpoint}", $data)->json();
    }


    public function convertCardToIban($number)
    {
        $data = $this->sendRequest("cards/{$number}/iban", null, 'get');

        return new CardToIbanDto([
            'iban'          => $data['iban'],
            'accountNumber' => $data['accountNumber'],
            'bankName'      => $data['bankName'],
            'owners'        => $data['owners']
        ]);
    }
}
