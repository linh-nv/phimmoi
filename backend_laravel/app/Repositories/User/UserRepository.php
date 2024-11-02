<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\User::class;
    }

    public function findByEmail(string $email): ?Model
    {

        return $this->_model->where('email', $email)->first();
    }
}
