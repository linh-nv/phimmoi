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
        ];
    }


    public static function setCategoryTemplate(): void
    {
        $categories = CategoryDataTemplate::categoryDataTemplate();

        Category::upsert($categories, ['slug'], ['title']);
    }
}
