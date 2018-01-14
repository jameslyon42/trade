<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Security;
use DateTime;
use Illuminate\Support\Facades\DB;

class SecurityController extends Controller
{
    public function search(Request $request) {

        $search_text = $request->search_text;

        if ($search_text) {
            $securities = Security::where('symbol','like', "%$search_text%")
                ->orWhere('name', 'like', "%$search_text%")
                ->orderBy('symbol', 'asc')
                ->limit(10)
                ->get();

            return $securities->toJson();
        }
    }

    public function show($id) {
        $average_durations = [10, 30];

        $security = Security::with(['prices' => function ($query) use ($average_durations) {
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
        }])->find($id);


        return json_encode([
            'data' => $security,
            'average_durations' => $average_durations
        ]);
    }
}
