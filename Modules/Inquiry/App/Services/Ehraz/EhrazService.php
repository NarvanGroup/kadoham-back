<?php

namespace Modules\Inquiry\App\Services\Ehraz;

use Illuminate\Support\Facades\Http;
use Modules\Inquiry\App\Dto\Bank\CardToIbanDto;

class EhrazService
{
    private string $apiUrl;
    private string $apiToken;

    public function __construct()
    {
        $this->apiUrl = config('inquiry.ehrazio.url');
        $this->apiToken = config('inquiry.ehrazio.token');
    }

    private function sendRequest(string $endpoint, array|null $data, string $method = 'post')
    {
        return Http::asJson()->acceptJson()->withHeaders([
            'Authorization' => "Token {$this->apiToken}",
        ])->$method("{$this->apiUrl}/{$endpoint}", $data)->json();
    }

    public function convertDepositNumberToIban($bank, $number)
    {
        return $this->sendRequest('convert/deposit-number-to-iban', compact('bank', 'number'));
    }

    public function getIbanInfo($value)
    {
        return $this->sendRequest('info/iban-info', compact('value'));
    }

    public function getCardInfo($number)
    {
        return $this->sendRequest('info/card-info', compact('number'));
    }

    public function convertCardToDepositNumber($number)
    {
        return $this->sendRequest('convert/card-to-deposit-number', compact('number'));
    }

    public function convertCardToIban($number)
    {
        $data = $this->sendRequest('convert/card-to-iban', compact('number'));

        return new CardToIbanDto([
            'iban'          => $data['ibanInfo']['iban'],
            'accountNumber' => $data['ibanInfo']['depositNumber'],
            'bankName'      => $data['ibanInfo']['bank'],
            'owners'        => array_map(static fn($owner) => $owner['firstName'].' '.$owner['lastName'], $data['ibanInfo']['owners'])
        ]);
    }

    public function matchIbanWithNational($iban, $nationalCode, $birthDate)
    {
        return $this->sendRequest('match/iban-with-national', compact('iban', 'nationalCode', 'birthDate'));
    }

    public function matchIbanWithName($iban, $name)
    {
        return $this->sendRequest('match/iban-with-name', compact('iban', 'name'));
    }

    public function matchCardWithName($cardNumber, $name)
    {
        return $this->sendRequest('match/card-with-name', compact('cardNumber', 'name'));
    }

    public function matchDepositNumberWithName($bank, $depositNumber, $name)
    {
        return $this->sendRequest('match/deposit-number-with-name', compact('bank', 'depositNumber', 'name'));
    }

    public function matchCardWithNational($cardNumber, $nationalCode, $birthDate)
    {
        return $this->sendRequest('match/card-with-national', compact('cardNumber', 'nationalCode', 'birthDate'));
    }

    public function matchNationalWithMobile($nationalCode, $mobileNumber)
    {
        return $this->sendRequest('match/national-with-mobile', compact('nationalCode', 'mobileNumber'));
    }

    public function getAddressInfo($code)
    {
        return $this->sendRequest('info/address-info', compact('code'));
    }

    public function getIdentityInfo($nationalCode, $birthDate)
    {
        return $this->sendRequest('info/identity-info', compact('nationalCode', 'birthDate'));
    }

    public function getIdentitySimilarity(array $data)
    {
        return $this->sendRequest('info/identity-similarity', $data);
    }
}
