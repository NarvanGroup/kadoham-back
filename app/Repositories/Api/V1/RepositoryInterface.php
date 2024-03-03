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
     * @param  string  $id
     * @return null|Model
     */
    public function find(string $id): Model|null;

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
     * @param  string  $id
     * @return bool
     */
    public function update(array $data, string $id): bool;

    /**
     * Delete given user instance
     *
     * @param  string  $id
     * @return bool
     */
    public function delete(string $id): bool;
}
