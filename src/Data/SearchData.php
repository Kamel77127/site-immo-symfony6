<?php

namespace App\Data;


class SearchData
{

    /**
     * @var int
     */
    public $page;

    /**
     * @var region
     */
    public $region;

    /**
     * @var ville[]
     */
    public $ville = [];


    /**
     * @var null/integer
     */
    public $price;

    /**
     * @var Type[]
     */
    public $type= [];
    /**
     * @var null/integer
     */
    public $surface;

    
    /**
     * @var null/integer
     */
    public $piece;

}