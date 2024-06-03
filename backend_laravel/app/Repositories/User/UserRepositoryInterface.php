<?php
namespace App\Repositories\User;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get 5 Categorys hot in a month the last
     * @return mixed
     */
    public function search(string $keyword): Collection;
}
