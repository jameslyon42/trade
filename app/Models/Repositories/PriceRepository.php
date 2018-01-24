<?php

namespace App\Models\Repositories;

use DateTime;
use App\Models\Entities\Price;

class PriceRepository
{
    public $priceModel;

    public function __construct(Price $price)
    {
        $this->priceModel = $price;
    }

    /**
     * Gets price history for security from a given date to current
     *
     * @param int $security_id
     * @param Datetime $from_date
     *
     * @return Mixed
     */
    public function getPriceHistory(int $security_id, Datetime $from_date) {
        $prices = $this->priceModel
            ->where([
                ['security_id',$security_id],
                ['timestamp', '>=', $from_date]
            ])
            ->orderBy('timestamp', 'asc')
            ->get();

        return $prices ?$prices->toArray() : false;
    }
}