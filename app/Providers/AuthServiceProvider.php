<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Api\V1\Address;
use App\Models\Api\V1\Card;
use App\Models\Api\V1\Item;
use App\Models\Api\V1\SocialMedia;
use App\Models\Api\V1\User;
use App\Models\Api\V1\WishList;
use App\Policies\Api\V1\ResourcePolicy;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Address::class => ResourcePolicy::class,
        Card::class => ResourcePolicy::class,
        Wallet::class => ResourcePolicy::class,
        SocialMedia::class => ResourcePolicy::class,
        User::class => ResourcePolicy::class,
        WishList::class => ResourcePolicy::class,
        Item::class => ResourcePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
