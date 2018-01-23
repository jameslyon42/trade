<?php

namespace App\Models\Repositories;

use App\Models\Entities\Security;
use DateTime;
use Illuminate\Support\Facades\DB;

class SecurityRepository
{
    public $securityModel;

    public function __construct(Security $security)
    {
        $this->securityModel = $security;
    }

    public function getById(int $security_id)
    {
        $security = $this->securityModel->find($security_id);

        return $security->toArray();
    }

    public function search($search_text)
    {
        $securities = $this->securityModel->where('symbol','like', "%$search_text%")
            ->orWhere('name', 'like', "%$search_text%")
            ->orderBy('symbol', 'asc')
            ->limit(10)
            ->get();

        return $securities->toArray();
    }

    public function historyGraph(int $security_id, array $average_durations)
    {
        $security = $this->securityModel->with(['prices' => function ($query) use ($average_durations) {
            $columns = ['*'];

            foreach ($average_durations as $duration) {
                $columns[] = DB::raw(
                    <<<SQL
                        (SELECT AVG(close) 
                        FROM prices p 
                        WHERE prices.security_id = p.security_id
                        AND p.timestamp BETWEEN DATE_SUB(prices.timestamp, INTERVAL $duration DAY) AND prices.timestamp) AS avg_{$duration}_day
SQL
                );
            }

            $last_year = new DateTime('last year');
            $query->select($columns)->where('timestamp', '>', $last_year);
        }])->find($security_id);

        return $security->toArray();
    }
}