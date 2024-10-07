<?php

namespace Modules\Inquiry\App\Services\Shepa;

use Illuminate\Support\Facades\Http;
use Modules\Inquiry\App\Dto\Bank\CardToIbanDto;

class ShepaService
{

    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('inquiry.shepa.url');
    }

    private function sendRequest(string $endpoint, array|null $data, string $method = 'post')
    {
        return Http::asJson()->acceptJson()->asForm()->$method("{$this->apiUrl}/{$endpoint}", $data)->json();
    }

    public function convertCardToIban($number)
    {
        $data = $this->sendRequest('wp-admin/admin-ajax.php', [
            'action'                => 'ira_iban_action',
            'cardnumber_or_accound' => $number,
            'bank_code'             => ''
        ]);

        return new CardToIbanDto([
            'iban'          => $data['result']['iban_number'],
            'accountNumber' => $data['result']['deposits'],
            'bankName'      => $data['result']['Bank-Id'],
            'owners'        => [$data['result']['first_name'].' '.$data['result']['last_name']]
        ]);
    }
}
