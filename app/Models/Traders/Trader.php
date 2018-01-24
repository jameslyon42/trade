<?php

namespace App\Models\Traders;
use App\Models\Repositories\PositionRepository;
use App\Models\Repositories\PriceRepository;
use App\Models\Repositories\PortfolioRepository;

class Trader
{

    public $priceRepository;
    public $positionRepository;
    public $portfolioRepository;

    public function __construct(
        PriceRepository $price_repository,
        PositionRepository $position_repository,
        PortfolioRepository $portfolio_repository
    )
    {
        $this->priceRepository = $price_repository;
        $this->positionRepository = $position_repository;
        $this->portfolioRepository = $portfolio_repository;
    }

}