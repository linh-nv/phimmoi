<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\RepositoryInterface;
use App\Util\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $_model;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Get model
     * @return string
     */
    abstract public function getModel(): string;

    /**
     * Set model
     */
    public function setModel(): void
    {
        $this->_model = app()->make($this->getModel());
    }

    /**
     * Get All
     * @return Collection|static[]
     */
    public function getAll(): Collection
    {

        return $this->_model->latest('updated_at')->get();
    }

    /**
     * Get one
     * @param Model $model
     * @return Model
     */
    public function find($modelOrId): Model
    {
        $model = $this->_model->findOrFail($modelOrId instanceof Model ? $modelOrId->id : $modelOrId);

        return $model;
    }

    public function findByIds(array $ids): Collection
    {

        return $this->_model->whereIn('id', $ids)->get();
    }

    public function findBySlug(string $slug): Model
    {

        return $this->_model->where('slug', $slug)->firstOrFail();
    }
    /**
     * Create
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {

        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param Model $model
     * @param array $attributes
     * @return Model
     */
    public function update(Model $model, array $attributes): Model
    {
        $model->update($attributes);

        return $model;
    }

    public function updateOrCreate(array $conditions, array $value): Model
    {

        return $this->_model->updateOrCreate($conditions, $value);
    }
    /**
     * Delete
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        $model->delete();

        return true;
    }

    public function destroy(array $ids): bool
    {
        $this->_model->destroy($ids);

        return true;
    }
    /**
     * Get All with Pagination
     * @return LengthAwarePaginator
     */
    public function getPaginate(): LengthAwarePaginator
    {

        return $this->_model->latest('updated_at')->paginate(Constants::PER_PAGE);
    }

    public function search(array $searchFields, string $keyword): LengthAwarePaginator
    {

        return $this->_model->whereAny($searchFields, 'like', '%' . $keyword . '%')
            ->paginate(Constants::PER_PAGE);
    }

    public function insert(array $data): bool
    {

        return $this->_model->insert($data);
    }

    public function upsert(array $data, array $uniqueBy, array $update): int
    {

        return $this->_model->upsert($data, $uniqueBy, $update);
    }

    public function firstOrCreate(array $attributes, array $values = []): ?Model
    {

        return $this->_model->firstOrCreate($attributes, $values);
    }

    public function insertOrRemove(array $conditions, array $attributes): ?Model
    {
        try {
            $entity = $this->_model->where($conditions)->first();

            $entity->delete();
            return null;
        } catch (\Throwable $th) {

            return $this->_model->create($attributes);
        }
    }
}
