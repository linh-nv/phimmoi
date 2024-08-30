<?php

namespace App\Util;

use App\Models\Category;

/**
 * Class CategoryDataTemplate
 * @package App\Util
 */
class CategoryDataTemplate
{
    /** @var string PHIMBO_SLUG */
    public const PHIMBO_SLUG = 'phim-bo';

    /** @var string PHIMLE_SLUG */
    public const PHIMLE_SLUG = 'phim-le';

    /** @var string PHIMCHIEURAP_SLUG */
    public const PHIMCHIEURAP_SLUG = 'phim-rap';

    public static function categoryDataTemplate()
    {

        return [
            [
                'title' => 'Phim bộ',
                'slug' => 'phim-bo'
            ],
            [
                'title' => 'Phim lẻ',
                'slug' => 'phim-le'
            ],
            [
                'title' => 'Phim chiếu rạp',
                'slug' => 'phim-chieu-rap'
            ],
        ];
    }


    public static function setCategoryTemplate(): void
    {
        $categories = CategoryDataTemplate::categoryDataTemplate();

        Category::upsert($categories, ['slug'], ['title']);
    }
}
