<?php

namespace App\Models\Services;

use App;
use DateTime;
use App\Models\Repositories\SecurityRepository;
use App\Models\Repositories\PriceRepository;
use App\Models\Repositories\PortfolioRepository;
use Money\Money;

class BacktestService
{
    public $securityRepository;
    public $priceRepository;
    public $portfolioRepository;

    public function __construct(
        SecurityRepository $security_repository,
        PriceRepository $price_repository,
        PortfolioRepository $portfolio_repository
    )
    {
        $this->securityRepository   = $security_repository;
        $this->priceRepository      = $price_repository;
        $this->portfolioRepository  = $portfolio_repository;
    }

    public function run(int $security_id, string $trader_name, $user_id)
    {
        $portfolio = $this->portfolioRepository->createBacktestPortfolio($user_id);

        $trader = App::make("\App\Models\Traders\\$trader_name");

        $start_date = new DateTime('-1 year midnight');

        $prices = $this->priceRepository->getPriceHistory($security_id, $start_date);

        foreach ($prices as $price) {
            $trader->handle(
                $security_id,
                $portfolio['id'],
                Money::USD(floor($price['close'] * 100)),
                new DateTime($price['timestamp'])
            );
        }
    }
}