<?php

namespace App\Models\Repositories;

use App\Models\Entities\Price;

class PriceRepository
{
    public $priceModel;

    public function __construct(Price $price)
    {
        $this->priceModel = $price;
    }
}