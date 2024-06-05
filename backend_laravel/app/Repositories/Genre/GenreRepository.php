<?php
namespace App\Repositories\Genre;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class GenreRepository extends BaseRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {
        
        return \App\Models\Genre::class;
    }

    public function search(string $keyword): Collection
    {
        return $this->_model->where('title', 'like', '%' . $keyword . '%')
                           ->orWhere('slug', 'like', '%' . $keyword . '%')
                           ->orWhere('description', 'like', '%' . $keyword . '%')
                           ->orWhere('status', 'like', '%' . $keyword . '%')
                           ->get();
    }
    
}
