<?php

namespace App\Models\Repositories;

use App\Models\Entities\Position;
use DateTime;

class PositionRepository
{
    public $positionModel;

    public function __construct(Position $position)
    {
        $this->positionModel = $position;
    }

    public function getPositionsForSecurity(int $portfolio_id, int $security_id) {
        $positions = $this->positionModel
            ->where([
                ['portfolio_id', $portfolio_id],
                ['security_id', $security_id]
            ])
            ->orderBy('entry_timestamp', 'asc')
            ->get();

        return $positions ? $positions->toArray() : false;
    }
}