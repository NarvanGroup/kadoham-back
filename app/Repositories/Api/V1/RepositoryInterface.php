<?php

namespace App\Repositories\Api\V1;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * Returns all users
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Returns specific user by given id
     *
     * @param  int  $id
     * @return null|Model
     */
    public function find(int $id): Model|null;

    /**
     * Creates a new instance of user with given data
     *
     * @param  array  $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Updates a given user with given data
     *
     * @param  array  $data
     * @param  int    $id
     * @return bool
     */
    public function update(array $data, int $id): bool;

    /**
     * Delete given user instance
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool;
}
