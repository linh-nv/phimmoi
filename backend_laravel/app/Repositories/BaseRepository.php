<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\Util\Constains;
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
        
        return $this->_model->orderBy('id', 'DESC')->get();
    }

    /**
     * Get one
     * @param Model $model
     * @return Model
     */
    public function find(Model $model): Model
    {

        return $model;
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

        return $this->_model->orderBy('id', 'DESC')->paginate(Constains::PER_PAGE);
    }

    public function search(array $searchFields, string $keyword): LengthAwarePaginator
    {
        
        return $this->_model->whereAny($searchFields, 'like', '%' . $keyword . '%')
            ->paginate(Constains::PER_PAGE);
    }
}
