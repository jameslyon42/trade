<?php

namespace App\Models\Traders;

use DateTime;

class MeanTrader extends Trader
{
    public function handle(
        int $security_id,
        int $portfolio_id,
        $price,
        DateTime $timestamp
    )
    {
        $positions = $this->positionRepository->getPositionsForSecurity($portfolio_id, $security_id);

        dd($positions);
    }
}