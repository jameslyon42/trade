<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PriceHistoryService;
use App\Security;
use Exception;

class ImportDailyPriceHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prices:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import daily price data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $securities = Security::all();

        $securities->each(function ($security) {
            $this->line($security->symbol . ': Getting Data');
            try {
                $price_history = PriceHistoryService::getDailyPriceHistory($security['symbol'], 'compact');
                
                if (!$price_history) {
                    throw new Exception("no data", 1);
                }

                foreach ($price_history as $date => $price) {
                    try {
                        $this->line($security->symbol . ': ' . $date);
                        $security->prices()->create([
                            'interval'  => 'daily',
                            'open'      => $price['1. open'],
                            'high'      => $price['2. high'],
                            'close'     => $price['4. close'],
                            'volume'    => $price['5. volume'],
                            'timestamp' => $date
                        ]);  
                    } catch (Exception $e) {

                    }
                }

            } catch (Exception $e) {
                $this->line($security->symbol . ': Unable to get data');
            }
        });
    }
}
