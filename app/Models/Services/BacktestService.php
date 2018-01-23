<?php

namespace App\Models\Services;

use App;
use DateTime;
use App\Models\Repositories\SecurityRepository;
use App\Models\Repositories\PriceRepository;

class BacktestService
{
    public $securityRepository;
    public $priceRepository;

    public function __construct(SecurityRepository $security_repository, PriceRepository $price_repository)
    {
        $this->securityRepository   = $security_repository;
        $this->priceRepository      = $price_repository;
    }

    public function run(int $security_id, string $trader_name)
    {
        $trader = App::make("\App\Models\Traders\\$trader_name");

        $start_date = new DateTime('-1 year');





    }
}