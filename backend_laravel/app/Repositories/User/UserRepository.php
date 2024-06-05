<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        
        return \App\Models\User::class;
    }

    public function search(string $keyword): Collection
    {

        return $this->_model->where('user_code', 'like', '%' . $keyword . '%')
                            ->orWhere('name', 'like', '%' . $keyword . '%')
                            ->orWhere('email', 'like', '%' . $keyword . '%')
                            ->orWhere('address', 'like', '%' . $keyword . '%')
                            ->orWhere('tel', 'like', '%' . $keyword . '%')
                            ->orWhere('birthday', 'like', '%' . $keyword . '%')
                            ->orWhere('gender', 'like', '%' . $keyword . '%')
                            ->orWhere('role_id', 'like', '%' . $keyword . '%')
                            ->get();
    }
}
