<?php

namespace App\Policies\Api\V1;

use App\Models\User;
use Cache;
use Illuminate\Database\Eloquent\Model;

class ResourcePolicy
{

    private mixed $user;

    public function __construct()
    {
        $this->user = Cache::get(request()->bearerToken())['user'];
    }

    /**
     * Perform pre-authorization checks.
     */
    /*    public function before(User $user, string $ability): bool|null
        {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }

            return null;
        }*/

    /**
     * Determine whether the user can delete the resource.
     *
     * @param  User|null  $user
     * @param  Model  $resource
     * @return bool
     */
    public function show(User|null $user, Model $resource)
    {
        return $this->user['mobile'] === $resource->user_id;
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param  User|null  $user
     * @param  Model  $resource
     * @return bool
     */
    public function update(User|null $user, Model $resource)
    {
        return $this->user['mobile'] === $resource->user_id;
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param  User|null  $user
     * @param  Model  $resource
     * @return bool
     */
    public function destroy(User|null $user, Model $resource)
    {
        return $this->user['mobile'] === $resource->user_id;
    }
}
