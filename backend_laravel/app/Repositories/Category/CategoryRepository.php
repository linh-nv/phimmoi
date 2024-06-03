<?php
namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class CategoryRepository extends BaseRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {
        
        return \App\Models\Category::class;
    }

    public function search(string $keyword): Collection
    {
        return $this->_model->where('name', 'like', '%' . $keyword . '%')
                           ->orWhere('description', 'like', '%' . $keyword . '%')
                           ->get();
    }
    
}
