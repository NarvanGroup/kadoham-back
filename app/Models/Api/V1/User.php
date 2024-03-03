<?php

namespace App\Models\Api\V1;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\AuthenticationEnum;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Traits\HasWallets;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Wallet, WalletFloat
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, HasWalletFloat, HasRoles, HasWallets,HasWallet;

    protected $guard_name = 'web';

    protected static function boot()
    {
        parent::boot();

        static::created(static function (self $user) {
            $user->assignRole(Role::findByName('User'));
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'email',
        'mobile',
        'gender',
        'dob',
        'nid',
        'password',
        'image',
        'otp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'otp',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function authentications(): HasMany
    {
        return $this->hasMany(Authentication::class);
    }

    /**
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return HasMany
     */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function socialMedia(): HasMany
    {
        return $this->hasMany(SocialMedia::class);
    }

    /**
     * @return HasMany
     */
    public function wishList(): HasMany
    {
        return $this->hasMany(WishList::class);
    }

    /**
     * @return HasMany
     */
    public function item(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * @return bool
     */
    public function hasPendingAuthentication(): bool
    {
        return $this->hasOne(Authentication::class)->where('status', AuthenticationEnum::PENDING)->exists();
    }

    /**
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return $this->hasOne(Authentication::class)->where('status', AuthenticationEnum::ACTIVE)->exists();
    }

    public function authenticationStatus(): string
    {
        if ($this->hasPendingAuthentication()) {
            return AuthenticationEnum::PENDING->value;
        }

        if ($this->isAuthenticated()) {
            return AuthenticationEnum::ACTIVE->value;
        }

        return AuthenticationEnum::INACTIVE->value;
    }

    /**
     * Get the user's first name.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->first_name . ' ' . $this->last_name,
        );
    }
}
