<?php
namespace App\Util;

/**
 * Class Constants
 * @package App\Util
 */
class Constains
{
    /** @var int PER_PAGE */
    public const PER_PAGE = 5;

    /** @var string URL_API_PROVINCE */
    public const URL_API_PROVINCE = 'https://vapi.vnappmob.com/api/province/';

    /** @var string URL_API_DISTRICT/{province_id} */
    public const URL_API_DISTRICT = 'https://vapi.vnappmob.com/api/province/district/';
    
    /** @var string URL_API_WARD/{ward_id} */
    public const URL_API_WARD = 'https://vapi.vnappmob.com/api/province/ward/';
}
