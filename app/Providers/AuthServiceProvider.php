<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Item;
use App\Models\WishList;
use App\Policies\Api\V1\ResourcePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        WishList::class => ResourcePolicy::class,
        Item::class => ResourcePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
