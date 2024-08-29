<?php

namespace App\Pipeline\CrawlMovies\Tasks;

use App\Repositories\Category\CategoryRepository;
use App\Models\Category;
use App\Util\CategoryDataTemplate;

class DetermineCategory
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(array $movieDetails): ?Category
    {
        if (strtolower($movieDetails['episode_current']) == 'full') {

            return $this->categoryRepository->where('slug', CategoryDataTemplate::PHIMLE_SLUG);
        } elseif ($movieDetails['chieurap']) {

            return $this->categoryRepository->where('slug', CategoryDataTemplate::PHIMCHIEURAP_SLUG);
        } else {

            return $this->categoryRepository->where('slug', CategoryDataTemplate::PHIMBO_SLUG);
        }

        return $this->categoryRepository->where('slug', CategoryDataTemplate::PHIMMOI_SLUG); 
    }
}
