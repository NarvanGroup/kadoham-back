<?php

namespace App\Services\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Product;
use App\Models\Api\V1\User;
use App\Traits\Api\V1\ResponderTrait;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Support\Collection;
use RuntimeException;

class WalletService extends Controller
{
    use ResponderTrait;

    protected readonly User $user;

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    private function checkUserDefined(): void
    {
        if (!isset($this->user)) {
            throw new RuntimeException('User is not defined.');
        }
    }

    public function getWallets(): Collection
    {
        $this->checkUserDefined();
        return $this->user->wallets;
    }

    public function getTransactions(string|null $wallet = 'default')
    {
        $this->checkUserDefined();
        return $this->firstOrCreateWallet($wallet)->walletTransactions;
    }

    public function deposit(string|int|float $amount, string|null $wallet = 'default', array $meta = []): void
    {
        $this->checkUserDefined();
        if (str_starts_with($wallet, 'IRG')) {
            $this->firstOrCreateWallet($wallet)->depositFloat($amount, $meta);
        } else {
            $this->firstOrCreateWallet($wallet)->deposit($amount, $meta);
        }
    }

    public function withdraw(string|int|float $amount, string|null $wallet = 'default', array $meta = []): void
    {
        $this->checkUserDefined();
        if (str_starts_with($wallet, 'IRG')) {
            $this->firstOrCreateWallet($wallet)->withdrawFloat($amount, $meta);
        } else {
            $this->firstOrCreateWallet($wallet)->withdraw($amount, $meta);
        }
    }

    public function balance(string|null $wallet = 'default'): int|float
    {
        $this->checkUserDefined();
        if (str_starts_with($wallet, 'IRG')) {
            return $this->firstOrCreateWallet($wallet)->balanceFloat;
        }

        return $this->firstOrCreateWallet($wallet)->balance;
    }

    public function firstOrCreateWallet(string $wallet): Wallet
    {
        $this->checkUserDefined();
        return $this->user->wallets()->firstOrCreate(
            ['slug' => $wallet],
            [
                'name' => Product::where('slug', $wallet)->select('title')->first() ?? $wallet,
                'decimal_places' => 8
            ]
        );
    }
}
