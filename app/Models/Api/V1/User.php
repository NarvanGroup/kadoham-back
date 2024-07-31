<?php

namespace App\Models\Api\V1;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\AuthenticationEnum;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Wallet
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, HasRoles, HasWallet, SoftDeletes;

    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'username',
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
        'dob'               => 'date',
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(static function (self $user) {
            $user->assignRole(Role::findByName('User'));
        });
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($query) use ($searchTerm) {
            $query->where('first_name', 'like', "%{$searchTerm}%")
                ->orWhere('last_name', 'like', "%{$searchTerm}%")
                ->orWhere('username', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%")
                ->orWhere('mobile', 'like', "%{$searchTerm}%");
        });
    }

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
    public function wishLists(): HasMany
    {
        return $this->hasMany(WishList::class);
    }

    /**
     * @return HasOne
     */
    public function interests(): HasOne
    {
        return $this->hasOne(Interest::class);
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * @return HasMany
     */
    public function thankYouNotes(): HasMany
    {
        return $this->hasMany(ThankYouNote::class);
    }

    /**
     * @return HasMany
     */
    public function itemBuyer(): HasMany
    {
        return $this->hasMany(ItemBuyer::class);
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

    /**
     * Get the user's first name.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->first_name.' '.$this->last_name,
        );
    }
}
