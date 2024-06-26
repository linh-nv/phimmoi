<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function getAll(): Collection;

    public function find(Model $model): Model;

    public function create(array $attributes): Model;

    public function update(Model $model, array $attributes): Model;
    
    public function delete(Model $model): bool;

    public function destroy(array $ids): bool;
    
    public function search(array $searchFields, string $keyword): LengthAwarePaginator;
}
