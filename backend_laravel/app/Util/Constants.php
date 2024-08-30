<?php

namespace App\Util;

/**
 * Class Constants
 * @package App\Util
 */
class Constants
{
    /** @var int PER_PAGE */
    public const PER_PAGE = 5;
    public const CLIENT_PAGE = 20;

    /** @var string URL_API_PROVINCE */
    public const URL_API_PROVINCE = 'https://vapi.vnappmob.com/api/province/';

    /** @var string URL_API_DISTRICT/{province_id} */
    public const URL_API_DISTRICT = 'https://vapi.vnappmob.com/api/province/district/';

    /** @var string URL_API_WARD/{ward_id} */
    public const URL_API_WARD = 'https://vapi.vnappmob.com/api/province/ward/';

    /** @var string API_CRAWL_MOVIES/{page} */
    public const API_CRAWL_MOVIES = 'https://phimapi.com/danh-sach/phim-moi-cap-nhat?page=';

    /** @var string API_CRAWL_DETAILS_MOVIE/{slug} */
    public const API_CRAWL_DETAILS_MOVIE = 'https://phimapi.com/phim/';
}
