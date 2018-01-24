<?php

namespace App\Models\Repositories;

use App\Models\Entities\Portfolio;

class PortfolioRepository
{
    public $portfolioModel;

    public function __construct(Portfolio $portfolio)
    {
        $this->portfolioModel = $portfolio;
    }

    /**
     * Creates a new portfolio
     *
     * @param int $user_id
     *
     * @return array
     */
    public function createPortfolio(int $user_id) {
        $portfolio = $this->portfolioModel->create([
            'user_id' => $user_id,
            'backtest' => 0
        ]);

        return $portfolio->toArray();
    }

    /**
     * Creates a new backtest portfolio
     *
     * @param int $user_id
     *
     * @return array
     */
    public function createBacktestPortfolio(int $user_id) {
        $portfolio = $this->portfolioModel->create([
            'user_id' => $user_id,
            'backtest' => 1
        ]);

        return $portfolio->toArray();
    }


}