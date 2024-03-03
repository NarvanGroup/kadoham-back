<?php

namespace App\Repositories\Api\V1;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Repository implements RepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    /**
     * Returns all model records
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Returns specific model by given id
     *
     * @param string $id
     * @return null|Model
     */
    public function find(string $id): Model|null
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * Returns specific model by given id
     *
     * @param $column
     * @param null $operator
     * @param null $value
     * @return Collection|Builder[]
     */
    public function where($column, $operator = null, $value = null)
    {
        return $this->model->where($column, $operator, $value);
    }

    /**
     * Creates a new instance of model with given data
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->query()->create($data);
    }

    /**
     * Updates a given model with given data
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function update(array $data, string $id): bool
    {
        return $this->model->query()->findOrFail($id)?->update($data);
    }

    /**
     * Delete given model instance
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->model->query()->findOrFail($id)?->delete();
    }

    /**
     * Paginates resource items and returns a list
     *
     * @return LengthAwarePaginator
     */
    public function paginate(): LengthAwarePaginator
    {
        return $this->model->paginate();
    }

    /**
     * Returns the given model instance with relations
     *
     * @param Model $model
     * @param array $relations
     * @return Model
     */
    public function load(Model $model, array $relations): Model
    {
        return $model->load($relations);
    }

    /**
     * Paginate or list all records based on request
     *
     * @param Builder $builder
     * @return LengthAwarePaginator
     */
    public function paginateOrList(Builder $builder): LengthAwarePaginator
    {
        if (request('paginate') === 'true') {
            return $builder->paginate()->appends(['paginate' => true]);
        }

        return $builder->get();
    }

    /**
     * Filter query builder, where model has relation with values in based request
     *
     * @param Builder $builder
     * @param string $relation
     * @return Builder
     */
    // @todo remove this method if its not necessary
    public function filterRelation(Builder $builder, string $relation): Builder
    {
        $column = Str::singular($relation) . '_id';

        if (!request($column)) {
            return $builder;
        }

        return $builder->whereHas(
            $relation,
            static fn (Builder $builder) => $builder->where($column, request($column))
        );
    }

    /**
     * find and return model by id
     * @param string $id
     * @param array $columns
     * @param array $relations
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findById(string $id, array $columns = ['*'], array $relations = []): Model
    {
        return $this->findByCriteria(compact('id'), $columns, $relations);
    }

    /**
     * find and return model by criteria
     * @param array $criteria
     * @param array $columns
     * @param array $relations
     * @return Model|null
     */
    public function findByCriteria(array $criteria, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->newQuery()->select($columns)->with($relations)->where($criteria)->first();
    }

    /**
     * return query builder for using in criteria
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Get the last record in database
     *
     * @return Model|null
     */
    public function getLatest(): Model|null
    {
        return $this->model->latest()->first();
    }

    /**
     * Update with where clause.
     *
     * @param string $parameter
     * @param string $operator
     * @param $equal
     * @param array $values
     * @return int
     */
    public function updateWhere(string $parameter, string $operator, $equal, array $values): int
    {
        return $this->newQuery()->where($parameter, $operator, $equal)->update($values);
    }


    /**
     * Sync the given resource to given contact.
     *
     * @todo change the method name. in Eloquent sync() is used only for many-to-many relations.
     *
     * @param Model $model
     * @param string $relation
     * @param array $data
     * @return void
     * @throws InvalidArgumentException
     */
    public function syncRelation(Model $model, string $relation, array $data): void
    {
        if (!method_exists($model, $relation)) {
            throw new InvalidArgumentException('Relation not found');
        }

        $model->$relation()->delete();
        $model->$relation()->createMany($data);
    }

    /**
     * Sync the given resource to given contact.
     *
     * @param Model $model
     * @param string $relation
     * @param array $data
     * @return void
     * @throws InvalidArgumentException
     */
    public function syncManyToManyRelation(Model $model, string $relation, array $data): void
    {
        if (!method_exists($model, $relation)) {
            throw new InvalidArgumentException('Relation not found');
        }

        $model->$relation()->sync($data);
    }
}
