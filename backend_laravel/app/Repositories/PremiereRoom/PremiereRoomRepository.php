<?php

namespace App\Repositories\PremiereRoom;

use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PremiereRoomRepository extends BaseRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\PremiereRoom::class;
    }
}
