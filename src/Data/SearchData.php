<?php

namespace App\Data;

use App\Entity\Category;
use App\Entity\Property;

class SearchData
{

    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Category
     */
    public $categories;

    /**
     * @var null|string
     */
    public $type;

    /**
     * @var null|string
     */
    public $country;

    /**
     * @var null|integer
     */
    public $pricemax;

    /**
     * @var null|integer
     */
    public $pricemin;

    /**
     * @var null|integer
     */
    public $surfacemax;

    /**
     * @var null|integer
     */
    public $surfacemin;
}
