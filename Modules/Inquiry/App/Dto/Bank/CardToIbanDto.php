<?php

namespace Modules\Inquiry\App\Dto\Bank;

class CardToIbanDto
{
    public string $iban;
    public string $accountNumber;
    public string $bankName;
    public array $owners;

    public function __construct(array $data)
    {
        $this->iban = $data['iban'];
        $this->accountNumber = $data['accountNumber'];
        $this->bankName = $data['bankName'];
        $this->owners = $data['owners'];
    }
}